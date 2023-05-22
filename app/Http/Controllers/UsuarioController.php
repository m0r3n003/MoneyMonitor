<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use App\Models\Espacio;
use App\Models\Usuario;
use App\Models\Verificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException as ValidationException;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except('logout', 'verificar', 'cargarVerificar','regenerateVerificationCode', 'sendVerificationMail');
    }


    public function login(Request $req) {
        $this->validateDataLogin($req);

        $user = (DB::table('usuarios')->select('UsuarioID')->where('username', $req->input('login'))->get());
        if (count($user) > 0) {
            $user = $user[0]->UsuarioID;
        } else {
            throw ValidationException::withMessages([
                'login' => __('auth.failed')
            ]);
        }


        $user = Usuario::find($user);

        $credentials = [
            'username' => $req->input('login'),
            'password' => $req->input('password')

        ];
        if (!Auth::attempt($credentials, $req->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => 'Estas credenciales no coinciden con nuestros registros'
            ]);
            //return back();
        }
        $req->session()->regenerate();
        $verificacion = Verificacion::find(auth()->user()->VerificacionID);
        if ($verificacion->used == 1) {
            return redirect()->intended();
        } else {
            return to_route('cargarVerificar');
        }
    }
    public function logout(Request $req) {
        Auth::guard('web')->logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return to_route('login');

    }
    public function register (Request $req) {

        $reqValidated = $this->validateDataRegister($req);

        $usuario = new Usuario($reqValidated);
        $verificacion = new Verificacion([
            'VerificationCode' => random_int(0, 999999)
        ]);
        $verificacion->save();

        $usuario->VerificacionID = $verificacion->VerificacionID;
        $usuario->password = Hash::make($req->input('password'));

        $usuario->save();

        $this->sendVerificationMail($verificacion->VerificationCode, $usuario->email);

        // return view('auth.verification', ['user' => $usuario->UsuarioID]);
        return to_route('login');
    }
    public function verificar (Request $req) {
        $this->validateDataVerificar($req);

        $verificacion = Verificacion::find(auth()->user()->VerificacionID);

        if ($req->input('verificacion') == $verificacion->VerificationCode) {
            $verificacion->used = 1;
            $verificacion->save();
            return to_route('index');
        } else {
            throw ValidationException::withMessages([
                'verificacion' => 'El número de verificación no es correcto'
            ]);
        }
    }


    public function cargarVerificar(Request $req) {
        return view('auth.verification');
    }
    public function regenerateVerificationCode(Request $req) {
        error_log('llegas?');
        $verificacion = Verificacion::find(auth()->user()->VerificacionID);
        $verificacion->VerificationCode= random_int(0, 999999);
        $verificacion->save();



        $this->sendVerificationMail($verificacion->VerificationCode, auth()->user()->email);


    }
    public function cargarRegistrar() {
        $cargos = DB::table('tipousuarios')->select('TipoUsuarioID', 'TipoUsuario')->where('borrado', '0')->orderBy('TipoUsuario')->get();

        return view('auth.register', ['cargos'=> $cargos]);
    }
    public function cargarLogin() {
        return view('auth.login');
    }



    public function sendVerificationMail($code, $mail) {
        $mailContacto = new VerificationMail($code);
        Mail::to($mail)->send($mailContacto);
    }








    public function validateDataRegister(Request $req) {
        // dd($req);
        return $req->validate([
            'username' => 'required|max:15',
            'Nombre' => 'required',
            'Apellidos' => 'required',
            'TipoUsuarioID' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
    }
    public function validateDataLogin(Request $req) {
        return $req->validate([
            'login' => 'required|max:15',
            'password' => 'required'
        ]);
    }
    public function validateDataVerificar(Request $req) {
        return $req->validate([
            'verificacion' => 'required'
        ]);
    }
}
