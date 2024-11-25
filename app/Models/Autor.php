<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
    ];

    public function libros()
    {
        return $this->belongsToMany(Libro::class, 'libro_autor');
    }
}
