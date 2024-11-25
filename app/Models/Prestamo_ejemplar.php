<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo_ejemplar extends Model
{
    use HasFactory;

    protected $table = 'prestamo_ejemplar';

    // Desactivar timestamps (no usaremos created_at ni updated_at)
    public $timestamps = false;

    protected $fillable = [
        'prestamo_id',
        'ejemplar_id',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function ejemplar()
    {
        return $this->belongsTo(Ejemplar::class);
    }
}
