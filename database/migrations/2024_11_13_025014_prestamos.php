<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->foreignId('bibliotecario_id')->constrained('usuarios');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion_pactada');
            $table->enum('estado_prestamo', ['pendiente', 'devuelto', 'extraviado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
};
