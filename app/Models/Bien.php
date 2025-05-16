<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $table = 'bienes';
    protected $primaryKey = 'id_bien';
    
    protected $fillable = [
        'codigo_identificacion',
        'nombre',
        'descripcion',
        'id_categoria',
        'marca',
        'modelo',
        'numero_serie',
        'fecha_adquisicion',
        'proveedor',
        'costo_adquisicion',
        'id_ubicacion',
        'estado',
        'valor_actual',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}