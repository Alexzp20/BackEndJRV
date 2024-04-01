<?php

use App\Models\Subcategoria;
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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('subcategoria_id')->nullable();
            $table->unsignedBigInteger('estado_revision_id')->nullable()->unique();
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onDelete('set null');
            $table->foreign('estado_revision_id')->references('id')->on('estado_revisiones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
