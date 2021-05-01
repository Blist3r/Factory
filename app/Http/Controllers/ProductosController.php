<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;

use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    
    public function index() {
        $productos = Producto::all();

        return view('configuracion.Producto.productos', ['productos' => $productos]);
    }

        // Se le pide a la base de datos que busque el producto por ID. 
        
        

        public function create(Request $request) {
           if ($request->imagen) {
                //Es el nombre que recibe el archivo
                $nameimage='producto_'.date('YmdHis').'.jpg';
                //Crea la imagen, le da formato jpg y convierte al 75%
                $imagen=Image::make($request->imagen)->encode('jpg', 75);
                //Guarda la imagen en el disco public y pasa la imagen codificada.
                Storage::disk('public')->put('productos/'.$nameimage, $imagen->stream());
           }
           
           
           // Al momento de crear la sede, se le piden todos los datos registrados
           $productos = Producto::create($request->all());
    
           //Cambiamos el valor de $request->imagen por el nombre final donde quedo guardada la imagen.
           $productos->imagen='productos/'.$nameimage;

           // Se redirecciona a la misma pagina con un mensaje el cual diga si se se creo correctamente o no.
          if ($productos->save()) {
              return redirect()->back()->with(['create' => 1, 'mensaje' => 'El producto se a creado correctamente']);
          } else {
              return redirect()->back()->with(['create' => 0, 'mensaje' => 'El producto no se creo correctamente']);
          }
           

          if($request['id']){

            //Se valida el nombre, apellido y la sede seleccionada.
            Validator::make($request->all(), [
                'imagen' => 'required',
                'nombre' => 'required|max:255',
                'descripcion' => 'required',
                'valor' => 'required|integer',
                'categorias_id' => 'required' ,

                
            ])->validate();
           
          }
            if($request['id']){
                $productos = Producto::find($request['id']);
               
    
            // Se actualiza el producto con lo que se le pidido que modificara en este caso el nombre.
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
            
        }
        
        //Se traen los datos con ajax para editar
public function show(Request $request) {
    return Producto::find($request['id']);
}

//Al momento de eliminar, se busca a la sede por id y se da la propiedad delete para borrarla
public function delete(Request $request) {
    $productos = Producto::find($request['id']);
    
// Se redirecciona a la misma pagina con un mensaje el cual diga si se se elimino correctamente o no.
    if ($productos->delete()) {
        return redirect()->back()->with(['create' => 1, 'mensaje' => 'El producto a sido eliminada correctamente']);
    } else {
        return redirect()->back()->with(['create' => 0, 'mensaje' => 'El producto no se eliminó correctamente']);
    }   
}


}
