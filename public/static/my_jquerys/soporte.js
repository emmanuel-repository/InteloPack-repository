$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#compose-textarea').summernote();

    $(document).on('click', '#btn_enviar', function () {
        var asunto = $('#asunto').val();
        var mensaje = $('#compose-textarea').val();
        if(mensaje != ""){
            $.ajax({
                url: "/empleado/soporte",
                type: "POST",
                dataType: "json",
                data: { asunto: asunto, mensaje: mensaje },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.response_code == 200) {
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
    
        } else {
            warningAlert('Favor de escribir un mensaje')
        }
      
    });

    function successAlert(text) {
        Swal.fire(
            'Exito!', text, 'success'
        )
    }

    function warningAlert(text) {
        Swal.fire(
            '¡Verifica!', text, 'warning'
        )
    }
})
