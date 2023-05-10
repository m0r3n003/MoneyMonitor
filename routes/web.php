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

Route::get('/', function () {
    return view('sections.Index');
});


// FORMULARIOS DE AUTENTICACIÓN Y USUARIOS

Route::post('/login', function() {
    return view('sections.auth.login');
})->name('login');

Route::post('/validateLogin', [UsuarioController::class, 'validateLogin'])->name('validateLogin');

Route::post('/register', function() {
    return view('sections.auth.register');
})->name('register');

// Route::post('/validateRegister', UsuarioController::validateRegister())->name('validateRegister');

