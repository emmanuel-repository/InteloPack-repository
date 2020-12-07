$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var array_operador = "";
    var image_base_64_logo = "";
    var imagen_logo = 'http://127.0.0.1:8000/static/imagenes_intelo/intelo_logo_modificado.png'
    $('#tabla_paquetes').DataTable({
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
            }
        }
    });
    $('#socursal').select2({ theme: 'bootstrap4' });
    $('#transporte').select2({ theme: 'bootstrap4' });
    $('#operadores').select2({ theme: 'bootstrap4' });
    $("#checkbox_cliente_frecuente").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
    var form_validate_agregar = $('#form_validate_agregar_paquete').validate({
        rules: {
            transporte: {
                required: true,
            },
            codigo_barra: {
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
            cargar_paquete();
        }
    });

    $(document).on('change', '#socursal', function () {
        var id_socursal = $(this).val();
        var socursal_login = $('#id_socursal').val();
        $('#transporte').empty();
        $('#socursal').select2({ disabled: true });
        cargar_transportes_operadores(id_socursal);
        if (id_socursal == socursal_login) {
            $('#col_check').addClass('d-flex justify-content-end align-items-center');
            $('#col_check').removeClass('d-none');
        } else {
            $('#col_check').addClass('d-none');
            $('#col_check').removeClass('d-flex justify-content-end align-items-center');
        }
    });

    $(document).on('change', '#transporte', function () {
        var value_transporte = $(this).val();
        var operadores = array_operador;
        var empleado_id = "";
        for (var i = 0; i < operadores.length; i++) {
            if (value_transporte == operadores[i].transporte_id) {
                empleado_id = operadores[i].id;
            }
        }
        $('#operadores').val(empleado_id); // Select the option with a value of '1'
        $('#operadores').trigger('change');
        $('#transporte').select2({ disabled: true });
    });

    $('#checkbox_cliente_frecuente').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            $('#operadores').select2({ disabled: false });
        } else {
            $('#operadores').select2({ disabled: true });
        }
    });

    $(document).on('change', '#operadores', function () {
        $('#operadores').select2({ disabled: true });
    });

    $(document).on('click', '#btn_cancelar_paquete', function () {
        $('#checkbox_cliente_frecuente').bootstrapSwitch('state', false);
        $('#col_check').addClass('d-none');
        $('#col_check').removeClass('d-flex justify-content-end align-items-center');
        $("#socursal option[value='']").prop("selected", "selected");
        $('#socursal').select2({ disabled: false });
        $('#transporte').select2({ disabled: false });
        $('#operadores').select2({ disabled: false });
        $('#transporte').empty();
        $('#operadores').empty();
        $('#codigo_barra').val('');
    });

    $(document).on('click', '#btn_remover_paquete', function () {
        var tabla = $("#tabla_paquetes").DataTable();
        var row = tabla.row($(this).parent().parent());
        tabla.row(row).remove().draw(false);
    });

    $(document).on('click', '#btn_guardar_cargamento', function () {
        insert();
    });

    $(document).on('click', '#btn_limpiar_tabla', function () {
        Swal.fire({
            title: '¿Esta seguro?',
            text: "¡De limpiar la tabla! Todos los paquetes se van a quitar de la tabla.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, limpiar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                var tabla = $("#tabla_paquetes").DataTable();
                tabla.clear().draw(false);
            }
        });
    });

    toDataURL(imagen_logo, function (dataUrl) {
        image_base_64_logo = dataUrl
    });

    function cargar_paquete() {
        var validador = false;
        var tabla = $('#tabla_paquetes').DataTable();
        var transporte = $('#transporte option:selected').text();
        var codigo_barras = $('#codigo_barra').val();
        var data = data = tabla.rows().data();
        $.ajax({
            url: '/empleado/cargar_paquetes/' + codigo_barras + "/edit",
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (value) {
                if (value.response_code == 200) {
                    if (data.length == 0) {
                        tabla.row.add([codigo_barras, value.response_data,
                            "<a id='btn_remover_paquete' class='btn btn-outline-danger btn-sm'" +
                            " data-toggle='tooltip' data-placement='right' " +
                            " title='Quitar paquete de este transporte'>" +
                            "<i class='fa fa-minus'></i></a>"
                        ]).draw(false);
                    } else {
                        for (var i = 0; i < data.length; i++) {
                            var validar_codigo = data[i][0];
                            if (validar_codigo == codigo_barras) {
                                validador = true;
                            }
                        }
                        if (!validador) {
                            tabla.row.add([codigo_barras, value.response_data,
                                "<a id='btn_remover_paquete' class='btn btn-outline-danger btn-sm'" +
                                " data-toggle='tooltip' data-placement='right' " +
                                " title='Quitar paquete de este transporte'>" +
                                "<i class='fa fa-minus'></i></a>"
                            ]).draw(false);
                        } else {
                            var mensaje = "Verifica"
                            var texto = "Ya se encuentra cargado en la tabla ese Paquete"
                            infoAlert(mensaje, texto);
                        }
                    }
                    $('#codigo_barra').val('');
                } else if (value.response_code == 500) {
                    infoAlert("Verifica", value.response_text);
                } else {
                    infoAlert("Verifica", value.response_text);
                }
            },
            error: function (xhr) {
                infoAlert("Verifica", value.response_text);
            }
        });
    }

    function cargar_transportes_operadores(id_sucursal) {
        $.ajax({
            url: '/empleado/cargar_paquetes/' + id_sucursal,
            type: 'get',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                var transporte = data.response_data;
                var operadores = data.response_data_1;
                var select_transporte = $('#transporte');
                var select_operador = $('#operadores');
                array_operador = data.response_data_1;
                select_transporte.append('<option value="">Seleccione una opción</option>');
                for (var i = 0; i < transporte.length; i++) {
                    select_transporte.append('<option value="' + transporte[i].id + '">'
                        + "</br> <b>No de transporte:</b> "
                        + transporte[i].no_transporte + ". </br> <b> | Matricula:</b> "
                        + transporte[i].matricula_transporte +
                        '</option>');
                }
                select_operador.append('<option value="">Seleccione una opción</option>');
                for (var i = 0; i < operadores.length; i++) {
                    select_operador.append('<option value="' + operadores[i].id + '">'
                        + "</br> <b>No de empleado:</b> "
                        + operadores[i].no_empleado + ". </br> <b> | Nombre:</b> "
                        + operadores[i].nombre_empleado + ' ' + operadores[i].apellido_1_empleado
                        + ' ' + operadores[i].apellido_2_empleado + '</option>');
                }
                $('#operadores').select2({ disabled: true });
                $('#transporte').select2({ theme: 'bootstrap4' });
                $('#operadores').select2({ theme: 'bootstrap4' });
            },
            error: function (xhr) {
                infoAlert("Verifica", data.response_text);
            }
        });
    }

    function insert() {
        if (validar_formulario()) {
            var arreglo = [];
            var json_tabla;
            var tabla = $("#tabla_paquetes").DataTable();
            var datos_tabla = tabla.rows().data();
            var longitud = datos_tabla.length;
            var hoy = new Date();
            var fecha = moment(hoy).format('YYYY-MM-DD');
            var hora = moment(hoy).format('h:mm:ss a')
            var id_transporte = $('#transporte').val();
            var id_operador = $('#operadores').val();
            if (longitud > 0) {
                for (i = 0; i < datos_tabla.length; i++) {
                    var row = datos_tabla[i];
                    var person = {
                        no_paquete: row[0],
                        id_transporte: id_transporte,
                        fecha: fecha,
                        hora: hora
                    };
                    arreglo.push(person);
                }
                json_tabla = JSON.stringify(arreglo);
                alertLoader();
                $.ajax({
                    url: '/empleado/cargar_paquetes',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        json_tabla: json_tabla,
                        transporte: id_transporte,
                        operador: id_operador
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.response_code == 200) {
                            generar_pdf_carga(data.response_data, data.response_data_1);
                            successAlert(data.response_text);
                            tabla.clear().draw(false);
                            limpiar_inputs();
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
            } else {
                infoAlert("Verifica", 'La tabla no contiene paquetes cargados');
            }
        } else {
            var mensaje = "Verifica"
            var texto = "Favor de llenar los datos de formulario"
            infoAlert(mensaje, texto);
        }
    }

    function validar_formulario() {
        var socursal = $('#socursal').val();
        var transporte = $('#transporte').val();
        var operador = $('#operadores').val();
        if (socursal != "" && transporte != "" && operador != "") {
            return true;
        } else {
            return false;
        }
    }

    function generar_pdf_carga(data_paquetes, data_transporte) {
        var empleado = $('#operadores option:selected').text();
        var texto_separado = empleado.split(' | ');
        var empleado_split = texto_separado[1].split(': ')
        var nombre_empleado = empleado_split[1];
        var hoy = new Date();
        var fecha_convertida = moment(hoy).format('YYYY-MM-DD h:mm:ss');
        var array_content_pdf = [[
            { text: 'Folio', fontSize: 9, bold: true, alignment: 'center' },
            { text: 'Cantidad', fontSize: 9, bold: true, alignment: 'center' },
            { text: 'Destino', fontSize: 9, bold: true, alignment: 'center' }
        ]];
        var fila = [];
        var no_paquete = "";
        var destino_paquete = "";
        var cantida_paquetes = data_paquetes.length;
        for (i = 0; i < data_paquetes.length; i++) {
            no_paquete = data_paquetes[i].no_paquete;
            destino_paquete = "Calle " + data_paquetes[i].calle_destino
                + " No. exterior " + data_paquetes[i].no_exterior_destino
                + " No. interio " + data_paquetes[i].no_interior_destino
                + ", Colonia " + data_paquetes[i].colonia_destino
                + ", CP. " + data_paquetes[i].codigo_postal_destino
                + " " + data_paquetes[i].municipio_destino
                + ", " + data_paquetes[i].estado_destino;
            fila = [
                { text: no_paquete, fontSize: 9, bold: true },
                { text: 1, fontSize: 9, bold: true },
                { text: destino_paquete, fontSize: 9, bold: true },
            ];
            array_content_pdf.push(fila);
        }
        var docDefinition = {
            pageSize: 'LETTER',
            pageMargins: [40, 60, 40, 60],
            header: function (currentPage, pageCount, pageSize) {
                return [
                    {
                        text: 'InteloPack, Sistema de gestión de Paqueteria',
                        absolutePosition: { x: 95, y: 28 },
                        fontSize: 18,
                        margin: 70
                    },
                    {
                        image: image_base_64_logo,
                        width: 100,
                        height: 75,
                        margin: 70,
                        absolutePosition: { x: 480, y: 5 },
                    },

                ]
            },
            content: [
                {
                    alignment: 'center',
                    text: 'Embarque de Salida',
                    style: 'header',
                    fontSize: 18,
                    bold: true,
                    margin: [0, 15],
                },
                {
                    margin: [0, 0, 0, 10],
                    table: {
                        widths: ['100%'],
                        body: [
                            [{ text: 'Nombre del operador: ' + nombre_empleado, fontSize: 9, bold: true }],
                            [{ text: 'Fecha de enbarque: ' + fecha_convertida, fontSize: 9, bold: true }],
                            [{ text: 'Cantidad folios: ' + cantida_paquetes, fontSize: 9, bold: true }],
                        ]
                    },
                    layout: {
                        fillColor: function (rowIndex, node, columnIndex) {
                            return (rowIndex % 2 === 0) ? '#ebebeb' : '#f5f5f5';
                        },
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 1 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 1 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? '#dee2e6' : '#dee2e6';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? '#dee2e6' : '#dee2e6';
                        },
                    },
                },
                {
                    alignment: 'center',
                    text: 'Detalle de embarque',
                    style: 'header',
                    fontSize: 18,
                    bold: true,
                    margin: [0, 10],
                },
                {
                    style: 'tableExample',
                    table: {
                        widths: ['20%', '20%', '60%'],
                        headerRows: 1,
                        body: array_content_pdf
                    },
                    layout: {
                        fillColor: function (rowIndex, node, columnIndex) {
                            return (rowIndex === 0) ? '#e9ecef' : null;
                        },
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 1 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 1 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? '#dee2e6' : '#dee2e6';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? '#dee2e6' : '#dee2e6';
                        }
                    }
                },
                {
                    alignment: 'center',
                    text: 'Datos de la unidad',
                    style: 'header',
                    fontSize: 18,
                    bold: true,
                    margin: [0, 10],
                },
                {
                    margin: [0, 0, 0, 10],
                    table: {
                        widths: ['100%'],
                        body: [
                            [{
                                text: 'Matricula: ' + data_transporte.matricula_transporte,
                                fontSize: 9, bold: true
                            }],
                            [{
                                text: 'Número economico: ' + data_transporte.no_economico_transporte,
                                fontSize: 9, bold: true
                            }],
                            [{
                                text: 'Tipo unidad: ' + data_transporte.descripcion_tipo_transporte,
                                fontSize: 9, bold: true
                            }],
                            [{
                                text: 'Marca: ' + data_transporte.marca_transporte,
                                fontSize: 9, bold: true
                            }],
                        ],
                    },
                    layout: {
                        fillColor: function (rowIndex, node, columnIndex) {
                            return (rowIndex % 2 === 0) ? '#ebebeb' : '#f5f5f5';
                        },
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 1 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 1 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? '#dee2e6' : '#dee2e6';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? '#dee2e6' : '#dee2e6';
                        }
                    }
                },
                {
                    alignment: 'center',
                    text: 'Firma: __________________________________________',
                    style: 'header',
                    fontSize: 12,
                    bold: true,
                    margin: [0, 60],
                },
            ],
            footer: function (page, currentPage, pageCount) {
                return [
                    {
                        text: 'Fecha de creacion: ' + fecha_convertida,
                        alignment: 'center',
                        fontSize: 12,
                    },
                    {
                        text: 'https://intelopack.intelo.com.mx',
                        alignment: 'center',
                        fontSize: 12,
                    }
                ];
            },
        };
        pdfMake.createPdf(docDefinition).open();
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

    function limpiar_inputs() {
        $("#socursal option[value='']").prop("selected", "selected");
        $('#socursal').select2({ disabled: false });
        $('#transporte').select2({ disabled: false });
        $('#operadores').select2({ disabled: false });
        $('#transporte').empty();
        $('#operadores').empty();
        $('#codigo_barra').val('');
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


    // $(document).on('click', '#btn_prueba_pdf', function () {
    //     pruba_pdf_html();
    // });


    // function pruba_pdf_html() {
    //     var html = htmlToPdfmake(` `,
    //          { window: window, tableAutoSize: true });

    //     //var html = htmlToPdfMake(``, {window:window, tableAutoSize:true});
    //     //console.log(JSON.stringify(html))

    //     var docDefinition = {
    //         content: [
    //             html
    //         ],
    //         pageBreakBefore: function (currentNode) {
    //             // we add a page break before TABLE with the classname "pdf-pagebreak-before"
    //             return currentNode.table && currentNode.style && currentNode.style.indexOf('pdf-pagebreak-before') > -1;
    //         },
    //         styles: {
    //             red: {
    //                 color: 'red'
    //             },
    //             blue: {
    //                 color: 'blue'
    //             },
    //             bold: {
    //                 bold: true
    //             },
    //             'html-h6': {
    //                 color: 'purple'
    //             },
    //             'html-strong': {
    //                 color: 'purple'
    //             },
    //             'a': {
    //                 bold: true
    //             },
    //             'b': {
    //                 italics: true
    //             },
    //             'c': {
    //                 color: 'red',
    //                 italics: false
    //             },
    //             'with-spaces': {
    //                 preserveLeadingSpaces: true
    //             }
    //         }
    //     };

    //     pdfMake.createPdf(docDefinition).open();
    // }

})