<div class="card mb-3 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Lista de Sucursales</h5>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a type="button" class="btn btn-sm btn-success text-white" id="btn_open_modal_empleado"
                    data-toggle='tooltip' data-placement='right' title='Agregar Empleado'>
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded table-sm" id="data_table_socursal" width="100%"
                cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">Nombre de Sucursal</th>
                        <th class="text-center">No de Sucusal</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_agregar_socursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Sucursal</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_agregar_socursal">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre de Sucursal*</label>
                            <input type="text" class="form-control" id="nombre_socursal" name="nombre_socursal"
                                maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados*</label>
                            <select class="form-control select2" id="estado_socursal" name="estado_socursal">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio*</label>
                            <select class="form-control select2" id="municipio_socursal" name="municipio_socursal">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Código Postal*</label>
                            <input type="number" class="form-control" id="codigo_postal" name="codigo_postal"
                                maxlength="6">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Colonia*</label>
                            <select class="form-control select2" id="colonia_socursal" name="colonia_socursal">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Calle*</label>
                            <input type="text" class="form-control" id="calle_socursal" name="calle_socursal"
                                maxlength="100"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior*</label>
                            <input type="text" class="form-control" id="no_exterior" name="no_exterior" maxlength="12"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior" name="no_interior" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" id="" data-dismiss="modal" aria-label="Close">
                        Cancelar
                    </a>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_socursal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar datos de Sucursal</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_editar_socursal">
                @method('put')
                <div class="modal-body">
                    <div class="form-row">
                        <input type="text" class="form-control d-none" id="id_socursal_editar"
                            name="id_socursal_editar">
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre de Sucursal*</label>
                            <input type="text" class="form-control" id="nombre_socursal_editar"
                                name="nombre_socursal_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados*</label>
                            <input type="text" class="form-control" id="estado_socursal_editar" name="estado_socursal_editar"
                                readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio*</label>
                            <select class="form-control select2" id="municipio_socursal_editar"
                                name="municipio_socursal_editar"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Código Postal*</label>
                            <input type="numbre" class="form-control" id="codigo_postal_editar"
                                name="codigo_postal_editar" maxlength="6">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Colonia*</label>
                            <select class="form-control select2" id="colonia_socursal_editar"
                                name="colonia_socursal_editar"></select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Calle*</label>
                            <input type="text" class="form-control" id="calle_socursal_editar"
                                name="calle_socursal_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="100">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior*</label>
                            <input type="text" class="form-control" id="no_exterior_editar" name="no_exterior_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="12">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_editar" name="no_interior_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light" data-dismiss="modal" aria-label="Close">
                        Cancelar
                    </a>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>