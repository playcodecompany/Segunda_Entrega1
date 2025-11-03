<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $fillable = [
        'partida_id',
        'jugador_id',
        'ronda',
        'animal',
        'recinto',
        'puntos',
    ];

    public $timestamps = true;

    /** Relación con la partida a la que pertenece */
    public function partida()
    {
        return $this->belongsTo(Partida::class, 'partida_id');
    }

    /** Relación con el jugador que hizo el movimiento */
    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'jugador_id');
    }
}
