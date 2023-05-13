<?php

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(usuarios $usuarios)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(usuarios $usuarios)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, usuarios $usuarios)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(usuarios $usuarios)
    // {
    //     //
    // }

    public function validateLogin(Request $req) {
        if ($req->has('username')){
            return view('components.sections.espacios.main', ['username' => $req->input('username')]);
        }
        return redirect('/login');
    }

    public function cargarRegistrar() {
        Mail::to('tmorenodelafuente@gmail.com', 'asunto', 'te ha llegao?');

        $cargos = DB::table('tipousuarios')->select('TipoUsuarioID', 'TipoUsuario')->where('borrado', '0')->orderBy('TipoUsuario')->get();

        return view('auth.register', ['cargos'=> $cargos]);
    }
    public function register (Request $req) {
        $reqValidated = $this->validateDataRegister($req);
    }
    public function validateDataRegister(Request $req) {
        return $req->validate([

        ]);
    }


    public function sendVerificationMail() {
        $mailContacto = new VerificationMail('funciona esto?');
        Mail::to('tmorenodelafuente@gmail.com')->send($mailContacto);
        to_route('login');
    }

    public function getVerificationCode() {

    }


}
