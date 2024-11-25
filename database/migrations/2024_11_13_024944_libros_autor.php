<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('libro_autor', function (Blueprint $table) {
            $table->foreignId('libro_id')->constrained('libros');
            $table->foreignId('autor_id')->constrained('autores');
            $table->primary(['libro_id', 'autor_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('libro_autor');
    }
};
