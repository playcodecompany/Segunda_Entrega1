<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\User;
use App\Models\Turno;
use App\Models\Ranking;

class PartidaController extends Controller
{
    /** Mostrar formulario para crear partida */
    public function formCrear()
    {
        return view('crear');
    }

    /** Guardar nueva partida y registrar jugadores */
    public function guardar(Request $request)
    {
        $creador = auth()->user();
        if (!$creador) {
            return redirect()->route('iniciosesion')->with('error', 'Debes iniciar sesión.');
        }

        $request->validate([
            'nombre_partida' => 'required|string|max:100',
            'jugadores' => 'array|max:4',
            'jugadores.*' => 'exists:users,id',
        ]);

        $partida = Partida::create([
            'creador_id' => $creador->id,
            'nombre' => $request->nombre_partida,
            'fecha_inicio' => now(),
        ]);

        // Asociar creador
        $partida->jugadores()->attach($creador->id, ['puntuacion' => 0]);
        Ranking::firstOrCreate(
            ['jugador_id' => $creador->id],
            ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
        );

        // Asociar jugadores seleccionados
        foreach ($request->jugadores ?? [] as $jugadorId) {
            if ($jugadorId != $creador->id) {
                $partida->jugadores()->attach($jugadorId, ['puntuacion' => 0]);
                Ranking::firstOrCreate(
                    ['jugador_id' => $jugadorId],
                    ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
                );
            }
        }

        // Crear turnos según orden de jugadores
        $orden = 1;
        foreach ($partida->jugadores as $jugador) {
            Turno::create([
                'partida_id' => $partida->id,
                'jugador_id' => $jugador->id,
                'orden' => $orden++,
            ]);
        }

        return redirect()->route('trackeo', ['codigoPartida' => $partida->id])
                         ->with('success', 'Partida creada correctamente.');
    }

    /** Mostrar pantalla de trackeo */
    public function trackeo($codigoPartida)
    {
        $partida = Partida::findOrFail($codigoPartida);
        $jugadores = $partida->jugadores;
        $turnos = Turno::where('partida_id', $codigoPartida)->orderBy('orden')->get();
        $rankingJugadores = Ranking::whereIn('jugador_id', $jugadores->pluck('id'))->get()->keyBy('jugador_id');

        $animales = ['Serpiente', 'Tortuga', 'Caracol', 'Conejo', 'Ratón', 'Camello'];

        return view('trackeo', compact('codigoPartida', 'partida', 'jugadores', 'turnos', 'rankingJugadores', 'animales'));
    }

    /** Registrar movimiento vía AJAX */
    public function registrarMovimiento(Request $request, $partidaId)
    {
        $request->validate([
            'jugador_id' => 'required|exists:users,id',
            'puntos' => 'required|integer|min:0',
            'animal' => 'required|string|max:50',
            'recinto' => 'required|string|max:50',
            'ronda' => 'required|integer|min:1',
        ]);

        $partida = Partida::findOrFail($partidaId);
        $jugadorId = $request->jugador_id;
        $puntos = $request->puntos;

        $partida->jugadores()->updateExistingPivot($jugadorId, [
            'puntuacion' => \DB::raw("puntuacion + $puntos"),
        ]);

        return response()->json([
            'success' => true,
            'jugador_id' => $jugadorId,
            'puntos_actuales' => $partida->jugadores()->find($jugadorId)->pivot->puntuacion,
        ]);
    }

    /** Finalizar partida y actualizar ranking */
   public function finalizarPartida($codigoPartida)
{
    // Cargar partida con jugadores
    $partida = Partida::with('jugadores')->findOrFail($codigoPartida);

    // Calcular el puntaje máximo de la partida
    $maxPuntos = $partida->jugadores->max(function($jugador){
        return $jugador->pivot->puntuacion;
    });

    // Obtener todos los jugadores con puntaje máximo (por si hay empate)
    $ganadores = $partida->jugadores->filter(fn($jugador) => $jugador->pivot->puntuacion == $maxPuntos);

    // Guardar el primer ganador (en caso de empate se puede mejorar para varios)
    $partida->ganador_id = $ganadores->first()->id;
    $partida->fecha_fin = now();
    $partida->save();

    // Actualizar ranking de cada jugador
    foreach ($partida->jugadores as $jugador) {
        $ranking = Ranking::firstOrCreate(
            ['jugador_id' => $jugador->id],
            ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
        );

        $ranking->partidas_jugadas += 1;
        $ranking->puntos_totales += $jugador->pivot->puntuacion;

        if ($jugador->id == $partida->ganador_id) {
            $ranking->partidas_ganadas += 1;
        }

        $ranking->save();
    }

    // Redirigir a la vista resumen de la partida
    return redirect()->route('resumen.partida', ['codigoPartida' => $codigoPartida])
                     ->with('success', 'Partida finalizada correctamente.');
}




    /** Resumen de partida */
   public function resumenPartida($codigoPartida)
{
    // Cargar la partida, los jugadores y los movimientos con su jugador
    $partida = Partida::with('jugadores', 'movimientos.jugador')->findOrFail($codigoPartida);

    // Ordenar jugadores por puntos descendente
    $jugadoresRanking = $partida->jugadores->sortByDesc(function($j){
        return $j->pivot->puntuacion;
    });

    // Pasar datos a la vista resumen_partida.blade.php
    return view('resumen_partida', compact('partida', 'jugadoresRanking'));
}

}
