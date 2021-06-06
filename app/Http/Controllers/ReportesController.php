<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Venta;

class ReportesController extends Controller
{
    public function ventas() {
        $ventas = Venta::all();
        return view('reportes.ventas', ['ventas' => $ventas ] );
    }

    public function buscar_ventas(Request $request){
        //Se busca los productos que se vendieron llamandolos por el id de la venta.
        $venta = Venta::with('productos.producto')->find($request->id);
        return $venta;

    }
}
