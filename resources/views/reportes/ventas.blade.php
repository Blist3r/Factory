@extends('layouts.app')

@section('myStyles')
    <link href="{{ asset('assets/vendor/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/pickadate/themes/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/pickadate/themes/default.date.css') }}">
@endsection

@section('mySripts')
    <script src="{{ asset('assets/js/reporteventas.js') }}"></script>

    {{-- DatePicker --}}
    <script src="{{ asset('assets/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/plugins-init/bs-daterange-picker-init.js') }}"></script>
@endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ventas</h4>
                    </div>
                    <div class="card-body">

                        <div class="row d-flex">
                            <form action="{{ route('exportar_ventas') }}" method="post" class="w-100" style="display: contents;">
                                @csrf

                                <div class="col-xl-4 mb-3">
                                    <div class="example">
                                        <input class="form-control input-daterange-datepicker" type="text" name="rango_fechas" id="rango_fechas">
                                    </div>
                                </div>

                                <div class="col-xl-4 mb-3">
                                    <select name="sedes_id" id="sedes_id" class="form-control" onchange="filtrarPorSede(this.value)">
                                        <option value="">Seleccione la sede</option>

                                        @foreach ($sedes as $sede)
                                            @php $selected = \Request::get('sede') == $sede->id ? 'selected' : ''; @endphp
                                            <option value="{{ $sede->id }}" {{ $selected }}>{{ $sede->nombre }}</option>
                                        @endforeach
                                    </select>
                               </div>
                               <div>
                                    <button type="submit" class="btn btn-success">Exportar Ventas</button>
                                </div>
                            </form>
                            <div class="ml-3">
                                <button type="button" onclick="cierre()" class="btn btn-success">Cierre</button>
                            </div>
                        </div>

                        <div class="table-responsive">

                            @if (session()->has('create'))
                                <div class="alert {{ session('create') == 1 ? 'alert-success' : 'alert-danger' }} alert-dismissible alert-alt fade show">
                                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
                                    <strong>{{ session('mensaje') }}!</strong>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible alert-alt fade show">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Venta</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Sede</th>
                                        <th scope="col">Vendedor</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Metodo de Pago</th>
                                        <th scope="col">Total</th>
                                        <th scope="col" class="text-center"> <span>  <i class="fa fa-cog"></i> </span> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <!-- En la tabla se pone el nombre segun lo digitado en el boton de agregar venta -->
                                            <td> {{ $venta->id}} </td>
                                            <td> {{ $venta->fecha}} </td>
                                            <td> {{ App\Models\Sede::find($venta->sedes_id)->nombre }} </td>
                                            <td> {{ App\Models\User::find($venta->users_id)->nombre }} {{ App\Models\User::find($venta->users_id)->apellido }}</td>
                                            <td> {{ App\Models\Cliente::find($venta->clientes_id)->nombre }} </td>
                                            <td> {{ $venta->metodo_pago}} </td>
                                            <td> {{ number_format($venta->total)}} </td>
                                            <td class="text-center">
                                                <span>
                                                    <a href="javascript:MostrarVenta({{ $venta->id }})" data-toggle="tooltip" data-placement="top" title="Descripcion de Venta">
                                                        <i class="fa fa-eye color-muted"></i>
                                                    </a>
                                                    <a href="javascript:Imprimir({{ $venta->id }})" data-toggle="tooltip" data-placement="top" title="Imprimir" class="ml-2">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALES --}}
<div class="modal fade" id="modalMostrarVenta">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ventas</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="contentModalDetalle">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
