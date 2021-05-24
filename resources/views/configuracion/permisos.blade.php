@extends('layouts.app')

@section('mySripts') <script src="{{ asset('assets/js/permisos.js') }}"></script> @endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Permisos</h4>
                        <button type="button" class="btn btn-success" onclick="LimpiarInput()" data-toggle="modal" data-target="#modalAgregarPermiso">Agregar Permiso</button>
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
                                        <th scope="col">Nombre del Permiso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permisos as $permiso)
                                        <tr>
                                            <td>{{ $permiso->name }}  </td>
                                            <td>
                                                <span>
                                                    <a href="javascript:EditarPermiso({{ $permiso->id }})" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-pencil color-muted"></i>
                                                    </a>
                                                    <a href="javascript:EliminarPermiso({{ $permiso->id }})" data-toggle="tooltip" data-placement="top" title="Close">
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
<div class="modal fade" id="modalAgregarPermiso">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Permiso</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('permisos.create') }}" method="post" id="formCrearPermiso">
                    <!-- Token para encriptar -->
                    @csrf

                    <div class="form-row">
                        <label>Nombre</label>

                        <input type="text" class="form-control" name="name" id="name" placeholder="Escriba el nombre del permiso" required="">
                    </div>

                    <input type="hidden" name="id" id="id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('formCrearPermiso').submit()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
