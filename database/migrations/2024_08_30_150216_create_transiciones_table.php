<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado_origen_id');
            $table->unsignedBigInteger('estado_destino_id');
            $table->timestamps();

            // Claves foráneas y relaciones
            $table->foreign('estado_origen_id')->references('id')->on('estatus')->onDelete('NO ACTION');
            $table->foreign('estado_destino_id')->references('id')->on('estatus')->onDelete('NO ACTION');

            // Evitar duplicados
            $table->unique(['estado_origen_id', 'estado_destino_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transiciones');
    }
};
