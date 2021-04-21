<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{

    public function index() {
        $users = User::all();

        return view('configuracion.users', ['users' => $users]);
    }

    
    public function create(Request $request) {

        

        if($request['id']){
            //Se valida el nombre, apellido y la sede seleccionada.
            Validator::make($request->all(), [
                'nombre' => 'required|max:255',
                'apellido' => 'required|max:255',
                'sedes_id' => 'required'
            ])->validate();

            //Verifica el user, llamandoló para comparar los datos.
            $user = User::find($request['id']);
            
            //Vuelve a llamar a "user" y si la identificación cambio la modifica, de no serlo así la deja igual.
            if ($user->identificacion != $request["identificacion"]) {
                Validator::make($request->all(), [
                    'identificacion' => 'required|unique:users|integer'
                ])->validate();
            }
            
            //Al momento de editar el usuario, se verifican los datos ya digitados.
            $user->update([
                'nombre' => $request['nombre'],
                'apellido' => $request['apellido'],
                'identificacion' => $request['identificacion'],
                'sede' => $request['sede']
            ]);

            //Se encripta la contraseña en la base de datos.
            if ($request["password"]) {
                $user->update([
                    'password' => Hash::make($request['password'])
                ]);
            }

            //Se pone una condicion para saber si el usuario fue actualizado correctamente o no.
            if ($user->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue actualizado correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se actualizado correctamente']);
            }

           
            
        }
        //Se valida que los datos hallan rellanado completamente 
        Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'identificacion' => 'required|unique:users|integer',
            'password' => 'required',
            'sedes_id' => 'required'
        ])->validate();

        //Encripta la contraseña
        $request["password"]=Hash::make($request['password']);

        $user = User::create($request->all());
        //Se pone una condicion para saber si el usuario fue creado correctamente o no.
        if ($user->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue creado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se creado correctamente']);
        }
    }
//  Tampoco me acuerdo de este :( ###########################################################################
    public function show(Request $request) {
        return User::find($request['id']);
    }


    // Al momento de eliminar un usuario, se le pone la condicion delete para que elimine el usuario
    public function delete(Request $request) {
        $user = User::find($request['id']);
        
        //Se pone una condicion para saber si el usuario fue eliminado correctamente o no.
        if ($user->delete()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue eliminado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se eliminó correctamente']);
        }   
    }
}

