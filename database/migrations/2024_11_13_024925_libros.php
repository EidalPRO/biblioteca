<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('titulo');
            $table->foreignId('editorial_id')->nullable()->constrained('editoriales');
            $table->date('fecha_publicacion')->nullable();
            $table->string('edicion')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->string('area')->nullable();
            $table->integer('numero_ejemplares');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('libros');
    }
};
