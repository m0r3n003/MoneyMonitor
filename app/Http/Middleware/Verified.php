<?php

namespace App\Http\Middleware;

use App\Models\Verificacion;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $verificacion = Verificacion::find((auth()->user()->VerificacionID));
        if ($verificacion->used == 1) {
            return $next($request);
        }
        return to_route('cargarVerificar');

    }
}
