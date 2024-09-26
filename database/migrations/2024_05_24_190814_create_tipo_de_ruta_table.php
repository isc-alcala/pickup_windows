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
        Schema::create('tipo_de_ruta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('estatus_id')->nullable();
            $table->timestamps();

            // Foreign key constraint

            $table->foreign('estatus_id')->references('id')->on('estatus')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_de_ruta');
    }
};
