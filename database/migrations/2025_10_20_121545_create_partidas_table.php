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
            $table->foreignId('creador_id')->constrained('jugadores');
            $table->integer('num_jugadores')->default(3);
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_fin')->nullable();
            $table->foreignId('ganador_id')->nullable()->constrained('jugadores');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
