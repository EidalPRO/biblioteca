<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historial_prestamos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('ejemplar_id');
            $table->date('fecha_inicio');
            $table->date('fecha_devolucion')->nullable();
            $table->integer('dias_prestamo')->storedAs('DATEDIFF(fecha_devolucion, fecha_inicio)');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_prestamos');
    }
};
