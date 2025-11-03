<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participantes';
    protected $fillable = [
        'partida_id',
        'jugador_id',
        'fichas_en_mano',
        'puntos_actuales',
    ];

    public $timestamps = true;

    /** Relación con la partida a la que pertenece */
    public function partida()
    {
        return $this->belongsTo(Partida::class, 'partida_id');
    }

    /** Relación con el jugador */
    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'jugador_id');
    }
}
