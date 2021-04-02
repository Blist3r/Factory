<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'total',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function clientes()
    {
        return $this->hasOne(Cliente::class);
    }

}
