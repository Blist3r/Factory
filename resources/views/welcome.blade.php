@extends('layouts.app')

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
                <div class="row">
                    @foreach ($productos as $producto)
                        <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-arrival-product">
                                        <div class="new-arrivals-img-contnent">
                                            <img class="img-fluid" src="{{ asset('storage/'.$producto->imagen) }}" alt="">
                                        </div>
                                        <div class="new-arrival-content text-center mt-3">
                                            <h4>{{ $producto->nombre }}</h4>
                                            <span class="price">${{ number_format($producto->valor) }}</span>
                                        </div>
                                        <div class="row">
                                            <div class="shopping-cart mt-3 d-flex">
                                                <input type="number" name="num" class="form-control input-btn input-number" value="1">
                                                <a class="btn btn-primary ml-2" href="#"><i class="fa fa-shopping-basket"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                                            <span class="badge badge-primary badge-pill">3</span>
                                        </h4>
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">Product name</h6>
                                                    <small class="text-muted">Brief description</small>
                                                </div>
                                                <span class="text-muted">$12</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">Second product</h6>
                                                    <small class="text-muted">Brief description</small>
                                                </div>
                                                <span class="text-muted">$8</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                <div>
                                                    <h6 class="my-0">Third item</h6>
                                                    <small class="text-muted">Brief description</small>
                                                </div>
                                                <span class="text-muted">$5</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between active">
                                                <div class="text-white">
                                                    <h6 class="my-0 text-white">Promo code</h6>
                                                    <small>EXAMPLECODE</small>
                                                </div>
                                                <span class="text-white">-$5</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span>Total (USD)</span>
                                                <strong>$20</strong>
                                            </li>
                                        </ul>

                                        <form>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Promo code">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Redeem</button>
                                                </div>
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

