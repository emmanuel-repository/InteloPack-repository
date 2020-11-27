$(document).ready(function () {
    var array_bar = [];
    var image_base_64_logo = "";
    var imagen_logo = 'http://127.0.0.1:8000/static/imagenes_intelo/intelo_logo_modificado.png'
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    toDataURL(imagen_logo, function (dataUrl) {
        image_base_64_logo = dataUrl
    });

    $('#form_validate_bar_code').validate({
        rules: {
            cantidad_folios: {
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
            confirmar_generar_bar_codes()
        }
    });

    $(document).on('click', '#imprimir_codigos', function () {
        var arreglo = [];
        var hoy = new Date();
        var fecha_convertida = moment(hoy).format('YYYY-MM-DD h:mm:ss');
        for (i = 0; i < array_bar.length; i++) {
            if (i == array_bar.length - 1) {
                var image = {
                    image: array_bar[i],
                    width: 600,
                    height: 250,
                    absolutePosition: { x: 100, y: 200 },
                    pageOrientation: 'landscape',
                }
            } else {
                var image = {
                    image: array_bar[i],
                    width: 600,
                    height: 250,
                    pageBreak: 'after',
                    absolutePosition: { x: 100, y: 200 },
                    pageOrientation: 'landscape',
                }
            }
            arreglo.push(image);
        }
        var docDefinition = {
            pageSize: 'LETTER',
            pageOrientation: 'landscape',
            pageMargins: [0, 100, 0, 90],
            content: [arreglo],
            header: function (currentPage, pageCount, pageSize) {
                return [
                    {
                        margin: [ 0, 10, 0, 0 ],
                        text: 'InteloPack',
                        alignment: 'center',
                        fontSize: 40,
                    },
                    {
                        text: 'Sistema de gestión de Paqueteria',
                        alignment: 'center',
                        fontSize: 26,
                    },
                    {
                        absolutePosition: { x: 590, y: 2},
                        image: image_base_64_logo,
                        width: 220,
                        height: 120,
                        margin: 10
                    },
                ]
            },
            footer: function (page, currentPage, pageCount) {
                return [
                    {
                        text: 'Fecha de creacion: ' + fecha_convertida,
                        alignment: 'center',
                        fontSize: 26,
                    },
                    {
                        text: 'https://intelopack.intelo.com.mx',
                        alignment: 'center',
                        fontSize: 26,
                    }
                ];
            },
        };
        pdfMake.createPdf(docDefinition).print();
        $('#add_bar_code').empty();
        $('#cantidad_folios').val('');
        $('#btn_generar_bar_codes').removeClass('d-none');
        $('#imprimir_codigos').addClass('d-none');
    });

    function confirmar_generar_bar_codes() {
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡Generar Codigos de Barras!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, generar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var cantidad_imprimir = $('#cantidad_folios').val();
                var hoy = new Date();
                var fecha_convertida = moment(hoy).format('YYYYMMDD');
                var fecha_hoy = moment(hoy).format('YYYY-MM-DD');
                if (cantidad_imprimir <= 20) {
                    insert(cantidad_imprimir, fecha_convertida, fecha_hoy);
                } else {
                    var mensaje = "¡Verifica!";
                    var text = "Solo se pueden imprimir una cantidad maxima de 20 Codigos de barras";
                    infoAlert(mensaje, text)
                }
            }
        })
    }

    function insert(cantidad_bar_code, fecha, fecha_hoy) {
        $.ajax({
            url: "/empleado/folios_recoleccion",
            method: "post",
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                cantidad_bar_code: cantidad_bar_code,
                fecha_hoy: fecha_hoy,
                fecha: fecha
            },
            success: function (data) {
                if (data.response_code == 200) {
                    var data_array = data.response_data;
                    generar_bar_codes(data_array);
                } else if (data.response_code == "500") {
                    infoAlert("Verifica", data.response_text);
                } else {
                    infoAlert("Verifica", data.response_text);
                }
            },
            error: function (xhr) {
                infoAlert('Error Fatal', 'Se produjo un error desconocido');
            }
        });
    }

    function generar_bar_codes(data_array) {
        var options = {
            bcid: 'code128', // Barcode type
            scale: 2, // 3x scaling factor
            height: 8, // Bar height, in millimeters
            includetext: true, // Show human-readable text
            textxalign: 'center', // Always good to set this
        }
        for (i = 0; i < data_array.length; i++) {
            options.text = data_array[i] + "";
            $("#add_bar_code").append("<div class='col-sm-6'> " +
                "<canvas id='canvas_" + i + "' class='barcodeTarget pb-5'" +
                " width='150' height='150'></canvas></div>");
            bwipjs.toCanvas('#canvas_' + i, options);
            canvas = document.getElementById('canvas_' + i);
            dataURL = canvas.toDataURL();
            array_bar[i] = dataURL;
        }
        $('#btn_generar_bar_codes').addClass('d-none');
        $('#imprimir_codigos').removeClass('d-none');
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

    function infoAlert(mensaje, text) {
        Swal.fire(
            mensaje, text, 'question'
        )
    }
})