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
        Schema::create('relaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruta_id');
            $table->unsignedBigInteger('carrier_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contacto_directo_id');
            $table->timestamps();


            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('ruta_id')->references('id')->on('rutas')->onDelete('no action');
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('no action');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('no action');
            $table->foreign('contacto_directo_id')->references('id')->on('contacto_directo')->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relaciones');
    }
};
