<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creador_id')->constrained('users');
            $table->string('nombre'); 
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_fin')->nullable();
            $table->foreignId('ganador_id')->nullable()->constrained('users'); 
            $table->timestamps();
        });

        
        Schema::create('partida_jugador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_id')->constrained('partidas');
            $table->foreignId('jugador_id')->constrained('users'); 
            $table->integer('turno')->nullable(); 
            $table->integer('puntuacion')->default(0); 
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('partida_jugador');
        Schema::dropIfExists('partidas');
    }
};
