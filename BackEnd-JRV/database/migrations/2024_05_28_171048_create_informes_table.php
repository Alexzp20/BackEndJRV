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
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('path');
            $table->unsignedBigInteger('agenda_id')->nullable();
            $table->unsignedBigInteger('remitente')->nullable();
            $table->timestamps();

            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('set null');
            $table->foreign('remitente')->references('id')->on('remitente_informes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informes');
    }
};
