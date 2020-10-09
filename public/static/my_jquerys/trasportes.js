$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    cargar_tabla();

    $('#data_table_transportes').DataTable();
    $('#sucursal').select2({ theme: 'bootstrap4' });
    $('#tipo_transporte').select2({ theme: 'bootstrap4' });
    $('#sucursal_editar').select2({ theme: 'bootstrap4' });
    $('#tipo_transporte_editar').select2({ theme: 'bootstrap4' });

    var form_validate_agregar = $('#form_validate_transporte').validate({
        rules: {
            matricula_transporte: {
                required: true,
            },
            sucursal: {
                required: true
            },
            tipo_transporte: {
                required: true
            },
            no_economico_transporte: {
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
            agregar();
        }
    });

    $('#form_validate_editar_transporte').validate({
        rules: {
            matricula_transporte_editar: {
                required: true,
            },
            sucursal_editar: {
                required: true
            },
            tipo_transporte_editar: {
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

    $(document).on('click', '.btn_cancelar', function () {
        limpiar_inputs();
    });

    $(document).on('click', '#btn_open_modal_transporte', function () {
        $('#modal_agregar_transporte').modal({ backdrop: 'static', keyboard: false });
        $("#modal_agregar_transporte").modal("show");
    });

    $(document).on('click', '#btn_editar_transporte', function () {
        var tabla = $("#data_table_transportes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        $('#id_transporte_editar').val(data.id);
        $('#matricula_transporte_editar').val(data.matricula_transporte);
        $('#no_economico_transporte_editar').val(data.no_economico_transporte);
        $("#sucursal_editar option[value='" + data.socursal_id + "']").prop("selected", "selected");
        $("#tipo_transporte_editar option[value='" + data.tipo_transporte_id + "']").prop("selected", "selected");
        $('#sucursal_editar').select2({ theme: 'bootstrap4' });
        $('#tipo_transporte_editar').select2({ theme: 'bootstrap4' });
        $('#modal_editar_transporte').modal({ backdrop: 'static', keyboard: false });
        $("#modal_editar_transporte").modal("show");
    });

    $(document).on('click', '#btn_desactivar_transporte', function () {
        var tabla = $("#data_table_transportes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_transporte = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Desactivar este periodo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, desactivar periodo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/empleado/transportes/" + id_transporte,
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

    $(document).on('click', '#btn_activar_transporte', function () {
        var tabla = $("#data_table_transportes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_socursal = data.id;
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
                    url: "/empleado/transportes/" + id_socursal + "/edit",
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
        var formElement = document.getElementById("form_validate_transporte");
        var form = new FormData(formElement);
        $.ajax({
            url: '/empleado/transportes',
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
        var formElement = document.getElementById("form_validate_editar_transporte");
        var form = new FormData(formElement);
        var id_transporte = $('#id_transporte_editar').val();
        $.ajax({
            url: '/empleado/transportes/' + id_transporte,
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
                    $("#modal_editar_transporte").modal("hide");
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
            url: "/empleado/transportes/create",
            method: "get",
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
            },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#data_table_transportes').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "data": data.response_data,
                        "columns": [{
                            'data': "no_transporte"
                        },
                        {
                            'data': 'matricula_transporte',
                        },
                        {
                            'data': 'nombre_socursal',
                        },
                        {
                            'data': 'descripcion_tipo_transporte',
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                var text = null;
                                if (data.estatus_transporte == '1') {
                                    text = "<h6 class='text-success'>Activo</h6> "
                                } else if (data.estatus_transporte == '0') {
                                    text = "<h6 class='text-danger'>Desactivado</h6> "
                                }
                                return text;
                            }
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                var text = null;
                                if (data.estatus_transporte == '1') {
                                    text = "<a id='btn_desactivar_transporte' class='btn btn-outline-danger btn-sm'" +
                                        " data-toggle='tooltip' data-placement='right' title='Desactivar transporte'>" +
                                        "<i class='fa fa-trash'></i></a>"
                                } else if (data.estatus_transporte == '0') {
                                    text = "<a id='btn_activar_transporte' class='btn btn-outline-success btn-sm'" +
                                        " data-toggle='tooltip' data-placement='right' title='Reactivar transporte'>" +
                                        "<i class='fa fa-sync-alt'></i></a>"
                                }
                                return "<a id='btn_editar_transporte' class='btn btn-outline-primary btn-sm'" +
                                    " data-toggle='tooltip' data-placement='right' title='Ver o editar datos de la transporte'>" +
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

    function limpiar_inputs() {
        $('#matricula_transporte').val('');
        $('#no_economico_transporte').val('');
        $("#sucursal option[value='']").prop("selected", "selected");
        $("#tipo_transporte option[value='']").prop("selected", "selected");
        $('#sucursal').select2({ theme: 'bootstrap4' });
        $('#tipo_transporte').select2({ theme: 'bootstrap4' });
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