<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth')->group(function () {
    // Aquí van todas las rutas que requieren autenticación, excepto las dos vistas públicas
});


Route::get('/', function () {
    return view('sections.espacios.main');
});


// FORMULARIOS DE AUTENTICACIÓN Y USUARIOS

Route::view('/login','auth.login')->name('login');
Route::view('/register','auth.register')->name('register');
Route::view('/terminos','auth.terminos')->name('terminos');

Route::post('/validateLogin', [UsuarioController::class, 'validateLogin'])->name('validateLogin');
Route::post('/validateRegister', [UsuarioController::class, 'validateRegister'])->name('validateRegister');

// Route::post('/escogerEspacio' )

// Route::post('/register', function() {
//     return view('sections.auth.register');
// })->name('register');

// Route::post('/validateRegister', UsuarioController::validateRegister())->name('validateRegister');

