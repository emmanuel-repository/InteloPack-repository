<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <title>{{$titulo}}</title>
    <link rel="shortcut icon" href="{{url('static/imagenes_intelo/intelo_ico.ico')}}" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('static/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url('static/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('static/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('static/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('static/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{url('static/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('static/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('static/dist/css/adminlte.min.css')}}">
    {{-- loader --}}
    <link rel="stylesheet" href="{{url('static/dist/css/loader_box.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{url('static/plugins/summernote/summernote-bs4.css')}}">
    {{-- stepper --}}
    @if(Auth::user()->tipo_empleado_id == 4)
    <link rel="stylesheet" href="{{url('static/plugins/wizard/bd-wizard.css')}}">
    <link rel="stylesheet" href="{{url('static/plugins/quaggajs/styles.css')}}">
    @endif
    <style>
        .navbar-navy {
            background-color: #001f3f !important;
        }

        .password-icon {
            float: right;
            position: relative;
            margin: -26px 10px 0 0;
            cursor: pointer;
        }

    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('fragments_template.side_bar_fragment')
        @include('fragments_template.top_bar_fragment')
        <div class="content-wrapper">
            <section class="content pt-2">
                <div class="container-fluid">
                    @include('work_area.' . $work_area)
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <strong><a href="#">Políticas de Privacidad</a></strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Versión</b> Desarrollo
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- jQuery -->
    <script src="{{url('static/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{url('static/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{url('static/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    {{-- <!-- jQuery Knob Chart -->
    <script src="{{url('static/plugins/jquery-knob/jquery.knob.min.js')}}"></script> --}}
    <!-- overlayScrollbars -->
    <script src="{{url('static/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{url('static/dist/js/adminlte.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{url('static/dist/js/demo.js')}}"></script>
    <!-- DataTables -->
    <script src="{{url('static/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('static/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('static/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('static/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- moment js -->
    <script src="{{url('static/plugins/moment/moment.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{url('static/plugins/select2/js/select2.full.min.js')}}"></script>
    {{-- sweetalert 2 script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Bootstrap Switch -->
    <script src="{{url('static/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    {{-- Jquery Bar Code--}}
    <script src="{{url('static/plugins/bwip-js/bwip-js-min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{url('static/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('static/plugins/jquery-validation/app_charateres.js')}}"></script>
    <script src="{{url('static/plugins/jquery-validation/localization/messages_es.js')}}"></script>
    {{-- pdf-make  --}}
    <script src="{{url('static/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{url('static/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/html-to-pdfmake/browser.js"></script>
    {{-- <script src="{{url('static/plugins/pdfmake/browser.js')}}"></script> --}}
    <!-- Summernote -->
    <script src="{{url('static/plugins/summernote/summernote-bs4.min.js')}}"></script>
    {{--timer bar --}}
    {{-- <script src="https://www.jqueryscript.net/demo/Easy-jQuery-Progress-Bar-Timer-Plugin-For-Bootstrap-3-progressTimer/js/jquery.progressTimer.js"></script> --}}
    {{-- stepper --}}
    @if(Auth::user()->tipo_empleado_id == 4)
    {{-- escaner de ccodigos de barrras  --}}
    <script src="https://webrtc.github.io/adapter/adapter-latest.js" type="text/javascript"></script>
    <script src="{{url('static/plugins/quaggajs/quagga.min.js')}}"></script>
    {{-- wizard --}}
    <script src="{{url('static/plugins/wizard/jquery.steps.js')}}"></script>
    @endif
    {{-- my jquery --}}
    <script src="{{url('static/my_jquerys/'. $my_jquery)}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $.widget.bridge('uibutton', $.ui.button)

    </script>
</body>

</html>
