<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Intelo Pack| 404 Página no encontrada</title>
    <link rel="shortcut icon" href="{{url('static/imagenes_intelo/intelo_ico.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('static/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('static/dist/css/adminlte.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="error-page" style="margin: 17% auto 0;">
            <h2 class="headline text-success">419</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i>¡Ups! Termino tu sesión.</h3>
                <p>
                    A expirado tu tiempo de sesión. Mientras tanto, puedes
                    <a href="{{route('bienvenida.index')}}">volver a pagina de inicio de sesión</a>
                    para iniciar una nueva sesión.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
