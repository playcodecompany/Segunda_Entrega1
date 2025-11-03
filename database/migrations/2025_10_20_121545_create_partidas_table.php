<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Jugador;
use App\Models\Participante;
use App\Models\Movimiento;
use App\Models\Ranking;

class PartidaController extends Controller
{
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
            'jugadores.*' => 'exists:jugadores,id',
        ]);

        $partida = Partida::create([
            'creador_id' => $creador->id,
            'nombre' => $request->nombre_partida,
            'ronda_actual' => 1,
        ]);

        // Crear participantes
        $participante = Participante::create([
            'partida_id' => $partida->id,
            'jugador_id' => $creador->id,
            'fichas_en_mano' => 6,
            'puntos_actuales' => 0,
        ]);

        foreach ($request->jugadores ?? [] as $jugadorId) {
            if ($jugadorId != $creador->id) {
                Participante::create([
                    'partida_id' => $partida->id,
                    'jugador_id' => $jugadorId,
                    'fichas_en_mano' => 6,
                    'puntos_actuales' => 0,
                ]);
            }
        }

        return redirect()->route('trackeo', ['codigoPartida' => $partida->id])
                         ->with('success', 'Partida creada correctamente.');
    }

    /** Mostrar pantalla de trackeo */
    public function trackeo($codigoPartida)
    {
        $partida = Partida::with('participantes.jugador')->findOrFail($codigoPartida);
        $participantes = $partida->participantes;
        $movimientos = Movimiento::where('partida_id', $codigoPartida)->orderBy('created_at')->get();
        $rankingJugadores = Ranking::whereIn('jugador_id', $participantes->pluck('jugador_id'))->get()->keyBy('jugador_id');
        $animales = ['Serpiente', 'Tortuga', 'Caracol', 'Conejo', 'Ratón', 'Camello'];

        return view('trackeo', compact('codigoPartida', 'partida', 'participantes', 'movimientos', 'rankingJugadores', 'animales'));
    }

    /** Registrar movimiento y controlar fichas/rondas */
    public function registrarMovimiento(Request $request, $partidaId)
    {
        $request->validate([
            'jugador_id' => 'required|exists:jugadores,id',
            'puntos' => 'required|integer|min:0',
            'animal' => 'required|string|max:50',
            'recinto' => 'required|string|max:50',
        ]);

        $partida = Partida::with('participantes')->findOrFail($partidaId);
        $jugadorId = $request->jugador_id;
        $puntos = $request->puntos;

        $participante = $partida->participantes->where('jugador_id', $jugadorId)->first();
        if (!$participante) return response()->json(['success'=>false,'message'=>'Jugador no encontrado']);

        // Registrar movimiento
        Movimiento::create([
            'partida_id' => $partida->id,
            'jugador_id' => $jugadorId,
            'ronda' => $partida->ronda_actual,
            'animal' => $request->animal,
            'recinto' => $request->recinto,
            'puntos' => $puntos,
        ]);

        // Actualizar participante
        $participante->fichas_en_mano -= 1;
        $participante->puntos_actuales += $puntos;
        $participante->save();

        // Cambio de ronda si todos en 0
        $todosCero = $partida->participantes->every(fn($p)=>$p->fichas_en_mano==0);

        if ($todosCero) {
            $partida->ronda_actual += 1;

            if ($partida->ronda_actual > 2) {
                $this->finalizarPartida($partida->id);
            } else {
                foreach ($partida->participantes as $p) {
                    $p->fichas_en_mano = 6;
                    $p->save();
                }
            }

            $partida->save();
        }

        return response()->json([
            'success'=>true,
            'jugador_id'=>$jugadorId,
            'puntos_actuales'=>$participante->puntos_actuales,
            'fichas_restantes'=>$participante->fichas_en_mano,
            'ronda_actual'=>$partida->ronda_actual,
        ]);
    }

    /** Finalizar partida y actualizar ranking */
    public function finalizarPartida($partidaId)
    {
        $partida = Partida::with('participantes.jugador')->findOrFail($partidaId);

        // Determinar ganador
        $ganador = $partida->participantes->sortByDesc('puntos_actuales')->first();
        $partida->ganador_id = $ganador->jugador_id;
        $partida->fecha_fin = now();
        $partida->save();

        // Actualizar ranking
        foreach ($partida->participantes as $p) {
            $ranking = Ranking::firstOrCreate(
                ['jugador_id' => $p->jugador_id],
                ['partidas_jugadas'=>0,'partidas_ganadas'=>0,'puntos_totales'=>0]
            );

            $ranking->partidas_jugadas += 1;
            $ranking->puntos_totales += $p->puntos_actuales;
            if ($p->jugador_id == $ganador->jugador_id) $ranking->partidas_ganadas += 1;
            $ranking->save();
        }
    }
}
