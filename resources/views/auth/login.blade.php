<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Davur - Restaurant Food Order Bootstrap Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png')}}">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Ingresa a la Factory</h4>
                                    <form action="{{ route('login')}}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Identificación</strong></label>

                                            
                                            <!-- Se pone en la clase "form-control @error('identificacion') is-invalid @enderror" para que redibujo la casilla en rojo indicando que esta errado, pero se poneun value con "{{ old('identificacion') }}" para que NO borre la informacion dada. -->
                                            <!-- Mensaje de error para Identificacion -->
                                            
                                            <input name="identificacion" id="identificacion" type="number" required="" class="form-control @error('identificacion') is-invalid @enderror" value="{{ old('identificacion') }}" placeholder="Ingrese su identificación">
                                            @error('identificacion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror                                        
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Contraseña</strong></label>
                                            
                                            
                                            <!-- Se pone en la clase "form-control @error('password') is-invalid @enderror" para que borre el dato actual y redibuje la casilla en rojo indicando que el dato esta errado -->
                                            <!-- Mensaje de error para contraseña -->

                                            <input name="password" id="password" type="password" required="" class="form-control @error('password') is-invalid @enderror" placeholder="Ingrese su contraseña">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror    
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Recuerdame</label>
												</div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                                        </div>
                                        <div class="text-center mt-5 mb-0">
                                            <label class="mb-0">La Factory Fast Food 2021 ©</label>
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


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
	<script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./js/custom.min.js"></script>
    <script src="./js/deznav-init.js"></script>

</body>

</html>