<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';
    
    protected $fillable = [
        'nombre_ubicacion',
        'descripcion',
        'direccion',
        'estado',
    ];

    public function bienes()
    {
        return $this->hasMany(Bien::class, 'id_ubicacion', 'id_ubicacion');
    }
}