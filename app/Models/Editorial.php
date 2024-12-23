<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $table = 'editoriales';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'correo',
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class);
    }
}
