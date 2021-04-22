<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'valor',
        'descripcion',
        'imagen',
        'categoria_id',
    ];

    public function venta()
    {
        return $this->hasMany(Venta::class);
    }

    public function inventarios()
    {
        return $this->hasOne(Inventario::class);
    }

    public function categorias()
    {
        return $this->belongsTo(Categoria::class);
    }
}
