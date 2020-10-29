$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    cargar_tabla();

    $('#data_table_transporte_empleado').DataTable();
    $('#chofer').select2({ theme: 'bootstrap4' });
    $('#transporte').select2({ theme: 'bootstrap4' });
    $('#sucursal').select2({ theme: 'bootstrap4' });

    var form_validate_agregar = $('#form_validate_transporte_empleado').validate({
        rules: {
            sucursal: {
                required: true,
            },
            chofer: {
                required: true,
            },
            transporte: {
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
            agregar()
        }
    });

    $(document).on('click', '#btn_open_modal_transporte', function () {
        $('#modal_transporte').modal({ backdrop: 'static', keyboard: false });
        $("#modal_transporte").modal("show");
    });

    $(document).on('click', '.btn_cancelar', function () {
        limpiar_inputs();
    });

    $(document).on('change', '#sucursal', function () {
        id_sucursal = $('#sucursal').val();
        $('#chofer').empty();
        $('#transporte').empty();
        cargar_choferes(id_sucursal);
        cargar_transportes(id_sucursal);
    });

    $(document).on('click', '#btn_quitar_asignacion', function () {
        var tabla = $("#data_table_transporte_empleado").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_empleado = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Activar esta Sucursal!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, activar Sucursal!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                quitar_asinacion(id_empleado)
            }
        });
    });

    function agregar() {
        var formElement = document.getElementById("form_validate_transporte_empleado");
        var form = new FormData(formElement);
        $.ajax({
            url: '/empleado/transporte_empleado',
            type: 'POST',
            dataType: 'json',
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#chofer').empty();
                    $('#transporte').empty();
                    $("#sucursal option[value='']").prop("selected", "selected");
                    cargar_tabla();
                    successAlert(data.response_text);
                } else if (data.response_code == 500) {
                    infoAlert("Verifica", data.response_text);
                } else {
                    infoAlert("Verifica", data.response_text);
                }
            },
            error: function (xhre) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function quitar_asinacion(id) {
        $.ajax({
            url: "/empleado/transporte_empleado/" + id,
            type: "delete",
            dataType: "json",
            data: { _token: CSRF_TOKEN },
            success: function (data) {
                if (data.response_code == 200) {


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

    function cargar_tabla() {
        $.ajax({
            url: "/empleado/transporte_empleado/create",
            method: "get",
            dataType: "json",
            data: { _token: CSRF_TOKEN, },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#data_table_transporte_empleado').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "data": data.response_data,
                        "columns": [{
                            'data': 'no_transporte',
                        },
                        {
                            'data': 'matricula_transporte',
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                return data.nombre_empleado + ' ' + data.apellido_1_empleado
                                    + ' ' + data.apellido_2_empleado;
                            }
                        },
                        {
                            'data': 'nombre_socursal',
                        },
                        {
                            'data': null,
                            'defaultContent': "<a id='btn_quitar_asignacion' class='btn btn-outline-warning btn-sm'" +
                                " data-toggle='tooltip' data-placement='right' title='Desvincular transporte con el operador'>" +
                                "<i class='fa fa-user-times'></i></a>"
                        },
                        ],
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
                            },
                        },
                        "columnDefs": [{
                            "className": "text-center",
                            "targets": "_all"
                        }],
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                } else if (data.response_code == "500") {}
            },
            error: function (xhr) {
                infoAlert('Error Fatal', 'Se produjo un error desconocido');
            }
        });
    }

    function cargar_choferes(id_sucursal) {
        $.ajax({
            url: '/empleado/transporte_empleado/' + id_sucursal,
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var empleado = data.response_data;
                var select_2 = $('#chofer');
                select_2.append('<option value="">Seleccione una opción</option>');
                for (var i = 0; i < empleado.length; i++) {
                    select_2.append('<option value="' + empleado[i].id + '">'
                     + "<b>No. de Empleado:</b> " + empleado[i].no_empleado + " | "
                        + empleado[i].nombre_empleado + " "
                        + empleado[i].apellido_1_empleado + " "
                        + empleado[i].apellido_2_empleado + '</option>');
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function cargar_transportes() {
        $.ajax({
            url: '/empleado/transporte_empleado/' + id_sucursal + '/edit',
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var transporte = data.response_data;
                var select_2 = $('#transporte');
                select_2.append('<option value="">Seleccione una matricula de Transporte</option>');
                for (var i = 0; i < transporte.length; i++) {
                    select_2.append('<option value="' + transporte[i].id + '">'
                        + 'No. de transporte: ' + transporte[i].no_transporte + ' | ' 
                        + 'Matricula: '  + transporte[i].matricula_transporte + '</option>');
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function limpiar_inputs() {
        $('#sucursal option[value=""]').prop("selected", "selected");
        $('#chofer').empty();
        $('#transporte').empty();
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
})




