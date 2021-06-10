<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta;
use App\Models\Sede;
class ReportesController extends Controller
{
    public function ventas(Request $request) {
        // Consltar ventas
        $ventas = Venta::all();
        // Consultar sedes
        $sedes = Sede::all();

        // Recibimos los filtros
        if ($request['sede']) {
            $ventas->where('sedes_id', $request['sede']);
        }

        return view('reportes.ventas', ['ventas' => $ventas, 'sedes' => $sedes]);
    }

    public function buscar_ventas(Request $request){
        //Se busca los productos que se vendieron llamandolos por el id de la venta.
        $venta = Venta::with('productos.producto')->find($request->id);
        return $venta;
    }
}
