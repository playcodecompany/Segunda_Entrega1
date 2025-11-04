<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\User;
use App\Models\Turno;
use App\Models\Ranking;
use Illuminate\Support\Facades\DB;

class PartidaController extends Controller
{
    public function formCrear()
    {
        return view('crear');
    }

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

        // Asociar jugadores
        $jugadoresIds = collect($request->jugadores ?? [])->prepend($creador->id)->unique();
        foreach ($jugadoresIds as $jugadorId) {
            $partida->jugadores()->attach($jugadorId, ['puntuacion' => 0]);
            Ranking::firstOrCreate(
                ['jugador_id' => $jugadorId],
                ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
            );
        }

        // Crear turnos
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

    public function trackeo($codigoPartida)
    {
        $partida = Partida::with('jugadores')->findOrFail($codigoPartida);
        $jugadores = $partida->jugadores;
        $turnos = Turno::where('partida_id', $codigoPartida)->orderBy('orden')->get();
        $rankingJugadores = Ranking::whereIn('jugador_id', $jugadores->pluck('id'))->get()->keyBy('jugador_id');

        $animales = ['Serpiente', 'Tortuga', 'Caracol', 'Conejo', 'Ratón', 'Camello'];

        return view('trackeo', compact('codigoPartida', 'partida', 'jugadores', 'turnos', 'rankingJugadores', 'animales'));
    }

    public function registrarMovimiento(Request $request, $partidaId)
    {
        $request->validate([
            'jugador_id' => 'required|exists:users,id',
            'puntos' => 'required|integer|min:0',
            'animal' => 'required|string|max:50',
            'recinto' => 'required|string|max:50',
            'ronda' => 'required|integer|min:1',
        ]);

        $jugadorId = (int) $request->jugador_id;
        $puntos = (int) $request->puntos;

        DB::table('movimientos')->insert([
            'partida_id' => $partidaId,
            'jugador_id' => $jugadorId,
            'ronda' => $request->ronda,
            'animal' => $request->animal,
            'recinto' => $request->recinto,
            'puntos' => $puntos,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('partida_jugador')
            ->where('partida_id', $partidaId)
            ->where('jugador_id', $jugadorId)
            ->increment('puntuacion', $puntos);

        $puntosActuales = DB::table('partida_jugador')
            ->where('partida_id', $partidaId)
            ->where('jugador_id', $jugadorId)
            ->value('puntuacion');

        return response()->json([
            'success' => true,
            'jugador_id' => $jugadorId,
            'puntos_actuales' => (int) $puntosActuales,
        ]);
    }

    public function finalizarPartida(Request $request, $codigoPartida)
    {
        $partida = Partida::with('jugadores')->findOrFail($codigoPartida);
        $resultados = $request->input('resultados'); // en lugar de $request->json()->get('resultados')

        if (empty($resultados)) {
            return response()->json(['error' => 'No se recibieron resultados.'], 400);
        }

        $partida->fecha_fin = now();
        $partida->save();

        foreach ($resultados as $r) {
            DB::table('partida_jugador')
                ->where('partida_id', $partida->id)
                ->where('jugador_id', $r['jugador_id'])
                ->update(['puntuacion' => (int) $r['puntos']]);
        }

        $maxPuntos = DB::table('partida_jugador')
            ->where('partida_id', $partida->id)
            ->max('puntuacion');

        $ganadores = DB::table('partida_jugador')
            ->where('partida_id', $partida->id)
            ->where('puntuacion', $maxPuntos)
            ->pluck('jugador_id');

        $partida->ganador_id = $ganadores->first();
        $partida->save();

        foreach ($resultados as $r) {
            $ranking = Ranking::firstOrCreate(
                ['jugador_id' => $r['jugador_id']],
                ['partidas_jugadas' => 0, 'partidas_ganadas' => 0, 'puntos_totales' => 0]
            );

            $ranking->partidas_jugadas += 1;
            $ranking->puntos_totales += (int) $r['puntos'];

            if (in_array($r['jugador_id'], $ganadores->toArray())) {
                $ranking->partidas_ganadas += 1;
            }

            $ranking->save();
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Partida finalizada correctamente.',
            'ganadores' => $ganadores,
        ]);
    }

    public function resumenPartida($codigoPartida)
    {
        $partida = Partida::with('jugadores', 'movimientos.jugador')->findOrFail($codigoPartida);

        $jugadoresRanking = $partida->jugadores->map(function ($j) use ($partida) {
            $p = DB::table('partida_jugador')
                ->where('partida_id', $partida->id)
                ->where('jugador_id', $j->id)
                ->value('puntuacion');
            $j->pivot->puntuacion = (int) $p;
            return $j;
        })->sortByDesc(fn($j) => $j->pivot->puntuacion)
          ->values();

        $ganador = $jugadoresRanking->first();

        return view('resumen_partida', compact('partida', 'jugadoresRanking', 'ganador'));
    }
}
