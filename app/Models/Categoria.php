<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    
    protected $fillable = [
        'nombre_categoria',
        'descripcion',
    ];

    public function bienes()
    {
        return $this->hasMany(Bien::class, 'id_categoria', 'id_categoria');
    }
}