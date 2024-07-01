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
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('estatus_id');
            $table->unsignedBigInteger('tipo_de_ruta_id');
            $table->timestamps();

            // Foreign key constraint
            // $table->foreign('contacto_directo_id')->references('id')->on('contacto_directo')->onDelete('no action');
            $table->foreign('tipo_de_ruta_id')->references('id')->on('tipo_de_ruta')->onDelete('no action');
            $table->foreign('estatus_id')->references('id')->on('estatus')->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruta');
    }
};
