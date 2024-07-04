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
        Schema::create('votacions', function (Blueprint $table) {
            $table->id();
            $table->integer('afavor');
            $table->integer('contra');
            $table->integer('abstencion');
            $table->integer('total');
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->unsignedBigInteger('acta_id')->nullable();
            $table->timestamps();

            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('acta_id')->references('id')->on('actas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votacions');
    }
};
