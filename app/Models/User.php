<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function partidas()
    {
        return $this->belongsToMany(Partida::class, 'partida_jugador', 'jugador_id', 'partida_id')
            ->withPivot('puntuacion', 'turno')
                    ->withTimestamps();
    }

    // Relación con ranking
    public function ranking()
    {
        return $this->hasOne(\App\Models\Ranking::class, 'jugador_id');
    }
}
