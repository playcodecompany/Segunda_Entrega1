




<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Página de inicio
Route::get('/', function () {
    return view('home');
})->name('home');

// Página de juego / tablero
Route::get('/jugar', function () {
    $nombre = 'Usuario'; // O traer desde auth/session
    return view('juego', compact('nombre'));
})->name('jugar');

// Crear partida
Route::post('/crear-partida', function (Request $request) {
    // Generar código de partida
    $codigoPartida = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

    // Guardar en sesión (opcional)
    $request->session()->put('codigoPartida', $codigoPartida);

    // Redirigir a trackeo
    return redirect()->route('trackeo', ['codigoPartida' => $codigoPartida]);
})->name('crear_partida');

// Unirse a partida
Route::post('/unirse-partida', function (Request $request) {
    $codigoPartida = $request->input('codigo_partida');

    if (!$codigoPartida) {
        return back()->with('mensajeUnirse', 'Debe ingresar un código de partida.');
    }

    // Guardar en sesión (opcional)
    $request->session()->put('codigoPartida', $codigoPartida);

    // Redirigir a trackeo
    return redirect()->route('trackeo', ['codigoPartida' => $codigoPartida]);
})->name('unirse_partida');

// Página de trackeo
Route::get('/trackeo/{codigoPartida}', function ($codigoPartida) {
    $animales = ['Serpiente', 'Camello', 'Conejo', 'Tortuga', 'Caracol', 'Ratón'];
    return view('trackeo', compact('codigoPartida', 'animales'));
})->name('trackeo');

// Panel de usuario
Route::get('/panel', function () {
    $nombre = 'Usuario';
    $partidas = []; // Reemplazar con datos reales
    $estadisticas = [
        'total_partidas' => 0,
        'puntaje_maximo' => 0,
        'puntaje_promedio' => 0
    ];
    return view('panel', compact('nombre','partidas','estadisticas'));
})->name('panel');

// Registro
Route::get('/registro', function () {
    return view('registro');
})->name('registro');

// Iniciar sesión
Route::get('/iniciosesion', function () {
    return view('iniciosesion');
})->name('iniciosesion');
