$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#tabla_paquetes').DataTable({
        'language': {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "loadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    $('#socursal').select2({ theme: 'bootstrap4' });
    $('#transporte').select2({ theme: 'bootstrap4' });

    var form_validate_agregar = $('#form_validate_agregar_paquete').validate({
        rules: {
            transporte: {
                required: true,
            },
            codigo_barra: {
                required: true
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
            cargar_paquete();
        }
    });

    $(document).on('change', '#socursal', function () {
        var id_socursal = $(this).val();
        $('#transporte').empty();
        $('#socursal').select2({ disabled: true });
        cargar_transportes(id_socursal);
    });

    $(document).on('change', '#transporte', function () {
        $('#transporte').select2({ disabled: true });
    });

    $(document).on('click', '#btn_cancelar_paquete', function () {
        $("#socursal option[value='']").prop("selected", "selected");
        $('#socursal').select2({ disabled: false });
        $('#transporte').select2({ disabled: false });
        $('#transporte').empty();
        $('#codigo_barra').val('');
    });

    $(document).on('click', '#btn_remover_paquete', function () {
        var tabla = $("#tabla_paquetes").DataTable();
        var row = tabla.row($(this).parent().parent());
        tabla.row(row).remove().draw(false);
    });

    $(document).on('click', '#btn_guardar_cargamento', function () {
        insert();
    });

    $(document).on('click', '#btn_limpiar_tabla', function () {
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡De limpiar la tabla! Todos los paquetes se van a quitar de la tabla.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, limpiar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var tabla = $("#tabla_paquetes").DataTable();
                tabla.clear().draw(false);
            }
        });
    });

    function cargar_paquete() {
        var validador = false;
        var tabla = $('#tabla_paquetes').DataTable();
        var transporte = $('#transporte option:selected').text();
        var codigo_barras = $('#codigo_barra').val();
        var data = data = tabla.rows().data();
        $.ajax({
            url: '/empleado/cargar_paquetes/' + codigo_barras + "/edit",
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (value) {
                if (value.response_code == 200) {
                    if (data.length == 0) {
                        tabla.row.add([codigo_barras, transporte, value.response_data,
                            "<a id='btn_remover_paquete' class='btn btn-outline-danger btn-sm'" +
                            " data-toggle='tooltip' data-placement='right' " +
                            " title='Quitar paquete de este transporte'>" +
                            "<i class='fa fa-minus'></i></a>"
                        ]).draw(false);
                    } else {
                        for (var i = 0; i < data.length; i++) {
                            var validar_codigo = data[i][0];
                            if (validar_codigo == codigo_barras) {
                                validador = true;
                            }
                        }
                        if (!validador) {
                            tabla.row.add([codigo_barras, transporte, value.response_data,
                                "<a id='btn_remover_paquete' class='btn btn-outline-danger btn-sm'" +
                                " data-toggle='tooltip' data-placement='right' " +
                                " title='Quitar paquete de este transporte'>" +
                                "<i class='fa fa-minus'></i></a>"
                            ]).draw(false);
                        } else {
                            var mensaje = "Verifica"
                            var texto = "Ya se encuentra cargado en la tabla ese Paquete"
                            infoAlert(mensaje, texto)
                        }
                    }
                    $('#codigo_barra').val('');
                } else if (value.response_code == 500) {
                    infoAlert("Verifica", value.response_text);
                } else {
                    infoAlert("Verifica", value.response_text);
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", value.response_text);
            }
        });
    }

    function cargar_transportes(id_sucursal) {
        $.ajax({
            url: '/empleado/cargar_paquetes/' + id_sucursal,
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var transporte = data.response_data;
                var select_2 = $('#transporte');
                select_2.append('<option value="">Seleccione una opción</option>');
                for (var i = 0; i < transporte.length; i++) {
                    select_2.append('<option value="' + transporte[i].id + '">'
                        + "</br> <b>No de transporte:</b> "
                        + transporte[i].no_transporte + ". </br> <b> | Matricula:</b> "
                        + transporte[i].matricula_transporte +
                        '</option>');
                }
                $('#transporte').select2({ theme: 'bootstrap4' });
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function insert() {
        var arreglo = [];
        var json_tabla;
        var tabla = $("#tabla_paquetes").DataTable();
        var datos_tabla = tabla.rows().data();
        var longitud = datos_tabla.length;
        var hoy = new Date();
        var fecha = moment(hoy).format('YYYY-MM-DD');
        var hora = moment(hoy).format('h:mm:ss a')
        var id_transporte = $('#transporte').val();
        if (longitud > 0) {
            for (i = 0; i < datos_tabla.length; i++) {
                var row = datos_tabla[i];
                var person = {
                    no_paquete: row[0],
                    id_transporte: id_transporte,
                    fecha: fecha,
                    hora: hora
                };
                arreglo.push(person);
            }
            json_tabla = JSON.stringify(arreglo);
            alertLoader();
            $.ajax({
                url: '/empleado/cargar_paquetes',
                type: 'POST',
                dataType: 'json',
                data: { json_tabla: json_tabla, transporte: id_transporte },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.response_code == 200) {
                        successAlert(data.response_text);
                        tabla.clear().draw(false);
                        limpiar_inputs();
                    } else if (data.response_code == 500) {
                        infoAlert("Verifica", data.response_text);
                    } else {
                        infoAlert("Verifica", data.response_text);
                    }
                },
                error: function (xhre) {
                    Swal.close();
                    infoAlert("Verifica", data.response_text);
                }
            });
        } else {
            infoAlert("Verifica", 'La tabla no contiene paquetes cargados');
        }
    }

    function limpiar_inputs() {
        $("#socursal option[value='']").prop("selected", "selected");
        $('#socursal').select2({ disabled: false });
        $('#transporte').select2({ disabled: false });
        $('#transporte').empty();
        $('#codigo_barra').val('');
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

    // function alertLoader() {
    //     Swal.fire({
    //         title: 'Espere un momento, cargando...',
    //         allowOutsideClick: false,
    //         showConfirmButton: false,
    //         width: 600,
    //         padding: '3em',
    //         background: 'rgb(0 0 123 / 0%)',
    //         backdrop: 'rgba(0,0,123,0.4) left top no-repeat',
    //         html: '<div class="spinner-grow text-primary" role="status"></div>' +
    //             '<div class="spinner-grow text-secondary" role="status"></div>' +
    //             '<div class="spinner-grow text-success" role="status"></div>' +
    //             '<div class="spinner-grow text-danger"" role="status"></div>' +
    //             '<div class="spinner-grow text-warning" role="status"></div>' +
    //             '<div class="spinner-grow text-light" role="status"></div>' +
    //             '<div class="spinner-grow text-dark" role="status"></div>'
    //     });
    // }    
})