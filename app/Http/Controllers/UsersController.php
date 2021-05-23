<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

         //--------------------------EDITAR, Si existe el $request->id, entonces se pasara a editar el registro con el ID correspondiente. ----------------------------

        if($request['id']){
            //Se valida el nombre, apellido y la sede seleccionada.
            Validator::make($request->all(), [
                'nombre' => 'required|max:255',
                'apellido' => 'required|max:255',
                'sedes_id' => 'required'
            ])->validate();

            //Verifica el user, llamandoló para comparar los datos.
            $user = User::find($request['id']);

            //Vuelve a llamar a "user" y compara la identificacion que tiene el registro, si detecta que hay un cambio genera ese cambio dentro del registro, sino la deja como estaba.
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

            // Eliminar todos los roles existentes
            $user->roles()->detach();
            // Forzar el cache de permisos
            $user-> forgetCachedPermissions();

            // Agregar el nuevo rol
            $user->assignRole($request['rol']);

            //Se pone una condicion para saber si el usuario fue actualizado correctamente o no.
            if ($user->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue actualizado correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se actualizado correctamente']);
            }

             //---------------------- CREAR, Si no llega el $request->id, se creara un registro nuevo. -------------------------------


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
            // Agregar el nuevo rol
            $user->assignRole($request['rol']);

            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue creado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se creado correctamente']);
        }
    }
    //Se traen los datos con ajax para editar
    public function show(Request $request) {
        $user = User::find($request['id']);

        $roles = $user->getRoleNames();

        $user->roles = $roles;

        return $user;
    }

    //------------------- ELIMINAR ------------------------


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

