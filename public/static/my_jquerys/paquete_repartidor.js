$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var wizard = $("#wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "none",
        titleTemplate: '#title#',
        enablePagination: false
    });
    var resultCollector = Quagga.ResultCollector.create({
        capture: true,
        capacity: 20,
        blacklist: [{
            code: "WIWV8ETQZ1", format: "code_93"
        }, {
            code: "EH3C-%GU23RK3", format: "code_93"
        }, {
            code: "O308SIHQOXN5SA/PJ", format: "code_93"
        }, {
            code: "DG7Q$TV8JQ/EN", format: "code_93"
        }, {
            code: "VOFD1DB5A.1F6QU", format: "code_93"
        }, {
            code: "4SO64P4X8 U4YUU1T-", format: "code_93"
        }],
        filter: function (codeResult) {
            return true;
        }
    });
    var App = {
        init: function () {
            var self = this;
            Quagga.init(this.state, function (err) {
                if (err) {
                    return self.handleError(err);
                }
                Quagga.registerResultCollector(resultCollector);
                Quagga.start();
            });
        },
        handleError: function (err) {
            console.log(err);
        },
        inputMapper: {
            inputStream: {
                constraints: function (value) {
                    if (/^(\d+)x(\d+)$/.test(value)) {
                        var values = value.split('x');
                        return {
                            width: { min: parseInt(values[0]) },
                            height: { min: parseInt(values[1]) }
                        };
                    }
                    return {
                        deviceId: value
                    };
                }
            },
            numOfWorkers: function (value) {
                return parseInt(value);
            },
            decoder: {
                readers: function (value) {
                    if (value === 'ean_extended') {
                        return [{
                            format: "ean_reader",
                            config: {
                                supplements: [
                                    'ean_5_reader', 'ean_2_reader'
                                ]
                            }
                        }];
                    }
                    return [{
                        format: value + "_reader",
                        config: {}
                    }];
                }
            }
        },
        state: {
            inputStream: {
                type: "LiveStream",
                constraints: {
                    width: { min: 200 },
                    height: { min: 380 },
                    facingMode: "environment",
                    aspectRatio: { min: 1, max: 2 }
                }
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: 2,
            frequency: 10,
            decoder: {
                readers: [{
                    format: "code_128_reader",
                    config: {}
                }]
            },
            locate: true
        },
        lastResult: null
    };

    cargar_estados_sepomex();
    cargar_estados_sepomex_cliente();

    $('#razon_social_cliente').select2({ theme: 'bootstrap4' });
    $('#estado_destino').select2({ theme: 'bootstrap4' });
    $('#municipio_destino').select2({ theme: 'bootstrap4' });
    $('#colonia_destino').select2({ theme: 'bootstrap4' });
    $('#estado_cliente').select2({ theme: 'bootstrap4' });
    $('#municipio_cliente').select2({ theme: 'bootstrap4' });
    $('#colonia_cliente').select2({ theme: 'bootstrap4' });
    $("#checkbox_cliente_frecuente").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $('#form_validate_escaner').validate({
        rules: {
            bar_code_escaner: {
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
            validar_paquete();
        }
    });

    $('#form_validate_cliente').validate({
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
            wizard.steps('next');
        }
    });

    $('#form_validate_salida').validate({
        rules: {
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
            wizard.steps('next');
        }
    });

    $('#form_validate_destino').validate({
        rules: {
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
                        update_cliente_registrado();
                    } else {
                        update_cliente_enventuel();
                    }
                }
            });
        }
    });

    $(document).on('click', '.btn_previo', function () {
        wizard.steps('previous')
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

    App.init();

    Quagga.onProcessed(function (result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
            drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")),
                    parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 },
                        drawingCtx, { color: "green", lineWidth: 2 });
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 },
                    drawingCtx, { color: "#00F", lineWidth: 2 });
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' },
                    drawingCtx, { color: 'red', lineWidth: 3 });
            }
        }
    });

    Quagga.onDetected(function (result) {
        var code = result.codeResult.code;
        if (App.lastResult !== code) {
            App.lastResult = code;
            console.log(code);
            $('#bar_code_escaner').val(code);
        }
    });

    function update_cliente_registrado() {
        var hoy = new Date();
        var fecha = moment(hoy).format('YYYY-MM-DD');
        var hora = moment(hoy).format('h:mm:ss a');
        var nombre = $('#nombre').val();
        var apellido_1 = $('#apellido_1').val();
        var apellido_2 = $('#apellido_2').val();
        var correo = $('#correo_cliente').val();
        var bar_code = $('#bar_code_escaner').val();
        var razon_social = $('#razon_social').val();
        var estado_destino = $('#estado_destino').val();
        var municipio_destino = $('#municipio_destino').val();
        var codigo_postal_destino = $('#codigo_postal_destino').val();
        var colonia_destino = $('#colonia_destino').val();
        var calle_destino = $('#calle_destino').val();
        var no_exterior_destino = $('#no_exterior_destino').val();
        var no_interior_destino = $('#no_interior_interior').val();
        alertLoader();
        $.ajax({
            url: '/empleado/paquete_repartidor/' + bar_code,
            type: 'put',
            dataType: 'json',
            data: {
                nombre: nombre,
                apellido_1: apellido_1,
                apellido_2: apellido_2,
                correo: correo,
                fecha: fecha,
                hora: hora,
                bar_code: bar_code,
                razon_social: razon_social,
                estado_destino: estado_destino,
                municipio_destino: municipio_destino,
                codigo_postal_destino: codigo_postal_destino,
                colonia_destino: colonia_destino,
                calle_destino: calle_destino,
                no_exterior_destino: no_exterior_destino,
                no_interior_destino: no_interior_destino
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.response_code == 200) {
                    limpiar_input_destino();
                    $('#bar_code_escaner').val('');
                    wizard.steps('reset');
                    successAlert(data.response_text);
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
    }

    function update_cliente_enventuel() {
        var hoy = new Date();
        var fecha = moment(hoy).format('YYYY-MM-DD');
        var hora = moment(hoy).format('h:mm:ss a');
        var bar_code = $('#bar_code_escaner').val();
        var nombre = $('#nombre').val();
        var apellido_1 = $('#apellido_1').val();
        var apellido_2 = $('#apellido_2').val();
        var razon_social = $('#razon_social').val();
        var rfc = $('#rfc_cliente').val();
        var estado = $('#estado_cliente').val();
        var municipio = $('#municipio_cliente').val();
        var codigo_postal = $('#codigo_postal').val();
        var colonia = $('#colonia_cliente').val();
        var calle = $('#calle_cliente').val();
        var no_exterior = $('#no_exterior_cliente').val();
        var no_interior = $('#no_interior_cliente').val();
        var correo = $('#correo_cliente').val();
        var telefono_1 = $('#telefono_1_cliente').val();
        var telefono_2 = $('#telefono_2_cliente').val();
        var estado_destino = $('#estado_destino').val();
        var municipio_destino = $('#municipio_destino').val();
        var codigo_postal_destino = $('#codigo_postal_destino').val();
        var colonia_destino = $('#colonia_destino').val();
        var calle_destino = $('#calle_destino').val();
        var no_exterior_destino = $('#no_exterior_destino').val();
        var no_interior_destino = $('#no_interior_interior').val();
        alertLoader();
        $.ajax({
            url: '/empleado/paquete_repartidor',
            type: 'post',
            dataType: 'json',
            data: {
                bar_code: bar_code,
                fecha: fecha,
                hora:hora,
                nombre: nombre,
                apellido_1: apellido_1,
                apellido_2: apellido_2,
                razon_social: razon_social,
                rfc: rfc,
                estado: estado,
                municipio: municipio,
                codigo_postal: codigo_postal,
                colonia: colonia,
                calle: calle,
                no_exterior: no_exterior,
                no_interior: no_interior,
                correo: correo,
                telefono_1: telefono_1,
                telefono_2: telefono_2,
                estado_destino: estado_destino,
                municipio_destino: municipio_destino,
                codigo_postal_destino: codigo_postal_destino,
                colonia_destino: colonia_destino,
                calle_destino: calle_destino,
                no_exterior_destino: no_exterior_destino,
                no_interior_destino: no_interior_destino
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.response_code == 200) {
                    limpiar_input();
                    limpiar_input_destino();
                    $('#bar_code_escaner').val('');
                    wizard.steps('reset');
                    successAlert(data.response_text);
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
    }

    function validar_paquete() {
        var bar_code = $('#bar_code_escaner').val();
        $.ajax({
            url: '/empleado/paquete_repartidor/' + bar_code,
            type: 'get',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.response_code == 200) {
                    wizard.steps('next');
                    localStorage.setItem('codigo_barras', bar_code);
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



