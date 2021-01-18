$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    cargar_tabla();
    
    $('#data_table_empleados').DataTable();
    $('#tipo_empleado').select2({ theme: 'bootstrap4' });
    $('#sucursal').select2({ theme: 'bootstrap4' });
    $('#sucursal_editar').select2({ theme: 'bootstrap4' });
    $('#tipo_empleado_editar').select2({ theme: 'bootstrap4' });

    var form_validate_agregar = $('#form_validate_empleado_agregar').validate({
        rules: {
            nombre_empleado: {
                required: true,
            },
            apellido1_empleado: {
                required: true
            },
            apellido2_empleado: {
                required: true
            },
            email: {
                required: true
            },
            password_empleado: {
                required: true
            },
            tipo_empleado: {
                required: true
            },
            sucursal: {
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

    $('#form_validate_empleado_editar').validate({
        rules: {
            nombre_empleado_editar: {
                required: true,
            },
            apellido1_empleado_editar: {
                required: true
            },
            apellido2_empleado_editar: {
                required: true
            },
            email_editar: {
                required: true
            },
            tipo_empleado_editar: {
                required: true
            },
            sucursal_editar: {
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

    $(document).on('click', '#btn_open_modal_empleado', function () {
        $('#modal_agregar_empleado').modal({ backdrop: 'static', keyboard: false });
        $("#modal_agregar_empleado").modal("show");
    });

    $(document).on('click', '#show-password', function () {
		password1 = document.querySelector('.password1');
		if (password1.type === "password") {
			password1.type = "text";
			$('#eye').removeClass('fa-eye'); 
			$('#eye').addClass('fa-eye-slash'); 
		} else {
			password1.type = "password";
			$('#eye').removeClass('fa-eye-slash'); 
			$('#eye').addClass('fa-eye'); 
		}
    });
    
    $(document).on('click', '#show-password_edit', function () {
		password1 = document.querySelector('.password2');
		if (password1.type === "password") {
			password1.type = "text";
			$('#eye_edit').removeClass('fa-eye'); 
			$('#eye_edit').addClass('fa-eye-slash'); 
		} else {
			password1.type = "password";
			$('#eye_edit').removeClass('fa-eye-slash'); 
			$('#eye_edit').addClass('fa-eye'); 
		}
	});

    $(document).on('click', '#btn_editar_empleado', function () {
        var tabla = $("#data_table_empleados").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        $('#id_empleado_editar').val(data.id);
        $('#nombre_empleado_editar').val(data.nombre_empleado);
        $('#apellido1_empleado_editar').val(data.apellido_1_empleado);
        $('#apellido2_empleado_editar').val(data.apellido_2_empleado);
        $('#email_empleado_editar').val(data.email);
        $("#sucursal_editar option[value='" + data.socursal_id + "']").prop("selected", "selected");
        $("#tipo_empleado_editar option[value='" + data.tipo_empleado_id + "']").prop("selected", "selected");
        $('#sucursal_editar').select2({ theme: 'bootstrap4' });
        $('#tipo_empleado_editar').select2({ theme: 'bootstrap4' });
        $('#modal_editar_empleado').modal({ backdrop: 'static', keyboard: false });
        $("#modal_editar_empleado").modal("show");
    });

    $(document).on('click', '#btn_desactivar_empleado', function () {
        var tabla = $("#data_table_empleados").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_empleado = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Desactivar este Empleado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, desactivar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/empleado/gestion_empleados/" + id_empleado,
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
        });
    });

    $(document).on('click', '#btn_activar_empleado', function () {
        var tabla = $("#data_table_empleados").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var id_empleado = data.id;
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Activar esta Empleado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, activar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/empleado/gestion_empleados/" + id_empleado + "/edit",
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
                });
            }
        });
    });

    function agregar() {
        var formElement = document.getElementById("form_validate_empleado_agregar");
        var form = new FormData(formElement);
        $.ajax({
            url: '/empleado/gestion_empleados',
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
        var formElement = document.getElementById("form_validate_empleado_editar");
        var form = new FormData(formElement);
        var id_empleado = $('#id_empleado_editar').val();
        $.ajax({
            url: '/empleado/gestion_empleados/' + id_empleado,
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
                    $("#modal_editar_empleado").modal("hide");
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
            url: "/empleado/gestion_empleados/create",
            method: "get",
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
            },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#data_table_empleados').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "data": data.response_data,
                        "columns": [
                            {
                                'data': null,
                                'render': function (data, type, row, meta) {
                                    return data.nombre_empleado + " " + data.apellido_1_empleado
                                        + " " + data.apellido_2_empleado;
                                }
                            },
                            {
                                'data': 'email',
                            },
                            {
                                'data': 'nombre_socursal',
                            },
                            {
                                'data': 'descripcion_tipo_empleado',
                            },
                            {
                                'data': null,
                                'render': function (data, type, row, meta) {
                                    var text = null;
                                    if (data.estatus_empleado == '1') {
                                        text = "<h6 class='text-success'>Activo</h6> "
                                    } else if (data.estatus_empleado == '0') {
                                        text = "<h6 class='text-danger'>Desactivado</h6> "
                                    }
                                    return text;
                                }
                            },
                            {
                                'data': null,
                                'render': function (data, type, row, meta) {
                                    var text = null;
                                    if (data.estatus_empleado == '1') {
                                        text = "<a id='btn_desactivar_empleado' class='btn btn-outline-danger btn-sm'" +
                                            " data-toggle='tooltip' data-placement='right' title='Desactivar empleado'>" +
                                            "<i class='fa fa-trash'></i></a>"
                                    } else if (data.estatus_empleado == '0') {
                                        text = "<a id='btn_activar_empleado' class='btn btn-outline-success btn-sm'" +
                                            " data-toggle='tooltip' data-placement='right' title='Reactivar empleado'>" +
                                            "<i class='fa fa-sync-alt'></i></a>"
                                    }
                                    return "<a id='btn_editar_empleado' class='btn btn-outline-primary btn-sm'" +
                                        " data-toggle='tooltip' data-placement='right' title='Ver o editar datos de la empleado'>" +
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
        $('#nombre_empleado').val('');
        $('#apellido1_empleado').val('');
        $('#apellido2_empleado').val('');
        $('#email').val('');
        $('#password_empleado').val('');
        $("#sucursal option[value='']").prop("selected", "selected");
        $("#tipo_empleado option[value='']").prop("selected", "selected");
        $('#sucursal').select2({ theme: 'bootstrap4' });
        $('#tipo_empleado').select2({ theme: 'bootstrap4' });
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
