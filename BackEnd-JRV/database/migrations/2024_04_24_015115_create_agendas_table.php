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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('convoca');
            $table->date('fecha');
            $table->string('lugar');
            $table->string('tipoConvocatoria');
            $table->time('primera_convocatoria');
            $table->time('segunda_convocatoria');
            $table->time('hora_inicio');
            $table->time('hora_finalizacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
