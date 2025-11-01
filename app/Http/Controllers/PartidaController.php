<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Jugador;
use App\Models\JugadorPartida;
use App\Models\Turno;
use App\Models\Ranking;

class PartidaController extends Controller
{
    // Mostrar formulario de crear partida
    public function formCrear()
    {
        $jugadores = Jugador::all(); // Para mostrar lista de jugadores con sus IDs
        return view('crear', compact('jugadores'));
    }

    // Guardar nueva partida
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre_partida' => 'required|string|max:100',
            'jugadores' => 'array|max:4', // hasta 4 jugadores adicionales
            'jugadores.*' => 'exists:jugadores,id', // validar que existan en DB
        ]);

        // Creador de la partida (usuario logueado)
        $creador = auth()->user();

        // Crear partida
        $partida = Partida::create([
            'creador_id' => $creador->id,
            'fecha_inicio' => now(),
        ]);

        // Asociar al creador
        $partida->jugadores()->attach($creador->id, ['puntuacion' => 0]);
        Ranking::firstOrCreate(
            ['jugador_id' => $creador->id],
            ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
        );

        // Asociar jugadores adicionales
        $jugadoresIds = $request->jugadores ?? [];
        foreach ($jugadoresIds as $jugadorId) {
            $partida->jugadores()->attach($jugadorId, ['puntuacion' => 0]);
            Ranking::firstOrCreate(
                ['jugador_id' => $jugadorId],
                ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
            );
        }

        // Crear turnos automáticamente (orden: creador primero, luego demás)
        $orden = 1;
        foreach ($partida->jugadores as $jugador) {
            Turno::create([
                'partida_id' => $partida->id,
                'jugador_id' => $jugador->id,
                'orden' => $orden++
            ]);
        }

        // Guardar código de partida en sesión para seguimiento
        $request->session()->put('codigoPartida', $partida->id);

        // Redirigir a la vista de trackeo
        return redirect()->route('trackeo', ['codigoPartida' => $partida->id]);
    }

    // Trackeo de partida
    public function trackeo($codigoPartida)
    {
        $partida = Partida::findOrFail($codigoPartida);
        $jugadores = $partida->jugadores; // Relación pivot jugador_partida
        $turnos = Turno::where('partida_id', $codigoPartida)->orderBy('orden')->get();

        // Traer ranking de los jugadores de la partida
        $rankingJugadores = Ranking::whereIn('jugador_id', $jugadores->pluck('id'))->get()->keyBy('jugador_id');

        return view('trackeo', compact('codigoPartida', 'partida', 'jugadores', 'turnos', 'rankingJugadores'));
    }

    // Finalizar partida y actualizar ranking
    public function finalizarPartida($codigoPartida)
    {
        $partida = Partida::findOrFail($codigoPartida);

        foreach ($partida->jugadores as $jugador) {
            $puntuacion = $jugador->pivot->puntuacion;

            $ranking = Ranking::firstOrCreate(
                ['jugador_id' => $jugador->id],
                ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
            );

            $ranking->partidas_jugadas += 1;
            $ranking->puntos_totales += $puntuacion;

            // Si es ganador
            if ($partida->ganador_id == $jugador->id) {
                $ranking->partidas_ganadas += 1;
            }

            $ranking->save();
        }

        $partida->fecha_fin = now();
        $partida->save();

        return redirect()->route('trackeo', ['codigoPartida' => $codigoPartida]);
    }
}
