<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('contrasena');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('numero_celular')->nullable();
            $table->string('correo')->nullable();
            $table->enum('tipo_usuario', ['bibliotecario', 'estudiante', 'docente', 'administrativo', 'directivo', 'externo']);
            $table->string('domicilio')->nullable();
            $table->string('numero_control')->nullable();
            $table->string('rfc')->nullable();
            $table->string('ine')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('status_usuario', ['activo', 'sancionado', 'baja']);
            $table->timestamps();
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('sessions');
    }
};
