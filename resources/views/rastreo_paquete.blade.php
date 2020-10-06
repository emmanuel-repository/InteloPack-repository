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
            <div class="col-sm-4 pt-3">
                <div class="card mb-1 card-outline card-danger">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-start align-items-center">
                                <h5 class="text-secondary">Ingrese guia de rastreo</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-1">
                        <form id="form_validate_bar_code">
                            <div class="form-row">
                                <div class="form-group col-md-8 pt-0">
                                    <label for="recipient-name" class="col-form-label"></label>
                                    <input type="number" class="form-control" id="bar_code" name="bar_code">
                                </div>
                                <div class="col-md-4 pt-4">
                                    <button class="btn btn-warning" type="submit" id="btn_buscar">
                                        <i class="fa fa-search" aria-hidden="true"></i>Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 pt-3">
                <div class="card mb-1 card-outline card-primary">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start align-items-center">
                                <h5 class="text-secondary">Sistema de Paqueteria InteloPack</h5>
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
                    <div class="card-header card-primary" style="background-color: azure;">
                        <div class="form-row">
                            <div class="form-group col-md-4 mb-0">
                                <label for="recipient-name" class="col-form-label pb-0"
                                    style="font-size:14px; font-weight: 500;">Fecha de creación
                                </label>
                                <h6 class="text-primary" id="texto_fecha"></h6>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <label for="recipient-name" class="col-form-label pb-0"
                                    style="font-size:14px; font-weight: 500;">Nombre
                                </label>
                                <h6 class="text-primary" id="texto_nombre"></h6>
                            </div>
                            <div class="form-group col-md-4 mb-0">
                                <label for="recipient-name " class="col-form-label pb-0"
                                    style="font-size:14px; font-weight: 500; ">No. de guia
                                </label>
                                <h6 class="text-primary" id="text_no_guia"></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="imagen_portada">
                            <img src="{{url('static/imagenes_intelo/carrito_paqueteria.jpg')}}"
                                class="img-fluid rounded ">
                        </div>
                        <div class="col-sm-12">
                            <div class="timeline d-none" id="timeline">
                            </div>
                        </div>
                    </div>
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