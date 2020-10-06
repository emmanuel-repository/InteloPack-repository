$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var image_code_bar_base_64 = "";
    var image_base_64_logo = "";
    var imagen_logo = 'http://127.0.0.1:8000/static/imagenes_intelo/intelo_logo_modificado.png'

    toDataURL(imagen_logo, function (dataUrl) { image_base_64_logo = dataUrl });
    cargar_estados_sepomex();
    cargar_estados_sepomex_cliente();

    $('#razon_social_cliente').select2({ theme: 'bootstrap4' });
    $('#estado_destino').select2({ theme: 'bootstrap4' });
    $('#municipio_destino').select2({ theme: 'bootstrap4' });
    $('#colonia_destino').select2({ theme: 'bootstrap4' });
    $('#estado_cliente').select2({ theme: 'bootstrap4' });
    $('#municipio_cliente').select2({ theme: 'bootstrap4' });
    $('#colonia_cliente').select2({ theme: 'bootstrap4' });

    $('#form_validate_paquete_agregar').validate({
        rules: {
            nombre: {
                required: true,
            },
            apellido_1: {
                required: true
            },
            apellido_2: {
                required: true
            },
            razon_social: {
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
            codigo_postal: {
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
            correo_cliente: {
                required: true
            },
            telefono_1_cliente: {
                required: true
            },
            estado_destino: {
                required: true
            },
            municipio_destino: {
                required: true
            },
            codigo_postal_destino: {
                required: true
            },
            colonia_destino: {
                required: true
            },
            calle_destino: {
                required: true
            },
            no_exterior_destino: {
                required: true
            },
            nombre_sucursal_salida: {
                required: true
            },
            no_sucursal_salida: {
                required: true
            },
            estado_sucursal_salida: {
                required: true
            },
            municipio_sucursal_salida: {
                required: true
            },
            codigo_postal_sucursal_salida: {
                required: true
            },
            colonia_sucursal_salida: {
                required: true
            },
            calle_sucursal_salida: {
                required: true
            },
            no_exterior_sucursal_salida: {
                required: true
            },
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
            Swal.fire({
                title: '¿Esta seguro?',
                text: "¡Ya verifico los datos antes de dar Si!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    if ($('#checkbox_cliente_frecuente').is(":checked")) {
                        agregar_paquete();
                    } else {
                        agregar_paquete_eventual()
                    }
                }
            });
        }
    });

    $("#checkbox_cliente_frecuente").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $('#checkbox_cliente_frecuente').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            add_input_direccion()
            add_disabled();
            limpiar_input()
        } else {
            add_select_direccion()
            remove_disabled();
            limpiar_input()
        }
    });

    $(document).on('change', '#razon_social_cliente', function () {
        var id_cliente = $(this).val();
        if (id_cliente != "") {
            obtener_cliente(id_cliente)
        } else {
            var mensaje = "Verifica"
            var text = "Favor de seleccionar la razon social del Cliente"
            infoAlert(mensaje, text)
        }

    });

    $(document).on('change', '#estado_destino', function () {
        var estado = $(this).val();
        cargar_municipios_sepomex(estado)
    });

    $(document).on('blur', '#codigo_postal_destino', function () {
        var codigo_postal = $(this).val();
        cargar_colonias_sepomex(codigo_postal);
    });

    $(document).on('change', '#estado_cliente', function () {
        var estado = $(this).val();
        cargar_municipios_sepomex_cliente(estado);
    });

    $(document).on('blur', '#codigo_postal', function () {
        var codigo_postal = $(this).val();
        cargar_colonias_sepomex_cliente(codigo_postal);
    });

    $(document).on('click', '#btn_imprimir_bar_code', function () {
        var hoy = new Date();
        var fecha_convertida = moment(hoy).format('YYYY-MM-DD h:mm:ss');
        var image = {
            image: image_code_bar_base_64,
            width: 600,
            absolutePosition: { x: 100, y: 200 },
            pageOrientation: 'landscape',
        }
        var docDefinition = {
            pageSize: 'LETTER',
            pageOrientation: 'landscape',
            pageMargins: [40, 60, 40, 60],
            content: [image],
            header: function (currentPage, pageCount, pageSize) {
                return [
                    { image: image_base_64_logo, width: 190, height: 85, margin: 10 },
                    {
                        text: 'InteloPack, Sistema de gestión de Paqueteria',
                        absolutePosition: { x: 190, y: 28 },
                        fontSize: 26,
                        margin: 20
                    },
                ]
            },
            footer: function (page, currentPage, pageCount) {
                return {
                    style: 'footer',
                    table: {
                        widths: ['*', 100],
                        body: [
                            [{
                                text: 'Fecha de creacion: ' + fecha_convertida,
                                alignment: 'center'
                            }]
                        ]
                    },
                    layout: 'noBorders',
                    margin: [5, 0]
                };

            },
        };
        $("#modal_bar_code").modal("hide");
        pdfMake.createPdf(docDefinition).print();
    });

    function agregar_paquete() {
        var nombre = $('#nombre').val();
        var apellido_1 = $('#apellido_1').val();
        var apellido_2 = $('#apellido_2').val();
        var correo = $('#correo_cliente').val();
        var formElement = document.getElementById("form_validate_paquete_agregar");
        var form = new FormData(formElement);
        var hoy = new Date();
        form.append("fecha", moment(hoy).format('YYYY-MM-DD'));
        form.append("hora", moment(hoy).format('h:mm:ss a'));
        $.ajax({
            url: '/empleado/paquete',
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
                    localStorage.setItem('correo', correo);
                    localStorage.setItem('nombre_completo', nombre + ' ' 
                        + apellido_1 + ' ' + apellido_2);
                    var id_paquete = data.response_data;
                    generar_codigo_barrar(id_paquete);
                    limpiar_input_destino();
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

    function agregar_paquete_eventual() {
        var nombre = $('#nombre').val();
        var apellido_1 = $('#apellido_1').val();
        var apellido_2 = $('#apellido_2').val();
        var correo = $('#correo_cliente').val();
        var formElement = document.getElementById("form_validate_paquete_agregar");
        var form = new FormData(formElement);
        var hoy = new Date();
        form.append("fecha", moment(hoy).format('YYYY-MM-DD'));
        form.append("hora", moment(hoy).format('h:mm:ss a'));
        $.ajax({
            url: '/empleado/paquete/create_eventual',
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
                    var id_paquete = data.response_data;
                    localStorage.setItem('correo', correo);
                    localStorage.setItem('nombre_completo', nombre + ' ' 
                        + apellido_1 + ' ' + apellido_2);
                    generar_codigo_barrar(id_paquete);
                    limpiar_input();
                    limpiar_input_destino();
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

    function obtener_cliente(id_cliente) {
        $.ajax({
            url: '/empleado/paquete/' + id_cliente,
            type: 'get',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.response_code == 200) {
                    data = data.response_data;
                    $('#nombre').val(data.nombre_cliente);
                    $('#apellido_1').val(data.apellido_1_cliente);
                    $('#apellido_2').val(data.apellido_2_cliente);
                    $('#razon_social').val(data.razon_social_cliente);
                    $('#rfc_cliente').val(data.rfc_cliente);
                    $('#estado_cliente').val(data.estado_cliente);
                    $('#municipio_cliente').val(data.municipio_cliente);
                    $('#codigo_postal').val(data.codigo_postal_cliente);
                    $('#colonia_cliente').val(data.colonia_cliente);
                    $('#calle_cliente').val(data.calle_cliente);
                    $('#no_exterior_cliente').val(data.no_exterior_cliente);
                    $('#no_interior_cliente').val(data.no_interior_cliente);
                    $('#correo_cliente').val(data.email_cliente);
                    $('#telefono_1_cliente').val(data.telefono_1_cliente);
                    $('#telefono_2_cliente').val(data.telefono_2_cliente);
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

    function editar(id_paquete, numero_codigo_barra) {
        var nombre_completo = localStorage.getItem('nombre_completo');
        var correo = localStorage.getItem('correo');
        $.ajax({
            url: '/empleado/paquete/' + id_paquete,
            type: 'put',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                correo: correo,
                numero_codigo_barra: numero_codigo_barra,
                nombre_completo: nombre_completo
            },
            success: function (data) {
                if (data.response_code == 200) {
                    console.log("se realizo el insert de numero de paquete");
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

    function generar_codigo_barrar(id_paquete) {
        var hoy = new Date();
        var fecha_convertida = moment(hoy).format('YYYYMMDDhmmss');
        var numero_codigo_barra = fecha_convertida + id_paquete
        var options = {
            text: '' + numero_codigo_barra,
            bcid: 'code128', // Barcode type
            scale: 4, // 3x scaling factor
            height: 8, // Bar height, in millimeters
            includetext: true, // Show human-readable text
            textxalign: 'center', // Always good to set this
        }
        bwipjs.toCanvas('#canvas_bar_code', options);
        canvas = document.getElementById('canvas_bar_code');
        dataURL = canvas.toDataURL();
        image_code_bar_base_64 = dataURL;
        $('#modal_bar_code').modal({ backdrop: 'static', keyboard: false });
        $("#modal_bar_code").modal("show");
        editar(id_paquete, numero_codigo_barra);
    }

    function toDataURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            var reader = new FileReader();
            reader.onloadend = function () {
                callback(reader.result);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }

    function cargar_estados_sepomex() {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_estados',
            type: 'post',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    var estado = data.response.estado;
                    var select_2 = $('#estado_destino');
                    select_2.append('<option value="">Seleccione una opción</option>');
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
                    $('option', '#municipio_destino').remove();
                    var municipio = data.response.municipios;
                    var select_2 = $('#municipio_destino');
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
                    $('option', '#colonia_destino').remove();
                    var colonia = data.response.colonia;
                    var select_2 = $('#colonia_destino');
                    for (var i = 0; i < colonia.length; i++) {
                        select_2.append('<option value="' + colonia[i] + '">' +
                            colonia[i] + '</option>');
                    }
                } else {
                    $('option', '#colonia_destino').remove();
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

    function cargar_estados_sepomex_cliente() {
        $.ajax({
            url: 'https://api-sepomex.hckdrk.mx/query/get_estados',
            type: 'post',
            dataType: "json",
            success: function (data) {
                if (!data.error) {
                    var estado = data.response.estado;
                    var select_2 = $('#estado_cliente');
                    select_2.append('<option>Seleccione una opción</option>');
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

    function cargar_municipios_sepomex_cliente(estado) {
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

    function cargar_colonias_sepomex_cliente(codigo_postal) {
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
                    $('option', '#colonia_cliente').remove();
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

    function remove_disabled() {
        $('#form_select_cliente').fadeOut('slow');
        $('#nombre').removeAttr('readonly');
        $('#apellido_1').removeAttr('readonly');
        $('#apellido_2').removeAttr('readonly');
        $('#razon_social').removeAttr('readonly');
        $('#rfc_cliente').removeAttr('readonly');
        $('#codigo_postal').removeAttr('readonly');
        $('#calle_cliente').removeAttr('readonly');
        $('#no_exterior_cliente').removeAttr('readonly');
        $('#no_interior_cliente').removeAttr('readonly');
        $('#correo_cliente').removeAttr('readonly');
        $('#telefono_1_cliente').removeAttr('readonly');
        $('#telefono_2_cliente').removeAttr('readonly');
    }

    function add_disabled() {
        $('#form_select_cliente').removeClass('d-none');
        $('#form_select_cliente').fadeIn('slow');
        $('#nombre').attr('readonly', 'readonly');
        $('#apellido_1').attr('readonly', 'readonly');
        $('#apellido_2').attr('readonly', 'readonly');
        $('#razon_social').attr('readonly', 'readonly');
        $('#rfc_cliente').attr('readonly', 'readonly');
        $('#estado_cliente').attr('readonly', 'readonly');
        $('#municipio_cliente').attr('readonly', 'readonly');
        $('#codigo_postal').attr('readonly', 'readonly');
        $('#colonia_cliente').attr('readonly', 'readonly');
        $('#calle_cliente').attr('readonly', 'readonly');
        $('#no_exterior_cliente').attr('readonly', 'readonly');
        $('#no_interior_cliente').attr('readonly', 'readonly');
        $('#correo_cliente').attr('readonly', 'readonly');
        $('#telefono_1_cliente').attr('readonly', 'readonly');
        $('#telefono_2_cliente').attr('readonly', 'readonly');
    }

    function add_select_direccion() {
        $('#select_estado_cliente').empty();
        $('#select_municipio_cliente').empty();
        $('#select_colonia_cliente').empty();
        $('#select_estado_cliente').append('<select class="form-control select2"' +
            'id="estado_cliente" name="estado_cliente">' +
            '</select>');
        $('#select_municipio_cliente').append(' <select class="form-control select2" ' +
            'id="municipio_cliente" name="municipio_cliente">' +
            '</select>');
        $('#select_colonia_cliente').append('<select class="form-control select2" ' +
            ' id="colonia_cliente" name="colonia_cliente">' +
            '</select>');
        cargar_estados_sepomex_cliente();
        $('#estado_cliente').select2({ theme: 'bootstrap4' });
        $('#municipio_cliente').select2({ theme: 'bootstrap4' });
        $('#colonia_cliente').select2({ theme: 'bootstrap4' });
    }

    function add_input_direccion() {
        $('#select_estado_cliente').empty();
        $('#select_municipio_cliente').empty();
        $('#select_colonia_cliente').empty();
        $('#select_estado_cliente').append('<input type="text" class="form-control"' +
            'id="estado_cliente" name="estado_cliente"' +
            'onKeyUp="document.getElementById(this.id).value =' +
            ' document.getElementById(this.id).value.toUpperCase()"' +
            'maxlength="50" >');
        $('#select_municipio_cliente').append('<input type="text" class="form-control"' +
            'id="municipio_cliente" name="municipio_cliente"' +
            'onKeyUp="document.getElementById(this.id).value =' +
            ' document.getElementById(this.id).value.toUpperCase()"' +
            'maxlength="50">');
        $('#select_colonia_cliente').append('<input type="text" class="form-control"' +
            'id="colonia_cliente" name="colonia_cliente"' +
            'onKeyUp="document.getElementById(this.id).value =' +
            ' document.getElementById(this.id).value.toUpperCase()"' +
            'maxlength="100"> ');
    }

    function limpiar_input() {
        $('#nombre').val('');
        $('#apellido_1').val('');
        $('#apellido_2').val('');
        $('#razon_social').val('');
        $('#rfc_cliente').val('');
        $('#estado_cliente').val('');
        $('#municipio_cliente').val('');
        $('#codigo_postal').val('');
        $('#colonia_cliente').val('');
        $('#calle_cliente').val('');
        $('#no_exterior_cliente').val('');
        $('#no_interior_cliente').val('');
        $('#correo_cliente').val('');
        $('#telefono_1_cliente').val('');
        $('#telefono_2_cliente').val('');
    }

    function limpiar_input_destino() {
        $('option', '#municipio_destino').remove();
        $('option', '#colonia_destino').remove();
        $('#codigo_postal_destino').val('');
        $('#calle_destino').val('');
        $('#no_exterior_destino').val('');
        $('#no_interior_interior').val('');
    }

    function infoAlert(mensaje, text) {
        Swal.fire(
            mensaje, text, 'question'
        )
    }
})