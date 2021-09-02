@extends('layouts.app')

@section('myStyles') <link href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet"> @endsection

@section('mySripts')
    <script src="{{ asset('assets/js/venta.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-6">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- Se crea una funcion que se le esta pasa un parametro con el cual tiene su categoria -->
                                                <select name="categorias_id" id="categorias_id" class="form-control" required onchange="cargarProductos(categoria=this.value)">
                                                    <option value="false">Seleccione la categoria</option>
                                                    <!-- Se crea un foreaach, para que busque las categorias que hay en la base de datos y se les da un orden -->
                                                    @foreach ($categorias as $categoria)
                                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <!-- Se crea una funcion y se pone "false" la anterior para que salte esa funcion y valide la segunda -->
                                            <div class="col-sm-6 mt-2 mt-sm-0">
                                                <input type="text" class="form-control" placeholder="Busque un producto" onkeyup="cargarProductos(categoria=false, q=this.value)">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="productos">

                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 order-md-2 mb-4">
                                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted">Resumen de venta</span>
                                            <span class="badge badge-primary badge-pill" id="total_productos">0</span>
                                        </h4>
                                        <form action="POST" id="formDetalleVenta">
                                            <ul class="list-group mb-3" id="detalle_venta">

                                            </ul>
                                        </form>
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item d-flex justify-content-between active">
                                                <span>Total</span>
                                                <strong id="total_valor">$0</strong>
                                            </li>
                                        </ul>

                                        <form>
                                            <div class="input-group">
                                                <a class="btn btn-primary btn-block" href="javascript:realizarVenta()">Realizar venta</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- Modal Venta --}}
<div class="modal fade bd-example-modal-lg" id="modalVenta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Realizar venta</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Formulario de informacion de cliente --}}
                <div class="basic-form">
                    <div class="row">
                        <h4 class="col-12">Información del Cliente</h4>
                        <div class="col-sm-3 mt-2 mt-sm-0">
                            <input type="number" class="form-control" placeholder="Escriba la identificacion" name="identificacion_cliente" id="identificacion_cliente" onchange="searchCliente(this.value)">
                        </div>

                        <div class="col-sm-3 mt-2 mt-sm-0">
                            <input type="text" class="form-control" placeholder="Escriba el nombre" name="nombre_cliente" id="nombre_cliente">
                        </div>

                        <div class="col-sm-3 mt-2 mt-sm-0">
                            <input type="text" class="form-control" placeholder="Telefono" name="telefono_cliente" id="telefono_cliente">
                        </div>

                        <div class="col-sm-3 mt-2 mt-sm-0">
                            <input type="text" class="form-control" placeholder="Dirección" name="direccion_cliente" id="direccion_cliente">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <h4 class="col-12">Información del Vendedor</h4>
                        <div class="col-sm-6 mt-2 mt-sm-0">
                            <input type="number" class="form-control" placeholder="Escriba la identificacion" name="identificacion_vendedor" id="identificacion_vendedor">
                        </div>

                        <div class="col-sm-6 mt-2 mt-sm-0">
                            <input type="password" class="form-control" placeholder="Ingrese la contraseña" name="password_vendedor" id="password_vendedor">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <hr class="w-100">
                        <h4 class="col-12">Resumen de Venta</h4>
                        <div class="col-8" id="contentModalDetalle">

                        </div>
                        <div class="col-4">
                            <label for="metodo_pago">Metodo de pago</label>
                            <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                                <option value="">Seleccione el metodo de pago</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                            <div class="custom-control custom-checkbox mb-3 mt-2 text-right">
                                <input type="checkbox" class="custom-control-input" name="domicilio" id="domicilio" value="1">
                                <label class="custom-control-label" for="domicilio">Domicilio</label>
                            </div>
                            <div class="custom-control custom-checkbox mb-3 mt-2 text-right">
                                <input type="checkbox" class="custom-control-input" name="propina" id="propina" value="1">
                                <label class="custom-control-label" for="propina">Propina</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="ValidarVenta()">Enviar</button>
            </div>
        </div>
    </div>
</div>
@endsection

