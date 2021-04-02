<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'total',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

}


