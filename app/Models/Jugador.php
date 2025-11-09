<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

 
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'rol'];

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_jugador')
                    ->withPivot('puntuacion')
                    ->withTimestamps();
    }

    public function ranking()
    {
        return $this->hasOne(Ranking::class, 'jugador_id');
    }
}
