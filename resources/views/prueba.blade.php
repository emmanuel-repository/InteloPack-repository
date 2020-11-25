<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('static/dist/css/loader_box.css')}}">
    <title>Hello, world!</title>
</head>

<body>
    <button type="button" class="btn btn-primary" id="btn_prueba">Primary</button>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{url('static/plugins/moment/moment.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '#btn_prueba', function () {
                var hoy = new Date();
                var fecha_convertida = moment(hoy).format('YYYYMMDDhmmss');
                alertLoader()
                $.ajax({
                    url: '/empleado/prueba',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        fecha: fecha_convertida
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.response_code == 200) {
                            successAlert(data.response_text);
                        } else if (data.response_code == "500") {}
                    },
                    error: function (xhr) {
                        infoAlert('Error Fatal', 'Se produjo un error desconocido');
                    }
                });
            });

            function alertLoader() {
                Swal.fire({
                    title: 'Espere un momento, cargando...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    width: 600,
                    padding: '3em',
                    background: 'rgb(0 0 123 / 0%)',
                    backdrop: 'rgba(0,0,123,0.4) left top no-repeat',
                    html: '<div className="col-sm-12"><div class="loader loader--snake"></div>'

                });
            }

            function infoAlert(mensaje, text) {
                Swal.fire(
                    mensaje, text, 'question'
                )
            }

            function successAlert(text) {
                Swal.fire(
                    '¡Exito!', text, 'success'
                )
            }


        })
    </script>
</body>

</html>