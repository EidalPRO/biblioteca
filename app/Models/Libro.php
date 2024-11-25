<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = [
        'codigo',
        'titulo',
        'editorial_id',
        'fecha_publicacion',
        'edicion',
        'imagen_portada',
        'area',
        'numero_ejemplares',
    ];

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'libro_autor');
    }

    public function ejemplares()
    {
        return $this->hasMany(Ejemplar::class);
    }
}
