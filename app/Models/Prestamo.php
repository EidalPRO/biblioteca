<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';

    protected $fillable = [
        'usuario_id',
        'bibliotecario_id',
        'fecha_prestamo',
        'fecha_devolucion_pactada',
        'estado_prestamo',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function bibliotecario()
    {
        return $this->belongsTo(Usuario::class, 'bibliotecario_id');
    }

    public function ejemplares()
    {
        return $this->belongsToMany(Ejemplar::class, 'prestamo_ejemplar');
    }
}
