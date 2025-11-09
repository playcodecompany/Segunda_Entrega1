<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\Partida;
use App\Models\Ranking;

class PerfilController extends Controller
{
    //Mostrar perfil del usuario logueado 
    public function perfil()
{
    $usuario = auth()->user();

    //Obtener todas las partidas del usuario
    $partidas = $usuario->partidas()->with('jugadores')->orderBy('fecha_fin', 'desc')->get();

    //Total de puntos acumulados
    $puntos_totales = $partidas->sum('pivot.puntuacion');

    //Número de partidas jugadas
    $partidas_jugadas = $partidas->count();

    //Número de partidas ganadas
    $partidas_ganadas = 0;
    foreach ($partidas as $partida) {
        $max_puntos = $partida->jugadores->max(function($j) {
            return $j->pivot->puntuacion;
        });

        if ($partida->pivot->puntuacion == $max_puntos) {
            $partidas_ganadas++;
        }
    }

    return view('auth.perfil', compact(
        'usuario',
        'partidas',
        'puntos_totales',
        'partidas_jugadas',
        'partidas_ganadas'
    ));
}

}
