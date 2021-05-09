@extends('layouts.app')

@section('mySripts') <script src="{{ asset('assets/js/venta.js') }}"></script> @endsection

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
                                                <select name="categorias_id" id="categorias_id" class="form-control" required>
                                                    <option value="">Seleccione la categoria</option>
                                                    <!-- Se crea un foreaach, para que busque las sedes que hay en la base de datos y se les da un orden -->
                                                    @foreach ($categorias as $categoria)
                                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mt-2 mt-sm-0">
                                                <input type="text" class="form-control" placeholder="Busque un producto">
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
                                        <ul class="list-group mb-3" id="detalle_venta">

                                        </ul>
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item d-flex justify-content-between active">
                                                <span>Total</span>
                                                <strong id="total_valor">$0</strong>
                                            </li>
                                        </ul>

                                        <form>
                                            <div class="input-group">
                                                <a class="btn btn-primary btn-block" href="#">Realizar venta</a>
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
@endsection

