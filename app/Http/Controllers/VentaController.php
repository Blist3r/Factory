<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;

class VentaController extends Controller
{
    public function index() {
        $categorias = Categoria::all();
        $productos = Producto::paginate(12);

        return view('welcome', ['categorias' => $categorias, 'productos' => $productos]);
    }
}
