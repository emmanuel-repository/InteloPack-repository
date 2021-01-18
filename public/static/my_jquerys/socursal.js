$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    cargar_estados_sepomex();
    cargar_tabla();

    $('#data_table_empleados').DataTable();
    $('#estado_socursal').select2({ theme: 'bootstrap4' });
    $('#municipio_socursal').select2({ theme: 'bootstrap4' });
    $('#colonia_socursal').select2({ theme: 'bootstrap4' });
    $('#municipio_socursal_editar').select2({ theme: 'bootstrap4' });
    $('#colonia_socursal_editar').select2({ theme: 'bootstrap4' });

    var form_validate_agregar = $('#form_validate_agregar_socursal').validate({
        rules: {
            nombre_socursal: {
                required: true,
            },
            estado_socursal: {
                required: true
            },
            municipio_socursal: {
                required: true
            },
            codigo_postal: {
                required: true
            },
            colonia_socursal: {
                required: true
            },
            calle_socursal: {
                required: true
            },
            no_exterior: {
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

    $('#form_validate_editar_socursal').validate({
        rules: {
            nombre_socursal_editar: {
                required: true,
            },
            estado_socursal_editar: {
                required: true
            },
            municipio_socursal_editar: {
                required: true
            },
            codigo_postal_editar: {
                required: true
            },
            colonia_socursal_editar: {
                required: true
            },
            calle_socursal_editar: {
                required: true
            },
            no_exterior_editar: {
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
            editar();
        }
    });

    $(document).on('click', '#btn_open_modal_empleado', function () {
        $('#modal_agregar_socursal').modal({ backdrop: 'static', keyboard: false });
        $("#modal_agregar_socursal").modal("show");
    });

    $(document).on('click', '#btn_editar_socursal', function () {
        var tabla = $("#data_table_socursal").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var estado = data.estado_socursal;
        var municipio = data.municipio_socursal;
        var codigo_postal = data.codigo_postal_socursal;
        var colonia = data.colonia_socursal;
        $('#id_socursal_editar').val(data.id);
        $('#nombre_socursal_editar').val(data.nombre_socursal);
        $('#codigo_postal_editar').val(data.codigo_postal_socursal);
        $('#calle_socursal_editar').val(data.calle_socursal);
        $('#no_exterior_editar').val(data.no_exterior_socursal);
        $('#no_interior_editar').val(data.no_interior_socursal);
        $('#estado_socursal_editar').val(data.estado_socursal);
        $('option', '#municipio_socursal_editar').remove();
        $('option', '#colonia_socursal_editar').remove();
        municipios_sepomex_edit(estado, municipio);
        colonias_sepomex_edit(codigo_postal, colonia);
        $('#modal_editar_socursal').modal({ backdrop: 'static', keyboard: false });
        $("#modal_editar_socursal").modal("show");
    });

    $(document).on('change', '#estado_socursal', function () {
        var estado = $(this).val();
        cargar_municipios_sepomex(estado)
    });

    $(document).on('blur', '#codigo_postal', function () {
        var codigo_postal = $(this).val();
        cargar_colonias_sepomex(codigo_postal);
    });

    $(document).on('blur', '#codigo_postal_editar', function () {
        var codigo_postal = $(this).val();
        cargar_colonias_sepomex_editar(codigo_postal);
    });

    $(document).on('click', '.btn_cancelar', function () {
        limpiar_inputs();
    });

    $(document).on('click', '#btn_desactivar_socursal', function () {
        var tabla = $("#data_table_socursal").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_socursal = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Desactivar esta sucursal!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, desactivar sucursal!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/empleado/socursal/" + id_socursal,
                    type: "delete",
                    dataType: "json",
                    data: { _token: CSRF_TOKEN },
                    success: function (data) {
                        if (data.response_code == 200) {
                            successAlert(data.response_text);
                            cargar_tabla();
                        } else if (data.response_code == 500) {
                            infoAlert("Verifica", data.response_text);
                        } else {
                            infoAlert("Verifica", data.response_text);
                        }
                    },
                    error: function (xhr) {
                        infoAlert("Verifica", data.response_text);
                    }
                })
            }
        })
    });

    $(document).on('click', '#btn_activar_socursal', function () {
        var tabla = $("#data_table_socursal").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_socursal = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Activar esta sucursal!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, activar sucursal!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/empleado/socursal/" + id_socursal + "/edit",
                    type: "get",
                    dataType: "json",
                    data: { _token: CSRF_TOKEN },
                    success: function (data) {
                        if (data.response_code == 200) {
                            successAlert(data.response_text);
                            cargar_tabla();
                        } else if (data.response_code == 500) {
                            infoAlert("Verifica", data.response_text);
                        } else {
                            infoAlert("Verifica", data.response_text);
                        }
                    },
                    error: function (xhr) {
                        infoAlert("Verifica", data.response_text);
                    }
                })
            }
        });
    });

    function agregar() {
        var formElement = document.getElementById("form_validate_agregar_socursal");
        var form = new FormData(formElement);
        $.ajax({
            url: '/empleado/socursal',
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
                    cargar_tabla();
                    limpiar_inputs();
                    form_validate_agregar.resetForm();
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

    function editar() {
        var formElement = document.getElementById("form_validate_editar_socursal");
        var form = new FormData(formElement);
        var id_socursal = $('#id_socursal_editar').val();
        $.ajax({
            url: '/empleado/socursal/' + id_socursal,
            type: 'post',
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
                    limpiar_inputs();
                    cargar_tabla();
                    $("#modal_editar_socursal").modal("hide");
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

    function cargar_tabla() {
        $.ajax({
            url: "/empleado/socursal/create",
            method: "get",
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
            },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#data_table_socursal').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "data": data.response_data,
                        "columns": [{
                            'data': "nombre_socursal"
                        },
                        {
                            'data': 'no_socursal',
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                var text = null;
                                if (data.estatus_socursal == '1') {
                                    text = "<h6 class='text-success'>Activo</h6> "
                                } else if (data.estatus_socursal == '0') {
                                    text = "<h6 class='text-danger'>Desactivado</h6> "
                                }
                                return text;
                            }
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                var text = null;
                                if (data.estatus_socursal == '1') {
                                    text = "<a id='btn_desactivar_socursal' class='btn btn-outline-danger btn-sm'" +
                                        " data-toggle='tooltip' data-placement='right' title='Desactivar Sucursal'>" +
                                        "<i class='fa fa-trash'></i></a>"
                                } else if (data.estatus_socursal == '0') {
                                    text = "<a id='btn_activar_socursal' class='btn btn-outline-success btn-sm'" +
                                        " data-toggle='tooltip' data-placement='right' title='Reactivar socursal'>" +
                                        "<i class='fa fa-sync-alt'></i></a>"
                                }
                                return "<a id='btn_editar_socursal' class='btn btn-outline-primary btn-sm'" +
                                    " data-toggle='tooltip' data-placement='right' title='Ver o editar datos de la Sucursal'>" +
                                    "<i class='fa fa-edit'></i></a>" + " " + text;
                            }
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
                } else if (data.response_code == "500") {
                    // infoAlert('Error', data.response_text);
                }
            },
            error: function (xhr) {
                infoAlert('Error Fatal', 'Se produjo un error desconocido');
            }
        });
    }

    function cargar_estados_sepomex() {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_estados',
            type: 'post',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    var estado = data.response.estado;
                    var select_2 = $('#estado_socursal');
                    select_2.append('<option value="">Seleccione una opcion</option>');
                    for (var i = 0; i < estado.length; i++) {
                        select_2.append('<option value="' + estado[i] + '">' +
                            estado[i] + '</option>');
                    }
                } else {
                    console.log(data.error_menssage);
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function cargar_municipios_sepomex(estado) {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_municipio_por_estado/' + estado,
            type: 'post',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    $('option', '#municipio_socursal').remove();
                    var municipio = data.response.municipios;
                    var select_2 = $('#municipio_socursal');
                    for (var i = 0; i < municipio.length; i++) {
                        select_2.append('<option value="' + municipio[i] + '">' +
                            municipio[i] + '</option>');
                    }
                } else {
                    console.log(data.error_menssage);
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function cargar_colonias_sepomex(codigo_postal) {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_colonia_por_cp/' + codigo_postal,
            type: 'get',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    $('option', '#colonia_socursal').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_socursal');
                    for (var i = 0; i < colonia.length; i++) {
                        select_2.append('<option value="' + colonia[i] + '">' +
                            colonia[i] + '</option>');
                    }
                } else {
                    $('option', '#colonia_socursal').remove();
                    var mensaje = "Verrifica";
                    var texto = data.error_message;
                    infoAlert(mensaje, texto)
                }
            },
            error: function (data) {
                var mensaje = "Verrifica";
                var texto = data.responseJSON.error_message;
                infoAlert(mensaje, texto);

            }
        });
    }

    function cargar_colonias_sepomex_editar(codigo_postal) {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_colonia_por_cp/' + codigo_postal,
            type: 'get',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    $('option', '#colonia_socursal_editar').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_socursal_editar');
                    for (var i = 0; i < colonia.length; i++) {
                        select_2.append('<option value="' + colonia[i] + '">' +
                            colonia[i] + '</option>');
                    }
                } else {
                    $('option', '#colonia_socursal').remove();
                    var mensaje = "Verrifica";
                    var texto = data.error_message;
                    infoAlert(mensaje, texto)
                }
            },
            error: function (data) {
                var mensaje = "Verrifica";
                var texto = data.responseJSON.error_message;
                infoAlert(mensaje, texto);
            }
        });
    }

    function municipios_sepomex_edit(estado, municipio_1) {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_municipio_por_estado/' + estado,
            type: 'post',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    $('option', '#municipio_socursal_editar').remove();
                    var municipio = data.response.municipios;
                    var select_2 = $('#municipio_socursal_editar');
                    for (var i = 0; i < municipio.length; i++) {
                        select_2.append('<option value="' + municipio[i] + '">' + municipio[i] + '</option>');
                    }
                    $("#municipio_socursal_editar option[value='" + municipio_1 + "']").prop("selected", "selected");
                } else {
                    console.log(data.error_menssage);
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function colonias_sepomex_edit(codigo_postal, colonia_1) {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_colonia_por_cp/' + codigo_postal,
            type: 'get',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    $('option', '#colonia_socursal_editar').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_socursal_editar');
                    for (var i = 0; i < colonia.length; i++) {
                        select_2.append('<option value="' + colonia[i] + '">' +
                            colonia[i] + '</option>');
                    }
                    $("#colonia_socursal_editar option[value='" + colonia_1 + "']").prop("selected", "selected");
                } else {
                    $('option', '#colonia_socursal').remove();
                    var mensaje = "Verrifica";
                    var texto = data.error_message;
                    infoAlert(mensaje, texto)
                }
            },
            error: function (data) {
                var mensaje = "Verrifica";
                var texto = data.responseJSON.error_message;
                infoAlert(mensaje, texto);

            }
        });
    }

    function limpiar_inputs() {
        $('#nombre_socursal').val('')
        $('#codigo_postal').val('')
        $('#calle_socursal').val('')
        $('#no_exterior').val('')
        $('#no_interior').val('')
        $('option', '#municipio_socursal').remove();
        $('option', '#colonia_socursal').remove();
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