$(document).ready(function () {
    cargar_time_line();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var form_validate_agregar = $('#form_validate_bar_code').validate({
        rules: {
            bar_code: {
                required: true,
            }
        },
        messages: {},
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function () {
            var bar_code = $('#bar_code').val();
            rastrear(bar_code);
        }
    });

    $(document).on('click', '#btn_limpiar_panel', function () {
        $('#btn_limpiar_panel').addClass('d-none');
        $('#btn_actualizar').addClass('d-none');
        $('#texto_fecha').text('');
        $('#texto_nombre').text('');
        $('#text_no_guia').text('');
        $('#imagen_portada').removeClass('d-none');
        $('#timeline').addClass('d-none');
        $('#timeline').empty();
        $('#btn_buscar').removeAttr("disabled");
        $('#bar_code').removeAttr('readonly');
        $('#bar_code').val('');
    });

    $(document).on('click', '#btn_actualizar', function () {
        $('#timeline').empty();
        var bar_code = $('#bar_code').val();
        rastrear(bar_code);
    });

    function cargar_time_line() {
        const url = window.location.href;
        var url_separado = url.split('rastreo_paquete/');
        if (url_separado.length == 2) {
            if (url_separado[1] == "") {
                console.log(url_separado[1])
            } else {
                $('#bar_code').val(url_separado[1]);
                rastrear(url_separado[1]);
            }
        }
    }

    function rastrear(bar_code) {
        alertLoader();
        $.ajax({
            url: '/rastreo_paquete/' + bar_code + '/edit',
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.response_code == 200) {
                    var array = [];
                    var array_order = [];
                    var contenido = '';
                    var cliente = data.response_data_cliente;
                    var rastreo = data.response_data_rastreo;
                    var visitas = data.response_data_visitas;
                    $('#texto_fecha').text(cliente.created_at);
                    $('#texto_nombre').text(cliente.nombre + ' ' + cliente.apellido_1
                        + ' ' + cliente.apellido_2);
                    $('#text_no_guia').text(cliente.no_paquete);
                    $('.timeline').removeClass('d-none');
                    $('#imagen_portada').addClass('d-none');
                    if (visitas != undefined) {
                        array = rastreo.concat(visitas)
                        array_order = array.sort((a, b) => (a.estatus_cross_over 
                            > b.estatus_cross_over) ? 1 : -1);
                        console.log(array_order);
                    } else {
                        array_order = rastreo;
                    }
                    for (var i = 0; i < array_order.length; i++) {
                        if (i == 0) {
                            contenido += '<div class="time-label">'
                                + '<span class="bg-red">' + array_order[i].fecha_cross_over + '</span>'
                                + '</div><div><i class="fas fa-warehouse bg-info"></i>'
                                + '<div class="timeline-item">'
                                + '<span class="time"><i class="fas fa-calendar-alt"></i> '
                                + array_order[i].fecha_cross_over + ' </span>'
                                + '<h3 class="timeline-header">Paquete creado en espera de salida '
                                + '(Sucursal: ' + array_order[i].nombre_socursal + ', '
                                + array_order[i].estado_socursal + ') </h3></div></div>'
                        } else {
                            if (array_order[i].estatus_cross_over == 2) {
                                contenido += '<div>' + '<i class="fas fa-truck bg-success"></i>'
                                    + '<div class="timeline-item"><span class="time">'
                                    + '<i class="fas fa-calendar-alt"></i> '
                                    + array_order[i].fecha_cross_over + '</span>'
                                    + '<h3 class="timeline-header no-border">Paquete en ruta'
                                    + '</h3></div></div>'
                            } else if (array_order[i].estatus_cross_over == 3) {
                                contenido += '<div>' + '<i class="fas fa-warehouse bg-warning"></i>'
                                    + '<div class="timeline-item"><span class="time">'
                                    + '<i class="fas fa-calendar-alt"></i> '
                                    + array_order[i].fecha_cross_over + '</span>'
                                    + '<h3 class="timeline-header no-border">'
                                    + 'En sucursal intermedia ' + '(Socursal: '
                                    + array_order[i].nombre_socursal + ', '
                                    + array_order[i].estado_socursal + ') </h3></div></div>'
                            } else if (array_order[i].estatus_cross_over == 4) {
                                contenido += '<div>' + '<i class="fas fa-clipboard-check bg-primary">'
                                    + '</i><div class="timeline-item">'
                                    + '<span class="time"><i class="fas fa-calendar-alt"></i> '
                                    + array_order[i].fecha_cross_over + '</span>'
                                    + '<h3 class="timeline-header no-border">Envío entregado</h3></div></div>'
                            } else if (array_order[i].estatus_cross_over == 3.5) {
                                contenido += '<div>' + '<i class="fas fa-dolly"'
                                    + 'style="color: #fff!important; background-color: #fd7e14!important;"> '
                                    + '</i><div class="timeline-item">'
                                    + '<span class="time"><i class="fas fa-calendar-alt"></i> '
                                    + array_order[i].fecha_cross_over + '</span>'
                                    + '<h3 class="timeline-header no-border"> Visitado en domicilio. '
                                    + array_order[i].descripcion_visita + '</h3></div></div>'
                            }
                        }
                    }
                    $('#btn_limpiar_panel').removeClass('d-none');
                    $('#btn_actualizar').removeClass('d-none');
                    $('#bar_code').attr('readonly', 'readonly');
                    $('#btn_buscar').attr("disabled", true);
                    $('#timeline').append(contenido);
                    Swal.close();
                } else if (data.response_code == 500) {
                    infoAlert("Verifica", data.response_text);
                } else {
                    infoAlert("Verifica", data.response_text);
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function successAlert(text) {
        Swal.fire(
            '¡Exito!', text, 'success'
        )
    }

    function infoAlert(mensaje, text) {
        Swal.fire(
            mensaje, text, 'question'
        )
    }

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
})