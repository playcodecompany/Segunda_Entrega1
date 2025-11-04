<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla partidas
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creador_id')->constrained('users'); // apunta a users
            $table->string('nombre'); // ⚡ agregada la columna nombre
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_fin')->nullable();
    
            $table->foreignId('ganador_id')->nullable()->constrained('users'); // apunta a users
            $table->timestamps();
        });

        // Tabla pivote partida_jugador
        Schema::create('partida_jugador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained('partidas');
            $table->foreignId('jugador_id')->constrained('users'); // ⚡ usuarios
            $table->integer('turno')->nullable(); // para guardar el orden de turnos
            $table->integer('puntuacion')->default(0); // ⚡ agregar puntuación
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('partida_jugador');
        Schema::dropIfExists('partidas');
    }
};
