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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('apellido')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('fecha_nacimiento')->nullable();
            $table->char('carnet', 7)->nullable();
            $table->unsignedBigInteger('puesto_id')->nullable();
            $table->unsignedBigInteger('rol_id')->nullable();
            $table->rememberToken();
           
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('set null');
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('set null');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
