<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sede;
use App\Models\Categoria;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

    //----------------------------------------------------------------------------------------------------------------------------------

    public function roles() {
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('configuracion.roles', ['roles' => $roles]);
    }

    public function roles_create(Request $request) {

        if($request['id']){
            $rol = Role::find($request['id']);

        // Se actualiza el rol con lo que se le pidido que modificara en este caso el nombre.
            $rol->update([
                'name' => $request['name']
            ]);
        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se actualizo correctamente o no.
            if ($rol->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El rol actualizada correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El rol no se actualizo correctamente']);
            }
        }

        $rol = Role::create(['name' => $request['name']]);

        if ($rol->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El rol se creo correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El rol NO se creo correctamente']);
        }
        
    }

    //Se traen los datos con ajax para editar
    public function roles_show(Request $request) {
        return Role::find($request['id']);
    }

    //Al momento de eliminar, se busca a la sede por id y se da la propiedad delete para borrarla
    public function roles_delete(Request $request) {
        $rol = Role::find($request['id']);

        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se elimino correctamente o no.
        if ($rol->delete()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'Rol eliminado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El rol no se eliminó correctamente']);
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------

    public function permisos() {
        $permisos = Permission::orderBy('name', 'ASC')->get();

        return view('configuracion.permisos', ['permisos' => $permisos]);
    }

    public function permisos_create(Request $request) {

        if($request['id']){
            $permisos = Permission::find($request['id']);

        // Se actualiza el permisos con lo que se le pidido que modificara en este caso el nombre.
            $permisos->update([
                'name' => $request['name']
            ]);
        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se actualizo correctamente o no.
            if ($permisos->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'El permiso actualizada correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'El permiso no se actualizo correctamente']);
            }
        }

        $permisos = Permission::create(['name' => $request['name']]);

        if ($permisos->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El permiso se creo correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El permiso NO se creo correctamente']);
        }
        
    }

    //Se traen los datos con ajax para editar
    public function permisos_show(Request $request) {
        return Permission::find($request['id']);
    }

    //Al momento de eliminar, se busca a la sede por id y se da la propiedad delete para borrarla
    public function permisos_delete(Request $request) {
        $permisos = Permission::find($request['id']);

        // Se redirecciona a la misma pagina con un mensaje el cual diga si se se elimino correctamente o no.
        if ($permisos->delete()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'El Permiso eliminado correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El permiso no se eliminó correctamente']);
        }
    }

}
