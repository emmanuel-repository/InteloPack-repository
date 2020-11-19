<div class="card mb-3 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Entrega de paquete</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form_validate_escaner">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="recipient-name" class="col-form-label">Código de barras escaneado</label>
                    <input type="text" class="form-control" id="bar_code_escaner" 
                        name="bar_code_escaner">
                </div>
                <div class="form-group col-md-12 col-sm-6 col-lg-6">
                    <div id="interactive" class="viewport"></div>
                </div>
            </div>
            <div class="form-group col-md-12 d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">
                    Verificar <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal_datos_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos de paquete</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_transporte_empleado">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">No. de Paquete</label>
                            <input type="text" class="form-control" id="no_paquete" name="no_paquete" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">Nombre(s)*</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">Primer Apellido</label>
                            <input type="text" class="form-control" id="apellido_1" name="apellido_1" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="apellido_2" name="apellido_2" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" data-dismiss="modal" aria-label="Close">
                        Cancelar
                    </a>
                    <a class="btn btn-primary" id="btn_entregar_paquete">Entregar</a>
                </div>
            </form>
        </div>
    </div>
</div>