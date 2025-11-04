<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\PerfilController;

// --------------------
// Rutas públicas
// --------------------

// Página principal
Route::get('/', function () {
    return view('home');
})->name('home');

// Registro de jugadores
Route::get('/registro', [RegisterController::class, 'create'])->name('registro');
Route::post('/registro', [RegisterController::class, 'store'])->name('registro.store');

// Login de jugadores
Route::get('/iniciosesion', [AuthController::class, 'showLogin'])->name('iniciosesion');
Route::post('/iniciosesion', [AuthController::class, 'login'])->name('login.store');

// Login de admin
Route::get('/sesionadmin', [AuthController::class, 'showAdminLogin'])->name('sesionadmin');
Route::post('/sesionadmin', [AuthController::class, 'loginAdmin'])->name('login.admin');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirección estándar para /login
Route::get('/login', function () {
    return redirect()->route('iniciosesion');
})->name('login');

// --------------------
// Rutas protegidas (solo autenticados)
// --------------------
Route::middleware(['auth'])->group(function () {

    // ----- ADMIN -----
    Route::get('/admin', [UserController::class, 'index'])->name('admin');
    Route::get('/admin/crearusuario', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/admin/crearusuario', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/admin/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/admin/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::get('/admin/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::delete('/admin/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    // ----- PARTIDAS -----
Route::get('/crear', [PartidaController::class, 'formCrear'])->name('crear.partida');
Route::post('/crear', [PartidaController::class, 'guardar'])->name('partidas.guardar');
Route::get('/trackeo/{codigoPartida}', [PartidaController::class, 'trackeo'])->name('trackeo');

Route::post('/partidas/{partida}/movimiento', [PartidaController::class, 'registrarMovimiento'])->name('partida.movimiento');
Route::post('/partidas/{partida}/actualizar-puntos', [PartidaController::class, 'actualizarPuntos'])->name('partida.actualizarPuntos');
Route::post('/partidas/{partida}/finalizar', [PartidaController::class, 'finalizarPartida'])->name('partida.finalizar');
Route::get('/partidas/{partida}/resumen', [PartidaController::class, 'resumenPartida'])->name('resumen.partida');



    // ----- PERFIL -----
    Route::get('/perfil', [PerfilController::class, 'perfil'])->name('perfil');
    Route::post('/perfil/guardar/{partida}', [PerfilController::class, 'guardar'])->name('perfil.guardar');
 

    

});
