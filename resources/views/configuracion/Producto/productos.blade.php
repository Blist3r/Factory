@extends('layouts.app')

@section('mySripts') <script src="{{ asset('assets/js/productos.js') }}"></script> @endsection

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Productos</h4>
                        <button type="button" class="btn btn-success" onclick="LimpiarInput()" data-toggle="modal" data-target="#modalAgregarProducto">Agregar Producto</button>
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
                                        <th scope="col">Imagen del Producto</th>
                                        <th scope="col">Nombre del Producto</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Configuracion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                        <!-- Se agregan los espacios cada dato en la tabla -->
                                        <td> <div class="d-flex align-items-center"><img src=" {{ asset('storage/'.$producto->imagen) }} " class="rounded-lg mr-2" width="80" alt=""></div>  </td>
                                        <td> {{ $producto->nombre }} </td>
                                        <td> {{ $producto->descripcion }} </td>
                                        <td> {{ $producto->valor }} </td>
                                        <td>  {{ App\Models\Categoria::find($producto->categorias_id)->nombre }}  </td>

                                            <td>
                                                <span>
                                                    <a href="javascript:EditarProducto({{ $producto->id }})" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="fa fa-pencil color-muted"></i>
                                                    </a>
                                                    <a href="javascript:EliminarProducto({{ $producto->id }})" data-toggle="tooltip" data-placement="top" title="Close">
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
<div class="modal fade" id="modalAgregarProducto">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('productos.create') }}" method="post" id="formCrearProducto" enctype="multipart/form-data">
                    <!-- Token para encriptar -->
                    @csrf
                    <label>Imagen</label>
                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Subir la imagen</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="imagen" id="imagen">
                                 <label class="custom-file-label">Elegir el archivo </label>
                        </div>
                    </div>
                    
                    <div class="form-row mt-3">
                        <label>Nombre</label>

                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escriba el nombre del producto" required="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Descripción</label>

                        <input type="longText" class="form-control" name="descripcion" id="descripcion" placeholder="Escriba la descripcion del producto" required="">
                    </div>

                    <div class="form-row mt-3">
                        <label>Valor</label>

                        <input type="integer" class="form-control" name="valor" id="valor" placeholder="Escriba el valor del producto" required="">
                    </div>

                    <div class="form-row mt-3"> 
                        <label>Categorias</label>

                        <select name="categorias_id" id="categorias_id" class="form-control" required>
                            <option value="">Seleccione la categoria</option>
                            <!-- Se crea un foreaach, para que busque en el arreglo los valores que hay y los vuelva un valor. -->
                            @foreach (App\Models\Categoria::orderBy('nombre', 'ASC')->get() as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="id" id="id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('formCrearProducto').submit()">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
        