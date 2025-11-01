<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadorPartida extends Model
{
    use HasFactory;

    protected $table = 'jugador_partida';
    protected $fillable = ['partida_id', 'jugador_id', 'puntuacion'];
    public $timestamps = false;
}
