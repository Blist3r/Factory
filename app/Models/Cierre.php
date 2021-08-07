<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cierre extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'numero_ventas', 'total', 'users_id'
    ];
}
