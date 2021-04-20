<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class UsersController extends Controller
{

    public function index() {
        $users = User::all();

        return view('configuracion.users', ['users' => $users]);
    }

    public function create(Request $request) {
        if($request['id']){
            $user = User::find($request['id']);

            $user->update([
                'nombre' => $request['nombre'],
                'apellido' => $request['apellido'],
                'identificacion' => $request['identificacion'],
                'sede' => $request['sede']
            ]);

            if ($user->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue actualizado correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se actualizado correctamente']);
            }

           
            
        }

        if(!$request['nombre'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo nombre es requerido']);

        if(!$request['apellido'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo apellido es requerido']);

        if(!$request['identificacion'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo identificación es requerido']);

        if(!$request['sede'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo sede es requerido']);
            
        $user = User::create($request->all());

        if ($user->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue creado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se creado correctamente']);
        }
    }

    public function show(Request $request) {
        return User::find($request['id']);
    }


    public function delete(Request $request) {
        $user = User::find($request['id']);
        

        if ($user->delete()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El usuario fue eliminado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El usuario no se eliminó correctamente']);
        }   
    }
}

