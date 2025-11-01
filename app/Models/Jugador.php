<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';
    protected $fillable = ['nombre', 'correo', 'contrasena'];
    public $timestamps = false;

    // Relación con partidas
    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'jugador_partida')
                    ->withPivot('puntuacion');
    }

    // Relación con ranking
    public function ranking()
    {
        return $this->hasOne(Ranking::class, 'jugador_id');
    }
}