<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';

    protected $fillable = [
        'creador_id',
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'duracion',
        'ganador_id'
    ];

    public $timestamps = true;

    // Relación con jugadores (tabla pivote partida_jugador)
    public function jugadores()
    {
        return $this->belongsToMany(User::class, 'partida_jugador', 'partida_id', 'jugador_id')
                    ->withPivot('puntuacion', 'turno')
                    ->withTimestamps();
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    public function ganador()
    {
        return $this->belongsTo(User::class, 'ganador_id');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function calcularDuracion()
    {
        if ($this->fecha_inicio && $this->fecha_fin) {
            $this->duracion = $this->fecha_inicio->diffInMinutes($this->fecha_fin);
            $this->save();
        }
    }

    public function puntajeMaximo()
    {
        return $this->jugadores->max(fn($j) => $j->pivot->puntuacion);
    }

    public function obtenerGanadores()
    {
        $max = $this->puntajeMaximo();
        return $this->jugadores->filter(fn($j) => $j->pivot->puntuacion == $max);
    }
}
