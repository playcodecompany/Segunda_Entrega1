<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $table = 'ranking';
    protected $primaryKey = 'jugador_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'jugador_id',
        'partidas_jugadas',
        'partidas_ganadas',
        'puntos_totales'
    ];

    protected $casts = [
        'promedio_puntos' => 'decimal:2',
    ];

    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'jugador_id');
    }
}
