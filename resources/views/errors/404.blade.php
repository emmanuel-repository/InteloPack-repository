{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Intelo Pack| 404 Página no encontrada</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('static/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('static/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
    {{-- <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i>¡Ups! Página no encontrada.</h3>
                <p>
                    No pudimos encontrar la página que buscaba. Mientras tanto, 
                    puede <a href="../../index.html">volver al panel de control </a>.
                </p>
            </div>
        </div>
    </section> --}}

    <div class="card">
        <div class="card-body register-card-body">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>
                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i>¡Ups! Página no encontrada.</h3>
                    <p>
                        No pudimos encontrar la página que buscaba. Mientras tanto,
                        puede <a href="../../index.html">volver al panel de control </a>.
                    </p>
                </div>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</body>
</html>
