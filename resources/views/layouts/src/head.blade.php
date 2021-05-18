<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Factory</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="20x20" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
	{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist.min.css') }}"> --}}
    <link href="{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('myStyles')

</head>
