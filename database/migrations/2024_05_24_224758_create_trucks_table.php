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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('number_truck');
            $table->string('number_container');
            $table->string('trailer_plates');
            $table->string('operator_name');
            $table->string('back_operator_name')->nullable();
            $table->timestamp('ETA')->nullable();
            $table->unsignedBigInteger('relaciones_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('relaciones_id')->references('id')->on('relaciones')->onDelete('no action');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action'); // Definir la clave foránea

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
