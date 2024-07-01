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
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('truck_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('estatus_id');
            $table->text('comentario');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('estatus_id')->references('id')->on('estatus')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
