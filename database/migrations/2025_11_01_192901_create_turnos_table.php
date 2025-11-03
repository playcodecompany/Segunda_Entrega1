<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('turnos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('partida_id')->constrained('partidas');
        $table->foreignId('jugador_id')->constrained('users'); // ⚡ apunta a users
        $table->integer('orden');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('turnos');
}

};
