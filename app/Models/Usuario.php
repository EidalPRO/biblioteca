<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'contrasena',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'numero_celular',
        'correo',
        'tipo_usuario',
        'domicilio',
        'numero_control',
        'rfc',
        'ine',
        'observaciones',
        'status_usuario',
    ];

    protected $hidden = [
        'contrasena', // Oculta la contraseña en las respuestas JSON
    ];

    // Mapea la contraseña para el sistema de autenticación de Laravel
    public function setAuthPasswordAttribute($password)
    {
        $this->attributes['contrasena'] = bcrypt($password);
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function prestamosActivos()
    {
        return $this->hasMany(Prestamo::class)->where('estado_prestamo', '!=', 'devuelto');
    }
}
