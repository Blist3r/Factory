@extends('layouts.app')

@section('mySripts') <script src="{{ asset('assets/js/users.js') }}"></script> @endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Usuarios</h4>
                        <button type="button" class="btn btn-success" onclick="LimpiarInput()" data-toggle="modal" data-target="#modalAgregarUsuario">Agregar Usuario</button>
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
                                        <th scope="col">Sede</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Configuracion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <!-- En la tabla se pone el nombre segun lo digitado en el boton de agregar user -->
                                            <td>{{ $user->nombre }} {{ $user->apellido}} </td>
                                            <td>  {{ $user->identificacion }}  </td>
                                            <td>  {{ App\Models\Sede::find($user->sedes_id)->nombre }}  </td>
                                            <td> {{ $user->getRoleNames()[0] ?? "Sin tipo" }} </td>
                                            <td>
                                                <span>
                                                    <a href="javascript:EditarUser({{ $user->id }})" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-pencil color-muted"></i>
                                                    </a>
                                                    <a href="javascript:EliminarUser({{ $user->id }})" data-toggle="tooltip" data-placement="top" title="Close">
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
<div class="modal fade" id="modalAgregarUsuario">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.create') }}" method="post" id="formCrearUsuario">
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
                        <label>Contraseña</label>

                        <input type="password" class="form-control" name="password" id="password" placeholder="Escriba su contraseña" required="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Identificación</label>

                        <input type="number" class="form-control" name="identificacion" id="identificacion" placeholder="Escriba la identificacion del operador" required="" unique="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Sede</label>

                        <select name="sedes_id" id="sedes_id" class="form-control" required>
                            <option value="">Seleccione la sede</option>
                            <!-- Se crea un foreaach, para que busque las sedes que hay en la base de datos y se les da un orden -->
                            @foreach (App\Models\Sede::orderBy('nombre', 'ASC')->get() as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row mt-3">
                        <label>Tipo</label>

                        <select name="rol" id="rol" class="form-control" required>
                            <option value="">Seleccione el tipo</option>
                            <!-- Se crea un foreaach, para que busque las sedes que hay en la base de datos y se les da un orden -->
                            @foreach (\Spatie\Permission\Models\Role::orderBy('name', 'ASC')->get() as $tipo)
                                <option value="{{ $tipo->name }}">{{ $tipo->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="id" id="id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('formCrearUsuario').submit()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
