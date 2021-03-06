@extends('layouts.app')

@section('mySripts') <script src="{{ asset('assets/js/sedes.js') }}"></script> @endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sedes</h4>
                        <button type="button" class="btn btn-success" onclick="LimpiarInput()" data-toggle="modal" data-target="#modalAgregarSede">Agregar Sede</button>
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

                            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre de la Sede</th>
                                        <th scope="col">Configuracion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sedes as $sede)
                                        <tr>
                                            <td>{{ $sede->nombre }}</td>
                                            <td>
                                                <span>
                                                    <a href="javascript:EditarSede({{ $sede->id }})" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-pencil color-muted"></i>
                                                    </a>
                                                    <a href="javascript:EliminarSede({{ $sede->id }})" data-toggle="tooltip" data-placement="top" title="Close">
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
<div class="modal fade" id="modalAgregarSede">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Sede</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sedes.create') }}" method="post" id="formCrearSede">
                    <!-- Token para encriptar -->
                    @csrf

                    <div class="form-row">
                        <label>Nombre</label>

                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre de la sede" required="">
                    </div>
                    <input type="hidden" name="id" id="id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('formCrearSede').submit()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
