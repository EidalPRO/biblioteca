<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
    use HasFactory;

    protected $table = 'ejemplares';

    protected $fillable = [
        'libro_id',
        'fecha_adquisicion',
        'condicion',
        'estado',
        'ruta'
    ];

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function prestamos()
    {
        return $this->belongsToMany(Prestamo::class, 'prestamo_ejemplar');
    }

    public function historialPrestamos()
    {
        return $this->hasMany(HistorialPrestamo::class);
    }
}
