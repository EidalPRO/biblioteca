<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ejemplares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('libro_id')->constrained('libros');
            $table->date('fecha_adquisicion')->nullable();
            $table->enum('condicion', ['buena', 'regular', 'mala'])->nullable();
            $table->enum('estado', ['disponible', 'en préstamo', 'perdido', 'no disponible', 'baja']);
            $table->string('ruta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ejemplares');
    }
};