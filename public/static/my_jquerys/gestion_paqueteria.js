$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var image_base_64_logo = "";
    var imagen_logo = 'http://127.0.0.1:8000/static/imagenes_intelo/intelo_logo_modificado.png'

    cargar_tabla();
    toDataURL(imagen_logo, function (dataUrl) { image_base_64_logo = dataUrl });

    $('#data_table_paquetes').DataTable();

    $('#form_validate_editar_socursal').validate({
        rules: {
            numero_bar_code: {
                required: true,
            },
        },
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
            generar_bar_code();
        }
    });

    $(document).on('click', '#btn_open_modal_detalle', function () {
        var tabla = $("#data_table_paquetes").DataTable();
        var row = tabla.row($(this).parent().parent());
        var data = row.data();
        var no_paquete = data.no_paquete;
        $('#text_no_paquete').empty(no_paquete)
        $('#text_no_paquete').append(no_paquete)
        obtener_datos_paquete(data);
        $('#modal_detalle_paquete').modal({ backdrop: 'static', keyboard: false });
        $("#modal_detalle_paquete").modal("show");
    });

    $(document).on('click', '#btn_open_modal_barcode', function () {
        $('#modal_bar_code').modal({ backdrop: 'static', keyboard: false });
        $("#modal_bar_code").modal("show");
    });

    $(document).on('click', '.btn_cancelar', function () {
        var c = document.getElementById("canvas_bar_code");
        var ctx = c.getContext("2d");
        $('#numero_bar_code').val('');
        ctx.clearRect(0, 0, canvas.width, canvas.height)

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
            content: [image],
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
        var c = document.getElementById("canvas_bar_code");
        var ctx = c.getContext("2d");
        $("#modal_bar_code").modal("hide");
        $('#numero_bar_code').val('');
        pdfMake.createPdf(docDefinition).print();
        ctx.clearRect(0, 0, canvas.width, canvas.height)
    });

    function cargar_tabla() {
        $.ajax({
            url: "/empleado/gestion_paqueteria/create",
            method: "get",
            dataType: "json",
            data: { _token: CSRF_TOKEN },
            success: function (data) {
                if (data.response_code == 200) {
                    $('#data_table_paquetes').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "data": data.response_data,
                        "columns": [{
                            'data': "no_paquete"
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                var text = "";
                                if (data.estatus_paquete == 1) {
                                    text = "<div class='text-success'>En socursal</div>";
                                } else if (data.estatus_paquete == 2) {
                                    text = "<div class='text-warning'>En ruta</div>";
                                } else if (data.estatus_paquete == 3) {
                                    text = "<div class='text-primary'>Entregado a su destinatario</div>";
                                }
                                return text;
                            }
                        },
                        {
                            'data': null,
                            'render': function (data, type, row, meta) {
                                return "<a id='btn_open_modal_detalle' " +
                                    " class='btn btn-outline-success btn-sm' " +
                                    "data-toggle='tooltip' data-placement='right' title='Ver detalle de Paquete'>" +
                                    "<i class='fas fa-info-circle'></i></a>";
                            }
                        }
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
                } else if (data.response_code == "500") { }
            },
            error: function (xhr) {
                infoAlert('Error Fatal', 'Se produjo un error desconocido');
            }
        });
    }

    function obtener_datos_paquete(data) {
        var id_paquete = data.id;
        var id_eventual = data.eventual_id;
        var id_cliente = data.cliente_id;
        $.ajax({
            url: "/empleado/gestion_paqueteria",
            method: "post",
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                id_paquete: id_paquete,
                id_eventual: id_eventual,
                id_cliente: id_cliente
            },
            success: function (data) {
                if (data.response_code == 200) {
                    var array = data.response_data;
                    set_cliente(array);
                } else if (data.response_code == "500") { }
            },
            error: function (xhr) {
                infoAlert('Error Fatal', 'Se produjo un error desconocido');
            }
        });
    }

    function generar_bar_code() {
        var numero_bar_code = $('#numero_bar_code').val();
        $.ajax({
            url: '/empleado/gestion_paqueteria/' + numero_bar_code,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data.response_code == 200) {
                    data = data.response_data;
                    var options = {
                        text: '' + data,
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

    function set_cliente(data) {
        $('#nombre_completo').val(data.nombre);
        $('#primer_apellido').val(data.apellido_1);
        $('#segundo_apellido').val(data.apellido_2);
        $('#razon_social').val(data.razon_social);
        $('#rfc_cliente').val(data.rfc);
        $('#nombre_socursal').val(data.nombre_socursal);
        $('#no_socursal').val(data.no_socursal);
        $('#estado_socursal').val(data.estado_socursal);
        $('#municipio_socursal').val(data.municipio_socursal);
        $('#codigo_postal_socursal').val(data.codigo_postal_socursal);
        $('#colonia_socursal').val(data.colonia_socursal);
        $('#calle_socursal').val(data.calle_socursal);
        $('#no_exterio_socursal').val(data.no_exterior_socursal);
        $('#no_interio_socursal').val(data.no_interior_destino);
        $('#estado_destino').val(data.estado_destino);
        $('#municipio_destino').val(data.municipio_destino);
        $('#codigo_postal_destino').val(data.codigo_postal_destino);
        $('#colonia_destino').val(data.colonia_destino);
        $('#calle_destino').val(data.calle_destino);
        $('#no_exterior_destino').val(data.no_exterior_destino);
        $('#no_interior_destino').val(data.no_interior_destino);
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