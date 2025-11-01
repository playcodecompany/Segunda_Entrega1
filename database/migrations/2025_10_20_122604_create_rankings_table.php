<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ranking', function (Blueprint $table) {
            $table->foreignId('jugador_id')->primary()->constrained('jugadors');
            $table->integer('partidas_jugadas')->default(0);
            $table->integer('partidas_ganadas')->default(0);
            $table->integer('puntos_totales')->default(0);
            $table->decimal('promedio_puntos', 5, 2)
                  ->storedAs('CASE WHEN partidas_jugadas > 0 THEN puntos_totales / partidas_jugadas ELSE 0 END');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranking');
    }
};
