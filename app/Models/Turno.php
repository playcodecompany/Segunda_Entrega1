<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'partida_id',
        'jugador_id',
        'orden',
    ];

    // Relación con partida
    public function partida()
    {
        return $this->belongsTo(Partida::class);
    }

    // Relación con usuario/jugador
    public function jugador()
    {
        return $this->belongsTo(\App\Models\User::class, 'jugador_id');
    }
}
