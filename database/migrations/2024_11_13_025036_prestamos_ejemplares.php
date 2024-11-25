<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestamo_ejemplar', function (Blueprint $table) {
            $table->foreignId('prestamo_id')->constrained('prestamos');
            $table->foreignId('ejemplar_id')->constrained('ejemplares');
            $table->primary(['prestamo_id', 'ejemplar_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestamo_ejemplar');
    }
};
