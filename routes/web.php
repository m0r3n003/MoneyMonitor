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
Route::get('/espacios/{EspacioID}',[EspacioController::class, 'getEspacioInfo'])->name('escogerEspacio');
Route::get('/espacioSession/{EspacioID}',[EspacioController::class, 'espacioSession'])->name('changeEspacioSession');
Route::post('/espacios/cargarRuta',[EspacioController::class, 'cargarEspacio'])->name('cargarEspacio');


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


// FORMULARIOS PAGINA PRINCIPAL




Route::post('/cambiarConfiguracion/FormatoTabla', [EspacioController::class, 'cambiarFormatoTabla'])->name('cambiarFormatoTabla');
// Modulos
Route::get('/cargarChat/{EspacioID}', [EspacioController::class, 'cargarChat'])->name('cargarChat');
Route::get('/enviarMensaje/{EspacioID}', [EspacioController::class, 'enviarMensaje'])->name('enviarMensaje');

Route::post('/crearGrupo', [EspacioController::class, 'crearGrupo'])->name('crearGrupo');
Route::post('/crearEspacio', [EspacioController::class, 'crearEspacio'])->name('crearEspacio');
Route::post('/crearTransaccion', [EspacioController::class, 'crearTransaccion'])->name('crearTransaccion');
Route::post('/eliminarTransaccion', [EspacioController::class, 'eliminarTransaccion'])->name('eliminarTransaccion');
Route::post('/invitarUsuario', [EspacioController::class, 'invitarUsuario'])->name('invitarUsuario');
Route::post('/editarPermisos', [EspacioController::class, 'editarPermisos'])->name('editarPermisos');
