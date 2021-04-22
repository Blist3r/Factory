<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sede;
use App\Models\Categoria;

class ConfiguracionController extends Controller
{ 
    public function index() {
        $sedes = Sede::all();

        return view('configuracion.sedes', ['sedes' => $sedes]);
    }
        // Se le pide a la base de datos que busque la sede por ID. 
    public function create(Request $request) {
        if($request['id']){
            $sede = Sede::find($request['id']);

        // Se actualiza la sede con lo que se le pidido que modificara en este caso el nombre.
            $sede->update([
                'nombre' => $request['nombre']
            ]);
        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se actualizo correctamente o no.
            if ($sede->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'Sede actualizada correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'La sede no se actualizo correctamente']);
            }
        }

        // Se redirecciona si al intentar modificar, se le olvida registrar el nombre dando un mensaje de alerta.
        if(!$request['nombre'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo nombre es requerido']);
        
        // Al momento de crear la sede, se le piden todos los datos registrados
        $sede = Sede::create($request->all());

         // Se redirecciona a la misma pagina con un mensaje el cual diga si se se creo correctamente o no.
        if ($sede->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'Sede creada correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'La sede no se creo correctamente']);
        }
    }
    //Se traen los datos con ajax para editar
    public function show(Request $request) {
        return Sede::find($request['id']);
    }

    //Al momento de eliminar, se busca a la sede por id y se da la propiedad delete para borrarla
    public function delete(Request $request) {
        $sede = Sede::find($request['id']);
        
    // Se redirecciona a la misma pagina con un mensaje el cual diga si se se elimino correctamente o no.
        if ($sede->delete()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'Sede eliminada correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'La sede no se eliminó correctamente']);
        }   
    }


    // -----------------------------------------------------------------------------------------------------------------------------------------

    // Metodos para categorias

    public function index_categorias() {
        
        $categorias = Categoria::all();

        return view('configuracion.categorias', ['categorias' => $categorias]);

       
        

    }

    public function create_categorias(Request $request) {
        if($request['id']){
            $categoria = Categoria::find($request['id']);

        // Se actualiza la categoria con lo que se le pidido que modificara en este caso el nombre.
            $categoria->update([
                'nombre' => $request['nombre']
            ]);
        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se actualizo correctamente o no.
            if ($categoria->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'La categoria actualizada correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'La categoria no se actualizo correctamente']);
            }
        }

        // Se redirecciona si al intentar modificar, se le olvida registrar el nombre dando un mensaje de alerta.
        if(!$request['nombre'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo nombre es requerido']);
        
        // Al momento de crear la categoria, se le piden todos los datos registrados
        $categoria = Categoria::create($request->all());

         // Se redirecciona a la misma pagina con un mensaje el cual diga si se se creo correctamente o no.
        if ($categoria->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'categoria creada correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'La categoria no se creo correctamente']);
        }
    }

    //Se traen los datos con ajax para editar
    public function show_categorias(Request $request) {
        return Categoria::find($request['id']);
    }

    //Al momento de eliminar, se busca a la categoria por id y se da la propiedad delete para borrarla
    public function delete_categorias(Request $request) {
        $categoria = Categoria::find($request['id']);
        
    // Se redirecciona a la misma pagina con un mensaje el cual diga si se se elimino correctamente o no.
        if ($categoria->delete()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'La Categoria a eliminada correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'La Categoria no se eliminó correctamente']);
        }   
    }





}
