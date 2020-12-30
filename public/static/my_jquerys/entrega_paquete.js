$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
                readers: [
                    "code_128_reader",
                    'ean_8_reader',
                    'ean_reader',
                    'code_39_reader',
                    'code_39_vin_reader',
                    'codabar_reader',
                    // 'upc_reader',
                    // 'upc_e_reader',
                    // 'i2of5_reader',
                    // '2of5_reader',
                    // 'code_93_reader'
                    // format: "code_128_reader",
                    // config: {}
                ]
            },
            locate: true
        },
        lastResult: null,
        multiple: false
    };

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

    $(document).on('click', '#btn_entregar_paquete', function () {
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Marcar como entregado este paquete!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                updata();
            }
        })
    });

    $(document).on('click', '#btn_visita_paquete', function () {  
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Marcar como entregado este paquete!",
            icon: 'warning',
            inputPlaceholder: 'Decripcion de visita',
            input: 'text',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            input: 'radio',
            inputOptions: {
                'opcion_1': 'No se encuentro el domicilio',
                'opcion_2': 'No se encuetra el destinatario para recibir el paquete',
                'opcion_3': 'El domicilio es incorrecto',
            },
            inputValidator: (value) => {
                if (!value) {
                  return '¡Tienes que elegir una opcion!!'
                } else {
                    var hoy = new Date();
                    const array = {
                        opcion_descricpion: value,
                        fecha:  moment(hoy).format('YYYY-MM-DD hh:mm:ss a'),
                        no_paquete: $('#no_paquete').val()
                    }
                    insert(array)
                }
              }
        })
    });

    $(document).on('click', '.btn_cancelar', function () {
        limpiar_inputs();
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

    function validar_paquete() {
        var bar_code = $('#bar_code_escaner').val();
        $.ajax({
            url: '/empleado/entrega_paquete/' + bar_code,
            type: 'get',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data.response_code == 200) {
                    var value = data.response_data;
                    $.fn.modal.Constructor.prototype._enforceFocus = function () { }
                    $('#modal_datos_cliente').modal({
                        backdrop: 'static', keyboard: false
                    });
                    $("#modal_datos_cliente").modal("show");
                    $('#no_paquete').val(value.no_paquete);
                    $('#nombre').val(value.nombre);
                    $('#apellido_1').val(value.apellido_1);
                    $('#apellido_2').val(value.apellido_2);
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

    function updata() {
        var bar_code = $('#bar_code_escaner').val();
        var hoy = new Date();
        var fecha = moment(hoy).format('YYYY-MM-DD');
        var hora = moment(hoy).format('h:mm:ss a');
        alertLoader()
        $.ajax({
            url: '/empleado/entrega_paquete/' + bar_code,
            type: 'put',
            dataType: 'json',
            data: {
                fecha: fecha,
                hora: hora
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.response_code == 200) {
                    limpiar_inputs();
                    $('#bar_code_escaner').val('');
                    $("#modal_datos_cliente").modal("hide");
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

    function insert(array) {
        alertLoader()
        $.ajax({
            url: '/empleado/entrega_paquete',
            type: 'post',
            dataType: 'json',
            data: array,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                limpiar_inputs();
                $('#bar_code_escaner').val('');
                $("#modal_datos_cliente").modal("hide");
                successAlert(data.response_text);
            },
            error: function (xhre) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function limpiar_inputs() {
        $('#no_paquete').val('');
        $('#nombre').val('');
        $('#apellido_1').val('');
        $('#apellido_2').val('');
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

