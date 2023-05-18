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
        // $this->middleware('espacio.selected')->except('getEspacios', 'cargarEspacio');
    }
    /**
     * Display a listing of the resource.
     */


    public function getEspacios(Request $req) {
        $data = [];

        $espacios = DB::table('espacios')
        ->select('grupos.Nombre as NombreGrupo', 'espacios.GrupoID as GrupoID', 'espacios.Nombre as NombreEspacio','espacios.EspacioID')
        ->join('usuariosgrupos','espacios.GrupoID','=','usuariosgrupos.GrupoID')
        ->join('grupos','grupos.GrupoID','=','espacios.GrupoID')
        ->where(
            [
                'UsuarioID' => auth()->user()->UsuarioID,
            ]
            )
        ->orderBy('GrupoID')
        ->orderBy('NombreEspacio')
        ->get();

        $listaEspaciosFormatted = [];

        foreach ($espacios as $item) {
            $listaEspaciosFormatted[$item->GrupoID]['GrupoID'] = $item->GrupoID;
            $listaEspaciosFormatted[$item->GrupoID]['grupoNombre'] = $item->NombreGrupo;
            $listaEspaciosFormatted[$item->GrupoID]['espacios'][] = ['id' => $item->EspacioID, 'nombre' => $item->NombreEspacio];
        }


        return view('espacios.escogerEspacio', [
            'listaGrupos' => $listaEspaciosFormatted
        ]);




        // $listaGrupos = [
        //     'GrupoManolo' =>
        //         [
        //             'GrupoID'=>'12345', 'grupoNombre' =>'EspacioManolo', 'espacios' => [
        //                 ['id' => '123', 'nombre' => 'NombreEspacio']
        //             ]
        //         ]
        // ]
    }

    public function getEspacioInfo (Request $req) {
        $req->validate([

        ]);




        return view('espacios.main');
    }






    public function cargarEspacio (Request $req) {
        return to_route('escogerEspacio', $req->input('EspacioID'));
    }
}
