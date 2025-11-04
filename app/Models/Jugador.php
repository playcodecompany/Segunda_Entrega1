<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    // Apunta a la tabla 'users'
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'rol'];

    // Relación con partidas (usa la tabla pivote correcta)
    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_jugador')
                    ->withPivot('puntuacion')
                    ->withTimestamps();
    }

    // Relación con ranking
    public function ranking()
    {
        return $this->hasOne(Ranking::class, 'jugador_id');
    }
}
