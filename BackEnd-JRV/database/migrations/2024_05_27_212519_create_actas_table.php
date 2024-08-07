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
        Schema::create('actas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('path');
            $table->unsignedBigInteger('agenda_id')->nullable();
            $table->unsignedBigInteger('estado_acta_id')->nullable();
            $table->time('fecha_aprobacion')->nullable();
            $table->timestamps();

            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('set null');
            $table->foreign('estado_acta_id')->references('id')->on('estado_acta')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actas');
    }
};
