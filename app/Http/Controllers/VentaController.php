<?php

namespace App\Http\Controllers;

use App\Exports\VentaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Categoria;
use App\Models\Cierre;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Detallesventa;
use App\Models\User;
use App\Models\Venta;
use App\Models\Sede;


class VentaController extends Controller
{



    public function index() {
        $categorias = Categoria::all();
        $productos = Producto::paginate(12);

        return view('welcome', ['categorias' => $categorias, 'productos' => $productos]);
    }

    public function show(Request $request) {
        $productos = Producto::paginate(12);
        if ($request['categoria'] && $request['categoria'] != 'false' ) {
            $productos = Producto::where('categorias_id', $request['categoria'])->paginate(12);
        }else if ($request['q'] && $request['q'] != 'false' ){
            $productos = Producto::where('nombre', 'like', '%'.$request['q'].'%')->paginate(12);
        }
        return $productos;
    }


    public function searchCliente(Request $request) {
        return Cliente::where('identificacion', $request['id'])->first();
    }

    public function validarVendedor(Request $request) {
        $user = User::where("identificacion", $request['identificacion_vendedor'])->first();

        if(!$user) return 0;

        if(Hash::check($request['password_vendedor'], $user->password)){
            return 1;
        } else {
            return 0;
        }
    }

    public function realizarVenta(Request $request) {
        // Traer Datos de cliente y vendedor
        $vendedor = User::where("identificacion", $request['identificacion_vendedor'])->first();
        $cliente  = Cliente::where("identificacion", $request['identificacion_cliente'])->first();
        $total = 0;



        //Si el cliente no se creó, procede a crearlo con la información brindada en el modal
        if (!$cliente) {
            $cliente = Cliente::create([
                //Se pasan los datos que llegaron del modal por el '$request'
                'nombre' => $request['nombre_cliente'],
                'apellido' => '',
                'correo' => '',
                'identificacion' => $request['identificacion_cliente'],
                'direccion' => $request['direccion_cliente']?? '',
                'telefono' => $request['telefono_cliente']?? '',
            ]);
            //Y si no se guardo, devuelva error. Siendo error return 0.
            if (!$cliente->save()) {
                return 0;
            }
        }else{
            $cliente->update([
                'nombre' => $request['nombre_cliente'],
                'apellido' => '',
                'correo' => '',
                'identificacion' => $request['identificacion_cliente'],
                'direccion' => $request['direccion_cliente']?? '',
                'telefono' => $request['telefono_cliente']?? '',
            ]);
        }

        // Iniciar transaccion
        DB::beginTransaction(); // -- Punto de partida

        $venta = Venta::create([
            'fecha' => date('Y-m-d'),
            'total' => 0,
            'domicilio' => $request['domicilio'] ?? NULL,
            'propina'=> $request['propina'] ?? 0,
            'metodo_pago' => $request['metodo_pago'],
            'sedes_id' => $vendedor->sedes_id,
            'users_id' => $vendedor->id,
            'clientes_id' => $cliente->id
        ]);



        if($venta->save()){
            foreach ($request['productos'] as $key => $producto) {
                $detalle = Detallesventa::create([
                    'ventas_id' => $venta->id,
                    'productos_id' => $producto,
                    'cantidad' => $request['cantidad'][$key]
                ]);

                if(!$detalle->save()){
                    // Devolver transaccion
                    DB::rollBack();
                    return 0;
                }

                $total = (Producto::find($producto)->valor * $request['cantidad'][$key]) + $total;
            }
        } else {
            return 0;
        }

        $venta->total = $total;

        $venta->save();

        DB::commit();

        $venta = Venta::with('productos.producto')->find($venta->id);
        $sucursal = Sede::find($vendedor->sedes_id);

        return [
            'venta' => $venta,
            'vendedor' => $vendedor,
            'cliente' => $cliente,
            'total' => $total,
            'sucursal' => $sucursal,

        ];

    }

    public function exportar_ventas(Request $request)
    {
        $fecha1 = substr($request->rango_fechas, 0, 10);
        $fecha2 = substr($request->rango_fechas, 13);

        $fecha = date_create($fecha1);
        $fecha1 = date_format($fecha, "Y-m-d");
        $fecha = date_create($fecha2);
        $fecha2 = date_format($fecha, "Y-m-d");

        return (new VentaExport)->rango($fecha1, $fecha2)->download('Ventas.xlsx');
    }

    public function imprimir_ventas(Request $request){

        $venta = Venta::find($request->id);
        $vendedor = User::find($venta->users_id);
        $cliente = Cliente::find($venta->clientes_id);
        $total = $venta->total;
        $sucursal = Sede::find($venta->sedes_id);


        return [
            'venta' => $venta,
            'vendedor' => $vendedor,
            'cliente' => $cliente,
            'total' => $total,
            'sucursal' => $sucursal

        ];

    }

    public function print_cierre(Request $request) {
        $ventas = DB::select('select distinct p.nombre, sum(d.cantidad) as cantidad, (sum(d.cantidad) * any_value(p.valor)) as total FROM productos p left join detallesventas d on d.productos_id = p.id left join ventas v on v.id = d.ventas_id where v.sedes_id = ? and v.fecha = ? group by p.nombre;', [$request['sucursal'], date('Y-m-d') ]);
        $numero_ventas = Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->get()->count();


        $ventas_fisicas = [
            'efectivo' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('domicilio', '0')->where('metodo_pago', 'Efectivo')->sum('total'),
            'tarjeta' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('domicilio', '0')->where('metodo_pago', 'Tarjeta')->sum('total'),
            'total' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('domicilio', '0')->sum('total')
        ];

        $ventas_domicilio = [
            'efectivo' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('domicilio', '1')->where('metodo_pago', 'Efectivo')->sum('total'),
            'tarjeta' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('domicilio', '1')->where('metodo_pago', 'Tarjeta')->sum('total'),
            'total' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('domicilio', '1')->sum('total')
        ];

        $ventas_total = [
            'efectivo' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('metodo_pago', 'Efectivo')->sum('total'),
            'tarjeta' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->where('metodo_pago', 'Tarjeta')->sum('total'),
            'total' =>
            Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->sum('total')
        ];

        //$propinas = [
        //
        //    'total' =>
        //    Venta::where('sedes_id', $request['sucursal'])->where('fecha', date('Y-m-d'))->sum('propina')
        //
        //];

        $fecha = date('Y-m-d H:i:s');

        $ultimo_cierre = Cierre::whereRaw('DATE(fecha)', date('Y-m-d', strtotime('-1 day')))->orderBy('id', 'desc')->first();

        Cierre::create([
            'fecha' => $fecha,
            'numero_ventas' => $numero_ventas,
            'total' => $ventas_total['total'],
            'users_id' => auth()->user()->id
        ]);

        return [
            'sucursal' => Sede::find($request['sucursal'])['nombre'],
            'ventas' => $ventas,
            'ventas_fisicas' => $ventas_fisicas,
            'ventas_domicilio' => $ventas_domicilio,
            'ventas_total' => $ventas_total,
            'total' => $numero_ventas,
            'fecha' => $fecha,
            'ultimo_cierre' => [
                'fecha' => date('d/m/Y', strtotime($ultimo_cierre->fecha)),
                'hora' => date('H:i:s', strtotime($ultimo_cierre->fecha)),
                'numero_ventas' => $ultimo_cierre->numero_ventas
            ]
        ];
    }

}
