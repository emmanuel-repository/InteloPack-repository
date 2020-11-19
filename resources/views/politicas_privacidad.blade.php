<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <title>{{$titulo}}</title>
    <link rel="shortcut icon" href="{{url('static/imagenes_intelo/intelo_ico.ico')}}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('static/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{url('static/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('static/dist/css/adminlte.min.css')}}">
    {{-- loader --}}
    <link rel="stylesheet" href="{{url('static/dist/css/loader_box.css')}}">
    <style>
        .header-banner {
            background-color: #333;
            background-image: url('{{url("static/imagenes_intelo/background_header.jpg")}}');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.8;
            width: 100%;
            height: 150px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-banner d-flex justify-content-center">
            <a href="{{url('/')}}">
                <img src="{{url('static/imagenes_intelo/intelo_logo_modificado.png')}}" width="250" height="150">
            </a>
        </div>
    </header>
    <div class="container mb-3">
        <div class="row">
            <div class="col-sm-12 pt-3">
                <div class="card mb-1 card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start align-items-center">
                                <h5 class="text-secondary">Política de privacidad</h5>
                            </div>
                            <div class="form-group col-md-6 d-flex justify-content-end m-0">
                                <a class="btn btn-light mr-1 d-none" id="btn_limpiar_panel" data-toggle='tooltip'
                                    data-placement='right' title='Limpiar panel'>
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a class="btn btn-success d-none" data-toggle='tooltip' id="btn_actualizar"
                                    data-placement='right' title='Actualizar'>
                                    <i class="fas fa-redo-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- <footer class="footer">
        <div class="container">
            <span class="text-muted">Hola mundo</span>
        </div>
    </footer> --}}
    <!-- jQuery -->
    <script src="{{url('static/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{url('static/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{url('static/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{url('static/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{url('static/dist/js/demo.js')}}"></script>
    {{-- sweetalert 2 script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- jquery-validation -->
    <script src="{{url('static/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('static/plugins/jquery-validation/app_charateres.js')}}"></script>
    <script src="{{url('static/plugins/jquery-validation/localization/messages_es.js')}}"></script>
    {{-- my jquery --}}
    <script src="{{url('static/my_jquerys/' . $my_jquery)}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $.widget.bridge('uibutton', $.ui.button)
    </script>
</body>

</html>