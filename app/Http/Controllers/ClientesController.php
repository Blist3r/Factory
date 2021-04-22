<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;

class ClientesController extends Controller
{
    

    public function index() {
        $clientes = Cliente::all();

        return view('configuracion.Cliente.clientes', ['clientes' => $clientes]);
    }

     // Se le pide a la base de datos que busque la sede por ID. 
            
     public function create(Request $request) {
        
        if($request['id']){
            $clientes = Cliente::find($request['id']);

        // Se actualiza la sede con lo que se le pidido que modificara en este caso el nombre.
            $clientes->update([
                'nombre' => $request['nombre'],
                'identificacion' => $request['identificacion'],
                'direccion' => $request['direccion'],
                'telefono' => $request['telefono'],
                'correo' => $request['correo'],
            ]);
        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se actualizo correctamente o no.
            if ($clientes->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El cliente se a actualizado correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El cliente no se actualizo correctamente']);
            }
        }

        // Se redirecciona si al intentar modificar, se le olvida registrar el nombre dando un mensaje de alerta.
        if(!$request['nombre'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo nombre es requerido']);
        
        // Al momento de crear la sede, se le piden todos los datos registrados
        $clientes = Cliente::create($request->all());

         // Se redirecciona a la misma pagina con un mensaje el cual diga si se se creo correctamente o no.
        if ($clientes->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El cliente se a creado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El cliente no se creo correctamente']);
        }
    }
    

//Se traen los datos con ajax para editar
public function show(Request $request) {
    return Cliente::find($request['id']);
}

//Al momento de eliminar, se busca a la sede por id y se da la propiedad delete para borrarla
public function delete(Request $request) {
    $clientes = Cliente::find($request['id']);
    
// Se redirecciona a la misma pagina con un mensaje el cual diga si se se elimino correctamente o no.
    if ($clientes->delete()) {
        return redirect()->back()->with(['create' => 1, 'mensaje' => 'La sede a sido eliminada correctamente']);
    } else {
        return redirect()->back()->with(['create' => 0, 'mensaje' => 'La sede no se eliminó correctamente']);
    }   
}





}
