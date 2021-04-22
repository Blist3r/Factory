<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;

class ProductosController extends Controller
{
    
    public function index() {


        return view('configuracion.productos');
    }




}
