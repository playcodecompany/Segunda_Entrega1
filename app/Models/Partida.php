<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $table = 'partidas';
    protected $fillable = ['creador_id', 'nombre', 'fecha_inicio', 'fecha_fin', 'ganador_id'];
    public $timestamps = false;

    // Relación con jugadores (tabla pivote jugador_partida)
    public function jugadores()
    {
        return $this->belongsToMany(User::class, 'jugador_partida', 'partida_id', 'jugador_id')
                    ->withPivot('puntuacion')
                    ->withTimestamps();
    }

    // Creador de la partida
    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    // Ganador de la partida
    public function ganador()
    {
        return $this->belongsTo(User::class, 'ganador_id');
    }

    // Movimientos de la partida
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];
}
