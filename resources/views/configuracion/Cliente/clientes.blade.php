@extends('layouts.app')

@section('mySripts') <script src="{{ asset('assets/js/clientes.js') }}"></script> @endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Clientes</h4>
                        <button type="button" class="btn btn-success" onclick="LimpiarInput()" data-toggle="modal" data-target="#modalAgregarCliente">Agregar Cliente</button>
                    </div>
                    <div class="card-body">
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
                                        <th scope="col">Nombre del Usuario</th>
                                        <th scope="col">Identificación</th>
                                        <th scope="col">Direccion</th>
                                        <th scope="col">Telefono</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">Configuracion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <!-- En la tabla se pone el nombre segun lo digitado en el boton de agregar user -->
                                            <td>{{ $cliente->nombre }} {{ $cliente->apellido}} </td>
                                            <td>  {{ $cliente->identificacion }}  </td>
                                            <td>  {{ $cliente->direccion }}  </td>
                                            <td>  {{ $cliente->telefono }}  </td>
                                            <td>  {{ $cliente->correo }}  </td>
                
                                            <td>
                                                <span>
                                                    <a href="javascript:EditarCliente({{ $cliente->id }})" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-pencil color-muted"></i>
                                                    </a>
                                                    <a href="javascript:EliminarCliente({{ $cliente->id }})" data-toggle="tooltip" data-placement="top" title="Close">
                                                        <i class="fa fa-close color-danger"></i>
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
<div class="modal fade" id="modalAgregarCliente">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clientes.create') }}" method="post" id="formCrearCliente">
                    <!-- Token para encriptar -->
                    @csrf

                    <div class="form-row">
                        <label>Nombre</label>

                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre del operador" required="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Apellido</label>

                        <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Escriba el apellido del operador" required="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Identificacion</label>

                        <input type="number" class="form-control" name="identificacion" id="identificacion" placeholder="Escriba la identificacion del cliente" required="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Direccion</label>

                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Escriba la direccion del cliente" >
                    </div>

                    <div class="form-row mt-3">
                        <label>Telefono</label>

                        <input type="number" class="form-control" name="telefono" id="telefono" placeholder="Escriba la direccion del cliente">
                    </div>

                    <div class="form-row mt-3">
                        <label>Correo</label>

                        <input type="email" class="form-control" name="correo" id="correo" placeholder="Escriba la direccion del cliente">
                    </div>

                    <input type="hidden" name="id" id="id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('formCrearCliente').submit()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
