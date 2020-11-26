<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Intelo Pack| 500 Error interno</title>
    <link rel="shortcut icon" href="{{url('static/imagenes_intelo/intelo_ico.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('static/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('static/dist/css/adminlte.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="error-page" style="margin: 17% auto 0;">
            <h2 class="headline text-danger">500</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i>¡Ups! Algo salió mal.</h3>
                <p>
                    Trabajaremos para solucionarlo de inmediato.
                    Mientras tanto, puede <a href="{{route('bienvenida.index')}}">volver al panel de control</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
