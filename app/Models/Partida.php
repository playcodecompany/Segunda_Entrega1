<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';
    protected $fillable = ['creador_id', 'num_jugadores', 'fecha_inicio', 'fecha_fin', 'ganador_id'];
    public $timestamps = false;

    // Relación con jugadores
    public function jugadores()
    {
        return $this->belongsToMany(Jugador::class, 'jugador_partida')
                    ->withPivot('puntuacion');
    }

    // Creador de la partida
    public function creador()
    {
        return $this->belongsTo(Jugador::class, 'creador_id');
    }

    // Ganador de la partida
    public function ganador()
    {
        return $this->belongsTo(Jugador::class, 'ganador_id');
    }
}
