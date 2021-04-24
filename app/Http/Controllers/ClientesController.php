<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;

use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{
    

    public function index() {
        $clientes = Cliente::all();

        return view('configuracion.Cliente.clientes', ['clientes' => $clientes]);
    }

     // Se le pide a la base de datos que busque el cliente por ID. 
            
     public function create(Request $request) {

        //--------------------------EDITAR CLIENTE, Si existe el $request->id, entonces se pasara a editar el registro con el ID correspondiente. ----------------------------
        
        
        if($request['id']){

            //Se valida el nombre, apellido y la sede seleccionada.
            Validator::make($request->all(), [
                'nombre' => 'required|max:255',
                'apellido' => 'required|max:255',
                
            ])->validate();

            $clientes = Cliente::find($request['id']);

            //Vuelve a llamar a "cliente" y compara la identificacion que tiene el registro, si detecta que hay un cambio genera ese cambio dentro del registro, sino la deja como estaba.
            if ($clientes->identificacion != $request["identificacion"]) {
                Validator::make($request->all(), [
                    'identificacion' => 'required|unique:clientes|integer'
                ])->validate();
            }


        // Se actualiza el cliente con lo que se le pidido que modificara en este caso el nombre.
            $clientes->update([
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

        //---------------------- CREAR CLIENTE, Si no llega el $request->id, se creara un registro nuevo. -------------------------------
        
        //$request->id = Lo que llega el ID de ese registro. y lo que hace es buscarlo si es que existe. 

        //Se valida que los datos hallan rellanado completamente 
        Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'identificacion' => 'required|unique:clientes|integer',
        ])->validate();
        
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
