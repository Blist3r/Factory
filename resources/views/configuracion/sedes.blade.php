@extends('layouts.app')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Table Stripped</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarSede">Agregar Sede</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Task</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Deadline</th>
                                        <th scope="col">Label</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Air Conditioner</td>
                                        <td>
                                            <div class="progress" style="background: rgba(127, 99, 244, .1)">
                                                <div class="progress-bar bg-primary" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Apr 20,2018</td>
                                        <td><span class="badge badge-primary">70%</span>
                                        </td>
                                        <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted"></i> </a><a
                                                    href="javascript:void()" data-toggle="tooltip"
                                                    data-placement="top" title="Close"><i
                                                        class="fa fa-close color-danger"></i></a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Textiles</td>
                                        <td>
                                            <div class="progress" style="background: rgba(76, 175, 80, .1)">
                                                <div class="progress-bar bg-success" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>May 27,2018</td>
                                        <td><span class="badge badge-success">70%</span>
                                        </td>
                                        <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted"></i> </a><a
                                                    href="javascript:void()" data-toggle="tooltip"
                                                    data-placement="top" title="Close"><i
                                                        class="fa fa-close color-danger"></i></a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Milk Powder</td>
                                        <td>
                                            <div class="progress" style="background: rgba(70, 74, 83, .1)">
                                                <div class="progress-bar bg-dark" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>May 18,2018</td>
                                        <td><span class="badge badge-dark">70%</span>
                                        </td>
                                        <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted"></i> </a><a
                                                    href="javascript:void()" data-toggle="tooltip"
                                                    data-placement="top" title="Close"><i
                                                        class="fa fa-close color-danger"></i></a></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Boats</td>
                                        <td>
                                            <div class="progress" style="background: rgba(255, 193, 7, .1)">
                                                <div class="progress-bar bg-warning" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Jun 28,2018</td>
                                        <td><span class="badge badge-warning">70%</span>
                                        </td>
                                        <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted"></i> </a><a
                                                    href="javascript:void()" data-toggle="tooltip"
                                                    data-placement="top" title="Close"><i
                                                        class="fa fa-close color-danger"></i></a></span>
                                        </td>
                                    </tr>
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

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection
