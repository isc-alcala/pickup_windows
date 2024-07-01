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
        Schema::create('contactos_contacto_directo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->unsignedBigInteger('contacto_directo_id');
            $table->unsignedBigInteger('estatus_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('contacto_directo_id')->references('id')->on('contacto_directo')->onDelete('no action');
            $table->foreign('estatus_id')->references('id')->on('estatus')->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos_contacto_directo');
    }
};
