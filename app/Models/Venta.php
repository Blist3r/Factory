<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'total',
        'propina',
        'domicilio',
        'sedes_id',
        'users_id',
        'clientes_id',
        'metodo_pago'
    ];

    public function productos()
    {
        return $this->hasMany(Detallesventa::class, 'ventas_id');
    }

    public function clientes()
    {
        return $this->hasOne(Cliente::class);
    }

}
