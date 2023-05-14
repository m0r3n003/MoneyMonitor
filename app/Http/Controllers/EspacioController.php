<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use App\Models\Verificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspacioController extends Controller
{

    public function __construct(){
        $this->middleware('auth.verified');
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */


    public function getEspacios(Request $req) {

        DB::table('espacios')
        ->select('espacios.GrupoID','EspacioID')
        ->join('usuariosgrupos','espacios.GrupoID','=','usuariosgrupos.GrupoID')
        ->where(
            [
                'UsuarioID' => auth()->user()->UsuarioID,
            ]
            )
        ->get();
    }

    public function tempFunction (Request $req) {
        return 0;
    }
}
