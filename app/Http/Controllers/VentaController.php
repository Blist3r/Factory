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

    public function show(Request $request) { 
        $productos = Producto::paginate(12);
        if ($request['categoria'] && $request['categoria'] != 'false' ) {
            $productos = Producto::where('categorias_id', $request['categoria'])->paginate(12);
        }else if ($request['q'] && $request['q'] != 'false' ){
            $productos = Producto::where('nombre', 'like', '%'.$request['q'].'%')->paginate(12);
        }
        return $productos;  
    }
    
}
