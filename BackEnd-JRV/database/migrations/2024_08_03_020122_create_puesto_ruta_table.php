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
        Schema::create('puesto_ruta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('puesto_id');
            $table->unsignedBigInteger('ruta_id');
            $table->timestamps();
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');
            $table->foreign('ruta_id')->references('id')->on('rutas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puesto_ruta');
    }
};
