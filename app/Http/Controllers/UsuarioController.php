<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use App\Models\Usuario;
use App\Models\Verificacion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UsuarioController extends Controller
{

    public function login(Request $req) {
        $this->validateDataLogin($req);

        $user = (DB::table('usuarios')->select('UsuarioID')->where('username', $req->input('login'))->get())[0]->UsuarioID;


        $user = Usuario::find($user);
        if ($user->username == $req->input('login') && Hash::check($req->input('password'), $user->password)) {
            return 'Usuario y contraseña correctos';
        }
        else {
            return back();
        }

        return 0;
    }
    public function register (Request $req) {

        $reqValidated = $this->validateDataRegister($req);

        $usuario = new Usuario($reqValidated);
        $verificacion = new Verificacion([
            'VericationCode' => random_int(0, 999999)
        ]);
        $verificacion->save();
        // dd($verificacion);
        $usuario->VerificacionID = $verificacion->VerificacionID;
        $usuario->password = Hash::make($req->input('password'));

        $usuario->save();

        $this->sendVerificationMail($verificacion->VericationCode, $usuario->email);

        // return view('auth.verification', ['user' => $usuario->UsuarioID]);
        return to_route('cargarVerificar', ['user' => $usuario->UsuarioID]);
    }
    public function cargarVerificar(Request $req) {
        return view('auth.verification', ['user' => $req->input('user')]);
    }




    public function verificar (Request $req) {
        // dd($req);
        $this->validateDataVerificar($req);

        $usuario = Usuario::find($req->input('userID'));
        $verificacion = Verificacion::find($usuario->VerificacionID);

        // dd($verificacion);
        if ($req->input('verificacion') == $verificacion->VerificationCode) {
            $verificacion->used = 1;
            $verificacion->save();
            return to_route('escogerEspacio');
        } else {
            return back();
        }
    }
    public function cargarRegistrar() {
        $cargos = DB::table('tipousuarios')->select('TipoUsuarioID', 'TipoUsuario')->where('borrado', '0')->orderBy('TipoUsuario')->get();

        return view('auth.register', ['cargos'=> $cargos]);
    }




    public function sendVerificationMail($code, $mail) {
        $mailContacto = new VerificationMail($code);
        Mail::to($mail)->send($mailContacto);
    }

    public function getVerificationCode($verificacionID) {
        return (DB::table('verifiaciones')->select('VerificationCode')->where('VerificationID', $verificacionID)->get())[0]->VerificationCode;
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
            'userID' => 'required',
            'verificacion' => 'required'
        ]);
    }
}
