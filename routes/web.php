<?php

use App\Http\Controllers\EspacioController;
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


Route::get('/',[EspacioController::class, 'getEspacios'])->name('index');
Route::post('/espacios/{EspacioID}',[EspacioController::class, 'tempFunction'])->name('escogerEspacio');


// FORMULARIOS DE AUTENTICACIÓN Y USUARIOS

Route::get('/login',[UsuarioController::class, 'cargarLogin'])->name('login');
Route::get('/register',[UsuarioController::class, 'cargarRegistrar'])->name('register');
Route::get('/logout',[UsuarioController::class, 'logout'])->name('logout');
Route::view('/terminos','auth.terminos')->name('terminos');
Route::post('/verificarAcceso', [UsuarioController::class, 'verificar'])->name('verificar');
Route::get('/verificar', [UsuarioController::class, 'cargarVerificar'])->name('cargarVerificar');
Route::post('/regenerateVerificationCode', [UsuarioController::class, 'regenerateVerificationCode'])->name('reenviarCodigo');

Route::post('/validateLogin', [UsuarioController::class, 'login'])->name('validateLogin');
Route::post('/validateRegister', [UsuarioController::class, 'register'])->name('validateRegister');
Route::post('/validateVerificar', [UsuarioController::class, 'verificar'])->name('validateVerificar');




Route::get('/register/sendVerficationMailTest', [UsuarioController::class, 'sendVerificationMailTest'])->name('sendVerificationMail');

// Route::post('/escogerEspacio' )

// Route::post('/register', function() {
//     return view('sections.auth.register');
// })->name('register');

// Route::post('/validateRegister', UsuarioController::validateRegister())->name('validateRegister');

