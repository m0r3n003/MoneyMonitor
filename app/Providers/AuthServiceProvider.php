<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('cargarUsuarios', function() {

            $espacio = session('EspacioID')['EspacioID'];
            $id = auth()->user()->UsuarioID;

            $permisos = DB::table('usuarioespacios')
            ->select('TipoPermisosID')
            ->where('EspacioID', $espacio)
            ->where('UsuarioID', $id)
            ->where('TipoPermisosID', '>', '2')
            ->where('borrado', '0')
            ->get();

            if (count($permisos) > 0) {
                return true;
            } else {
                return false;
            }

        });
        Gate::define('cargarChat', function() {

            $espacio = session('EspacioID')['EspacioID'];
            $id = auth()->user()->UsuarioID;

            $permisos = DB::table('usuarioespacios')
            ->select('TipoPermisosID')
            ->where('EspacioID', $espacio)
            ->where('UsuarioID', $id)
            ->where('TipoPermisosID', '>', '1')
            ->where('borrado', '0')
            ->get();

            if (count($permisos) > 0) {
                return true;
            } else {
                return false;
            }

        });


    }
}
