<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;

class ProductosController extends Controller
{
    
    public function index() {
        $productos = Producto::all();

        return view('configuracion.Producto.productos', ['productos' => $productos]);
    }

        // Se le pide a la base de datos que busque la sede por ID. 
        
        public function create(Request $request) {
           
            if($request['id']){
                $productos = Producto::find($request['id']);
    
            // Se actualiza la sede con lo que se le pidido que modificara en este caso el nombre.
                $productos->update([
                    'nombre' => $request['nombre'],
                    'valor' => $request['valor'],
                    'descripcion' => $request['descripcion'],
                    'imagen' => $request['imagen'],
                ]);
            // Se redirecciona a la misma pagina con un mensaje el cual diga si se se actualizo correctamente o no.
                if ($productos->save()) {
                    return redirect()->back()->with(['create' => 1, 'mensaje' => 'El producto se a actualizado correctamente']);
                } else {
                    return redirect()->back()->with(['create' => 0, 'mensaje' => 'El producto no se actualizo correctamente']);
                }
            }
    
            // Se redirecciona si al intentar modificar, se le olvida registrar el nombre dando un mensaje de alerta.
            if(!$request['nombre'])
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo nombre es requerido']);
            
            // Al momento de crear la sede, se le piden todos los datos registrados
            $productos = Producto::create($request->all());
    
             // Se redirecciona a la misma pagina con un mensaje el cual diga si se se creo correctamente o no.
            if ($productos->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El producto se a creado correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El producto no se creo correctamente']);
            }
        }
        


}
