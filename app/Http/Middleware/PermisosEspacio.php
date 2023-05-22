<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermisosEspacio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $espacio = session('EspacioID')['EspacioID'];
        $id = auth()->user()->UsuarioID;

        $permisos = DB::table('usuarioespacios')
        ->select('TipoPermisosID')
        ->where('EspacioID', $espacio)
        ->where('UsuarioID', $id)
        ->where('TipoPermisosID', '>', '0')
        ->where('borrado', '0')
        ->get();
        if (count($permisos) > 0) {
            return $next($request);
        } else {
            return to_route('index');
        }
    }
}
