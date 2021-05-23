<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallesventa extends Model
{
    use HasFactory;

    protected $fillable = [
        'ventas_id', 'productos_id', 'cantidad'
    ];

    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'productos_id');
    }

}
