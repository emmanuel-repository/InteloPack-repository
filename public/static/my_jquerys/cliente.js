$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    cargar_tabla();
    cargar_estados_sepomex();

    $('#data_table_clientes').DataTable();
    $('#estado_cliente').select2({ theme: 'bootstrap4' });
    $('#colonia_cliente').select2({ theme: 'bootstrap4' });
    $('#municipio_cliente').select2({ theme: 'bootstrap4' });
    $('#colonia_cliente_editar').select2({ theme: 'bootstrap4' });
    $('#municipio_cliente_editar').select2({ theme: 'bootstrap4' });

    var form_validate_agregar = $('#form_validate_cliente_agregar').validate({
        rules: {
            nombre_cliente: {
                required: true,
            },
            apellido1_cliente: {
                required: true
            },
            apellido2_cliente: {
                required: true
            },
            razon_social_cliente: {
                required: true
            },
            rfc_cliente: {
                required: true
            },
            estado_cliente: {
                required: true
            },
            municipio_cliente: {
                required: true
            },
            codigo_postal_cliente: {
                required: true
            },
            colonia_cliente: {
                required: true
            },
            calle_cliente: {
                required: true
            },
            no_exterior_cliente: {
                required: true
            },
            email_cliente: {
                required: true
            },
            telefono1_cliente: {
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

    $('#form_validate_cliente_editar').validate({
        rules: {
            nombre_cliente_editar: {
                required: true,
            },
            apellido1_cliente_editar: {
                required: true
            },
            apellido2_cliente_editar: {
                required: true
            },
            razon_social_cliente_editar: {
                required: true
            },
            rfc_cliente_editar: {
                required: true
            },
            estado_cliente_editar: {
                required: true
            },
            municipio_cliente_editar: {
                required: true
            },
            codigo_postal_cliente_editar: {
                required: true
            },
            colonia_cliente_editar: {
                required: true
            },
            calle_cliente_editar: {
                required: true
            },
            no_exterior_cliente_editar: {
                required: true
            },
            email_cliente_editar: {
                required: true
            },
            telefono1_cliente_editar: {
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

    $(document).on('click', '#btn_open_modal_cliente', function () {
        $('#modal_agregar_cliente').modal({ backdrop: 'static', keyboard: false });
        $("#modal_agregar_cliente").modal("show");
    });

    $(document).on('click', '#btn_editar_cliente', function () {
        var tabla = $("#data_table_clientes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var estado = data.estado_cliente;
        var municipio = data.municipio_cliente;
        var codigo_postal = data.codigo_postal_cliente;
        var colonia = data.colonia_cliente;
        $('#id_cliente_editar').val(data.id);
        $('#nombre_cliente_editar').val(data.nombre_cliente);
        $('#apellido1_cliente_editar').val(data.apellido_1_cliente);
        $('#apellido2_cliente_editar').val(data.apellido_2_cliente);
        $('#razon_social_cliente_editar').val(data.razon_social_cliente);
        $('#rfc_cliente_editar').val(data.rfc_cliente);
        $('#codigo_postal_cliente_editar').val(data.codigo_postal_cliente);
        $('#no_exterior_cliente_editar').val(data.no_exterior_cliente);
        $('#no_interior_cliente_editar').val(data.no_interior_cliente);
        $('#calle_cliente_editar').val(data.calle_cliente);
        $('#email_cliente_editar').val(data.email_cliente);
        $('#telefono1_cliente_editar').val(data.telefono_1_cliente);
        $('#telefono2_cliente_editar').val(data.telefono_2_cliente);
        $('#estado_cliente_editar').val(data.estado_cliente);
        $('option', '#municipio_cliente_editar').remove();
        $('option', '#colonia_cliente_editar').remove();
        municipios_sepomex_edit(estado, municipio);
        colonias_sepomex_edit(codigo_postal, colonia);
        $('#modal_editar_cliente').modal({ backdrop: 'static', keyboard: false });
        $("#modal_editar_cliente").modal("show");
    });

    $(document).on('click', '#btn_desactivar_cliente', function () {
        var tabla = $("#data_table_clientes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_cliente = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Desactivar esta Sucursal!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, desactivar Sucursal!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/empleado/cliente/" + id_cliente,
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

    $(document).on('click', '#btn_activar_cliente', function () {
        var tabla = $("#data_table_clientes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_cliente = data.id;
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
                $.ajax({
                    url: "/empleado/cliente/" + id_cliente + "/edit",
                    type: "get",
                    dataType: "json",
                    data: { _token: CSRF_TOKEN },
                    success: function (data) {
                        if (data.response_code == 200) {
                            cargar_tabla();
                            successAlert(data.response_text);
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

    $(document).on('change', '#estado_cliente', function () {
        var estado = $(this).val();
        cargar_municipios_sepomex(estado)
    });

    $(document).on('blur', '#codigo_postal_cliente', function () {
        var codigo_postal = $(this).val();
        cargar_colonias_sepomex(codigo_postal);
    });

    $(document).on('blur', '#codigo_postal_cliente_editar', function () {
        var codigo_postal = $(this).val();
        cargar_colonias_sepomex_editar(codigo_postal);
    });

    $(document).on('click', '.btn_cancelar', function () {
        limpiar_inputs();
    });


    function cargar_tabla() {
        $.ajax({
            url: "/empleado/cliente/create",
            method: "get",
            dataType: "json",
            data: { _token: CSRF_TOKEN },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#data_table_clientes').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "data": data.response_data,
                        "columns": [
                            {
                                'data': null,
                                'render': function (data, type, row, meta) {
                                    return data.nombre_cliente + " " + data.apellido_1_cliente
                                        + " " + data.apellido_2_cliente;
                                }
                            },
                            {
                                'data': 'razon_social_cliente',
                            },
                            {
                                'data': 'rfc_cliente',
                            },
                            {
                                'data': null,
                                'render': function (data, type, row, meta) {
                                    var text = null;
                                    if (data.estatus_cliente == '1') {
                                        text = "<h6 class='text-success'>Activo</h6> "
                                    } else if (data.estatus_cliente == '0') {
                                        text = "<h6 class='text-danger'>Desactivado</h6> "
                                    }
                                    return text;
                                }
                            },
                            {
                                'data': null,
                                'render': function (data, type, row, meta) {
                                    var text = null;
                                    if (data.estatus_cliente == '1') {
                                        text = "<a id='btn_desactivar_cliente' class='btn btn-outline-danger btn-sm'" +
                                            " data-toggle='tooltip' data-placement='right' title='Desactivar cliente'>" +
                                            "<i class='fa fa-trash'></i></a>"
                                    } else if (data.estatus_cliente == '0') {
                                        text = "<a id='btn_activar_cliente' class='btn btn-outline-success btn-sm'" +
                                            " data-toggle='tooltip' data-placement='right' title='Reactivar cliente'>" +
                                            "<i class='fa fa-sync-alt'></i></a>"
                                    }
                                    return "<a id='btn_editar_cliente' class='btn btn-outline-primary btn-sm'" +
                                        " data-toggle='tooltip' data-placement='right' title='Ver o editar datos de la cliente'>" +
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

    function agregar() {
        var formElement = document.getElementById("form_validate_cliente_agregar");
        var form = new FormData(formElement);
        $.ajax({
            url: '/empleado/cliente',
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
        var formElement = document.getElementById("form_validate_cliente_editar");
        var form = new FormData(formElement);
        var id_cliente = $('#id_cliente_editar').val();
        $.ajax({
            url: '/empleado/cliente/' + id_cliente,
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
                    cargar_tabla();
                    $("#modal_editar_cliente").modal("hide");
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

    function cargar_estados_sepomex() {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_estados',
            type: 'post',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    var estado = data.response.estado;
                    var select_2 = $('#estado_cliente');
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
                    $('option', '#municipio_cliente').remove();
                    var municipio = data.response.municipios;
                    var select_2 = $('#municipio_cliente');
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
                    $('option', '#colonia_cliente').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_cliente');
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
                    $('option', '#municipio_cliente_editar').remove();
                    var municipio = data.response.municipios;
                    var select_2 = $('#municipio_cliente_editar');
                    for (var i = 0; i < municipio.length; i++) {
                        select_2.append('<option value="' + municipio[i] + '">' + municipio[i] + '</option>');
                    }
                    $("#municipio_cliente_editar option[value='" + municipio_1 + "']").prop("selected", "selected");
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
                    $('option', '#colonia_cliente_editar').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_cliente_editar');
                    for (var i = 0; i < colonia.length; i++) {
                        select_2.append('<option value="' + colonia[i] + '">' +
                            colonia[i] + '</option>');
                    }
                    $("#colonia_cliente_editar option[value='" + colonia_1 + "']").prop("selected", "selected");
                } else {
                    $('option', '#colonia_cliente_cliente').remove();
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
                    $('option', '#colonia_cliente_editar').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_cliente_editar');
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

    function limpiar_inputs() {
        $('#nombre_cliente').val('');
        $('#apellido1_cliente').val('');
        $('#apellido2_cliente').val('');
        $('#razon_social_cliente').val('');
        $('#rfc_cliente').val('');
        $('#codigo_postal_cliente').val('');
        $('#calle_cliente').val('');
        $('#no_exterior_cliente').val('');
        $('#no_interior_cliente').val('');
        $('#email_cliente').val('');
        $('#telefono1_cliente').val('');
        $('#telefono2_cliente').val('');
        $('option', '#municipio_cliente').remove();
        $('option', '#colonia_cliente').remove();
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
