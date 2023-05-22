<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Espacio;
use App\Models\Grupo;
use App\Models\Usuario;
use App\Models\Verificacion;
use App\Models\Mensaje;
use App\Models\Transaccion;
use App\Models\Usuarioespacio;
use App\Models\Usuariogrupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspacioController extends Controller
{

    public function __construct(){
        $this->middleware('auth.verified');
        $this->middleware('auth');
        $this->middleware('espacio.selected')->except('getEspacios', 'espacioSession');
        // $this->middleware('espacio.selected')->except('getEspacios', 'cargarEspacio');
    }
    /**
     * Display a listing of the resource.
     */


    public function getEspacios(Request $req) {
        $data = [];

        $espacios = DB::table('usuariosgrupos')
        ->select('grupos.Nombre as NombreGrupo', 'grupos.GrupoID as GrupoID', 'espacios.Nombre as NombreEspacio','espacios.EspacioID')
        ->leftJoin('espacios','usuariosgrupos.GrupoID','espacios.GrupoID')
        ->join('grupos','grupos.GrupoID','usuariosgrupos.GrupoID')
        ->where(
            [
                'UsuarioID' => auth()->user()->UsuarioID,
                'grupos.borrado'=> '0',
                'usuariosgrupos.borrado' => '0'
            ]
            )
        ->orderBy('GrupoID')
        ->orderBy('NombreEspacio')
        ->get();
        // dd($espacios);
        $listaEspaciosFormatted = [];

        foreach ($espacios as $item) {
            $listaEspaciosFormatted[$item->GrupoID]['GrupoID'] = $item->GrupoID;
            $listaEspaciosFormatted[$item->GrupoID]['grupoNombre'] = $item->NombreGrupo;
            if ($item->EspacioID != null) {
                $listaEspaciosFormatted[$item->GrupoID]['espacios'][] = ['id' => $item->EspacioID, 'nombre' => $item->NombreEspacio];
            }
        }

        // dd($listaEspaciosFormatted);

        return view('espacios.escogerEspacio', [
            'listaGrupos' => $listaEspaciosFormatted
        ]);
    }
    public function espacioSession(Espacio $EspacioID) {

        session(['EspacioID' => $EspacioID]);

        return to_route('escogerEspacio', $EspacioID['EspacioID']);

    }

    public function getEspacioInfo (Espacio $EspacioID) {
        if (session('EspacioID') == null) {
            return to_route('index');
        }

        $espacioInfo = Espacio::find($EspacioID);
        if (count($espacioInfo) > 0) {
            $espacioInfo= $espacioInfo[0];
        }



        $mes = date('m');
        $transacciones = DB::table('transacciones')
                        ->select('TransaccionID', 'Descripcion', 'Cuantia')
                        ->selectRaw('DAY(Fecha) as Dia')
                        ->selectRaw("DATE_FORMAT(Fecha, '%d/%m/%Y') as DiaFormateado")
                        ->whereRaw('MONTH(Fecha) = '.$mes)
                        ->where('EspacioID', session('EspacioID')['EspacioID'])
                        ->where('borrado', '0')
                        ->orderBy('Fecha', 'Asc')
                        ->get();

        $transaccionesFormateado = [];
        $transaccionesFormateado['chart'] = [];
        $transaccionesFormateado['table'] = [];
            if (count($transacciones) > 0) {
            for ($i=0; $i < count($transacciones); $i++) {
                if (!isset($transaccionesFormateado['chart'][$transacciones[$i]->Dia])) {
                    $transaccionesFormateado['chart'][$transacciones[$i]->Dia] = 0;
                }
                $transaccionesFormateado['chart'][$transacciones[$i]->Dia] += $transacciones[$i]->Cuantia;

            }


            for ($i=0; $i < count($transacciones); $i++) {
                $transaccionesFormateado['table'][] = [
                    'TransaccionID' => $transacciones[$i]->TransaccionID,
                    'Descripcion' => $transacciones[$i]->Descripcion,
                    'Cuantia' => $transacciones[$i]->Cuantia,
                    'Dia' => $transacciones[$i]->Dia,
                    'DiaFormateado' => $transacciones[$i]->DiaFormateado,
                ];

            }
            $labelsChart = [];
            foreach ($transaccionesFormateado['chart'] as $key => $data) {
                $labelsChart[] = $key;
            }
            $dataChart = [];
            foreach ($transaccionesFormateado['chart'] as $key => $data) {
                $dataChart[] = $data;
            }


        }

        $usuarios = DB::table('usuarioespacios')
        ->join('usuarios', 'usuarioespacios.UsuarioID', 'usuarios.UsuarioID')
                                ->join('usuariosgrupos', 'usuariosgrupos.UsuarioID', 'usuarios.UsuarioID')
                                ->join('tipopermisos', 'usuarioespacios.TipoPermisosID', 'tipopermisos.TipoPermisosID')
                                ->select('usuarios.username', 'usuarios.UsuarioID', 'tipopermisos.TipoPermisos')
                                ->selectRaw('CONCAT(usuarios.Nombre, " ", usuarios.Apellidos) as Nombre')
                                ->orderBy('Nombre')
                                ->where([
                                    'usuarios.borrado' => '0',
                                    'usuarioespacios.EspacioID'=> '1',
                                    'usuarioespacios.borrado'=> '0',
                                    'GrupoID' => $EspacioID->GrupoID
                                    ])
                                ->get();
        // dd($usuarios);
        $usuariosFormateado = [];
        // dd($usuarios);
        if (count($usuarios) > 0) {
            foreach ($usuarios as $key => $usuario) {
                $usuariosFormateado[] = [
                    'UsuarioID' => $usuario->UsuarioID,
                    'Nombre' => $usuario->Nombre,
                    'username' => $usuario->username,
                    'Permisos' => $usuario->TipoPermisos
                ];
            }
        }
        $configuracion = DB::table('usuarioespacios')
                            ->join('configuraciones', 'usuarioespacios.ConfiguracionID', 'configuraciones.ConfiguracionID')
                            ->join('tipoformatotabla', 'configuraciones.TipoFormatoTablaID', 'tipoformatotabla.TipoFormatoTablaID')
                            ->select('configuraciones.ConfiguracionID as ConfiguracionID', 'TipoFormatoTabla')
                            ->where('usuarioespacios.borrado', '0')
                            ->where('configuraciones.borrado', '0')
                            ->where('EspacioID', $EspacioID->EspacioID)
                            ->where('UsuarioID', auth()->user()->UsuarioID)
                            ->get();
        $configuracionID = 0;
        if (count($configuracion) > 0) {
            $configuracionID = $configuracion[0]->ConfiguracionID;
            $configuracion = $configuracion[0]->TipoFormatoTabla;
        } else {
            $configuracion = null;
        }


        $formatosTabla = DB::table('tipoformatotabla')
                            ->select('TipoFormatoTablaID', 'TipoFormatoTabla')
                            ->where('borrado', '0')
                            ->get();
        $formatosTablaFormateado = [];
        if (count($formatosTabla) > 0) {
            foreach ($formatosTabla as $formato) {
                $formatosTablaFormateado[] = [
                    'FormatoTablaID' => $formato->TipoFormatoTablaID,
                    'FormatoTabla' => $formato->TipoFormatoTabla
                ];
            }
        }

        $permisosTabla = DB::table('tipopermisos')->select('TipoPermisosID', 'TipoPermisos')->where('TipoPermisosID', '<', 4)->where('TipoPermisosID', '>', '0')->get();
        $permisos = [];
        foreach($permisosTabla as $value) {
            $permisos[] = [
                'TipoPermisosID' => $value->TipoPermisosID,
                'TipoPermisos' => $value->TipoPermisos
            ];
        }

        // dd($transaccionesFormateado);
        return view('espacios.main', ['espacio' => $espacioInfo,
                                        'chart' => $transaccionesFormateado['chart'],
                                        'tabla' => $transaccionesFormateado['table'],
                                        'usuarios' => $usuariosFormateado,
                                        'tipoformatotabla' => $configuracion,
                                        'formatosTabla' => $formatosTablaFormateado,
                                        'ConfiguracionID' => $configuracionID,
                                        'permisos' => $permisos
                                    ]);
    }










    public function cargarEspacio (Request $req) {
        return to_route('escogerEspacio', $req->input('EspacioID'));
    }





    public function cargarChat (Espacio $EspacioID) {
        $mensajes = DB::table('mensajes')
        ->where('borrado', '0')
        ->where('EspacioID', $EspacioID->EspacioID)
        ->orderBy('created_at', 'asc')
        ->get();

        $datos = [];

        foreach($mensajes as $mensaje) {
            $usuario = Usuario::find($mensaje->FromID);
            $datos[] = [
                'MensajeID' => $mensaje->MensajeID,
                'Mensaje' => $mensaje->Mensaje,
                'From' => [
                    'Username' => $usuario->username,
                    'Nombre' => $usuario->Nombre
                ],
                'Fecha' => $mensaje->created_at
            ];
        }
        // dd($EspacioID);
        return json_encode($datos);

    }
    public function enviarMensaje(Espacio $EspacioID, Request $req) {
        $req->validate([
            'from' => 'required',
            'contenido' => 'required|max:200|string'
        ]);
        if ($req->input('from') != auth()->user()->UsuarioID) {
            return false;
        }

        $mensaje = new Mensaje();
        $mensaje->Mensaje = $req->input('contenido');
        $mensaje->FromID = $req->input('from');
        $mensaje->EspacioID = $EspacioID->EspacioID;
        $mensaje->save();

        return true;

    }




    // Formularios

    public function cambiarFormatoTabla(Request $req) {
        $configuracion = Configuracion::find($req->input('ConfiguracionID'));
        $configuracion->TipoFormatoTablaID = $req->input('formatoTabla');
        $configuracion->save();
        return to_route('escogerEspacio', session('EspacioID')['EspacioID']);
    }


    public function crearGrupo (Request $req) {
        $req->validate([
            'nombreGrupo' => 'required|string|max:45'
        ]);

        $nuevoGrupo = new Grupo();
        $nuevoGrupo->Nombre = $req->input('nombreGrupo');
        $nuevoGrupo->AdministradorID = auth()->user()->UsuarioID;
        $nuevoGrupo->save();


        $usuarioGrupo = new Usuariogrupo();
        $usuarioGrupo->GrupoID = $nuevoGrupo->GrupoID;
        $usuarioGrupo->UsuarioID = $nuevoGrupo->AdministradorID;
        $usuarioGrupo->save();





        return to_route('index');
    }

    public function crearEspacio (Request $req) {
        $req->validate([
            'GrupoID' => 'required',
            'nombreEspacio' => 'required|string|max:45'
        ]);

        $nuevoEspacio = new Espacio();
        $nuevoEspacio->Nombre = $req->input('nombreEspacio');
        $nuevoEspacio->GrupoID = $req->input('GrupoID');
        $nuevoEspacio->save();


        $usuarioEspacio = new Usuarioespacio();
        $usuarioEspacio->EspacioID = $nuevoEspacio->EspacioID;
        $usuarioEspacio->UsuarioID = auth()->user()->UsuarioID;
        $usuarioEspacio->TipoPermisosID = 4;
        $usuarioEspacio->ConfiguracionID = 1;
        $usuarioEspacio->save();





        return to_route('index');
    }
    public function crearTransaccion (Request $req) {
        $req->validate([
            'EspacioID' => 'required',
            'descripcion' => 'required|string|max:40',
            'cantidad' => 'required',
            'fecha' => 'required|date'
        ]);
        if ($req->has('TransaccionID')) {
            $nuevoTransaccion = Transaccion::find($req->input('TransaccionID'));
        } else {

            $nuevoTransaccion = new Transaccion();
            $nuevoTransaccion->EspacioID = $req->input('EspacioID');
        }
        $nuevoTransaccion->Descripcion = $req->input('descripcion');
        $nuevoTransaccion->Cuantia = $req->input('cantidad');
        $nuevoTransaccion->Fecha = $req->input('fecha');
        $nuevoTransaccion->save();





        return to_route('escogerEspacio', $req->input('EspacioID'));
    }

    public function eliminarTransaccion (Request $req) {
        $transaccion = Transaccion::find($req->input('TransaccionID'));
        $transaccion->borrado = 1;
        $transaccion->save();
        return to_route('escogerEspacio', session('EspacioID')['EspacioID']);
    }
    public function invitarUsuario( Request $req ) {
        // dd($req);
        $usuarios = DB::table('usuarios')->select('UsuarioID')->where('email', $req->input('email'))->get();
        $espacio = Espacio::find($req->input('EspacioID'));

        if (count($usuarios) > 0) {
            // dd($usuarios);
            $usuario = Usuario::find($usuarios[0]->UsuarioID);
            $usuarioespacios = DB::table('usuarioespacios')->select('UsuarioID')->where('UsuarioID', $usuario->UsuarioID)->where('EspacioID', $espacio->EspacioID)->get();
            if (count($usuarioespacios) == 0) {
                $config = new Configuracion();
                $config->TipoFormatoTablaID = 1;
                $config->save();
                $uses = new Usuarioespacio();
                $uses->UsuarioID = $usuario->UsuarioID;
                $uses->EspacioID = $espacio->EspacioID;
                $uses->TipoPermisosID = 1;
                $uses->ConfiguracionID = $config->ConfiguracionID;
                $uses->save();
            }
            $usuariosgrupos = DB::table('usuariosgrupos')->select('UsuarioID')->where('UsuarioID', $usuario->UsuarioID)->where('GrupoID', $espacio->GrupoID)->get();
            if (count($usuariosgrupos) == 0 ) {
                $uses = new Usuariogrupo();
                $uses->UsuarioID = $usuario->UsuarioID;
                $uses->GrupoID = $espacio->GrupoID;
                $uses->save();
            }
        }
        return to_route('escogerEspacio', $espacio->EspacioID);


    }
    public function editarPermisos (Request $req) {
        $usuariosesp = DB::table('usuarios')->join('usuarioespacios', 'usuarios.UsuarioID', 'usuarioespacios.UsuarioID')->select('UsuarioEspaciosID')->where([
            'usuarios.UsuarioID'=> $req->input('UsuarioID'),
            'usuarioespacios.EspacioID'=> $req->input('EspacioID')
        ])->get();
        if (count($usuariosesp) > 0) {
            $usuariosesp = Usuarioespacio::find($usuariosesp[0]->UsuarioEspaciosID);
            $usuariosesp->TipoPermisosID = $req->input('TipoPermisosID');
            $usuariosesp->save();
        }


        return to_route('escogerEspacio', $req->input('EspacioID'));

    }
}
