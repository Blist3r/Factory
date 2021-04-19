<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sede;
class ConfiguracionController extends Controller
{
    public function index() {
        $sedes = Sede::all();

        return view('configuracion.sedes', ['sedes' => $sedes]);
    }

    public function create(Request $request) {
        if($request['id']){
            $sede = Sede::find($request['id']);

            $sede->update([
                'nombre' => $request['nombre']
            ]);

            if ($sede->save()) {
                return redirect()->back()->with(['create' => 1, 'mensaje' => 'Sede actualizada correctamente']);
            } else {
                return redirect()->back()->with(['create' => 0, 'mensaje' => 'La sede no se actualizo correctamente']);
            }
        }

        if(!$request['nombre'])
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'El campo nombre es requerido']);

        $sede = Sede::create($request->all());

        if ($sede->save()) {
            return redirect()->back()->with(['create' => 1, 'mensaje' => 'Sede creada correctamente']);
        } else {
            return redirect()->back()->with(['create' => 0, 'mensaje' => 'La sede no se creo correctamente']);
        }
    }

    public function show(Request $request) {
        return Sede::find($request['id']);
    }
}
