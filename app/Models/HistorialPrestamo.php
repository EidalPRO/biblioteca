<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPrestamo extends Model
{
    use HasFactory;

    protected $table = 'historial_prestamos';

    protected $fillable = [
        'usuario_id',
        'ejemplar_id',
        'fecha_inicio',
        'fecha_devolucion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function ejemplar()
    {
        return $this->belongsTo(Ejemplar::class, 'ejemplar_id');
    }
}
