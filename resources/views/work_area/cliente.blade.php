<div class="card mb-1 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Lista de Clientes</h5>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a type="button" class="btn btn-sm btn-success text-white" id="btn_open_modal_cliente"
                    data-toggle='tooltip' data-placement='right' title='Agregar Empleado'>
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded table-sm" id="data_table_clientes" width="100%"
                cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">Nombre completo</th>
                        <th class="text-center">Razon social</th>
                        <th class="text-center">RFC</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_agregar_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_cliente_agregar">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12 pb-0 mb-0">
                            <h5 class="text-secondary">Datos Generales:</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre(s)*</label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="70">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Primer Apellido*</label>
                            <input type="text" class="form-control" id="apellido1_cliente" name="apellido1_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Segundo Apellido*</label>
                            <input type="text" class="form-control" id="apellido2_cliente" name="apellido2_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Razon Social*</label>
                            <input type="text" class="form-control" id="razon_social_cliente"
                                name="razon_social_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">RFC*</label>
                            <input type="text" class="form-control" id="rfc_cliente" name="rfc_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="14">
                        </div>
                        <div class="form-group col-md-12 pb-0 mb-0">
                            <h5 class="text-secondary">Datos de Contacto:</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados*</label>
                            <select class="form-control select2" id="estado_cliente" name="estado_cliente">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio*</label>
                            <select class="form-control select2" id="municipio_cliente" name="municipio_cliente">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Codigo Postal*</label>
                            <input type="numbre" class="form-control" id="codigo_postal_cliente"
                                name="codigo_postal_cliente" maxlength="6">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Colonia*</label>
                            <select class="form-control select2" id="colonia_cliente" name="colonia_cliente">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Calle*</label>
                            <input type="text" class="form-control" id="calle_cliente" name="calle_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="100">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior*</label>
                            <input type="text" class="form-control" id="no_exterior_cliente" name="no_exterior_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_cliente" name="no_interior_cliente"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Correo*</label>
                            <input type="email" class="form-control" id="email_cliente" name="email_cliente"
                                maxlength="70">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Telefono 1*</label>
                            <input type="text" class="form-control" id="telefono1_cliente" name="telefono1_cliente"
                                maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Telefono 2</label>
                            <input type="text" class="form-control" id="telefono2_cliente" name="telefono2_cliente"
                                maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" data-dismiss="modal" aria-label="Close">
                        Cancelar
                    </a>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar datos de Cliente</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_cliente_editar">
                @method('put')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12 pb-0 mb-0">
                            <h5 class="text-secondary">Datos Generales:</h5>
                        </div>
                        <input type="text" class="form-control d-none" id="id_cliente_editar" name="id_cliente_editar">
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre(s)*</label>
                            <input type="text" class="form-control" id="nombre_cliente_editar"
                                name="nombre_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="70">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Primer Apellido*</label>
                            <input type="text" class="form-control" id="apellido1_cliente_editar"
                                name="apellido1_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Segundo Apellido*</label>
                            <input type="text" class="form-control" id="apellido2_cliente_editar"
                                name="apellido2_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Razon Social*</label>
                            <input type="text" class="form-control" id="razon_social_cliente_editar"
                                name="razon_social_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">RFC*</label>
                            <input type="text" class="form-control" id="rfc_cliente_editar" name="rfc_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="14">
                        </div>
                        <div class="form-group col-md-12 pb-0 mb-0">
                            <h5 class="text-secondary">Datos de Contacto:</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados*</label>
                            <input type="numbre" class="form-control" id="estado_cliente_editar"
                                name="estado_cliente_editar" maxlength="50" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio*</label>
                            <select class="form-control select2" id="municipio_cliente_editar"
                                name="municipio_cliente_editar">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Codigo Postal*</label>
                            <input type="numbre" class="form-control" id="codigo_postal_cliente_editar"
                                name="codigo_postal_cliente_editar" maxlength="6">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Colonia*</label>
                            <select class="form-control select2" id="colonia_cliente_editar"
                                name="colonia_cliente_editar">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Calle*</label>
                            <input type="text" class="form-control" id="calle_cliente_editar"
                                name="calle_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="100">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior*</label>
                            <input type="text" class="form-control" id="no_exterior_cliente_editar"
                                name="no_exterior_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_cliente_editar"
                                name="no_interior_cliente_editar"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Correo*</label>
                            <input type="email" class="form-control" id="email_cliente_editar"
                                name="email_cliente_editar" maxlength="70">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Telefono 1*</label>
                            <input type="text" class="form-control" id="telefono1_cliente_editar"
                                name="telefono1_cliente_editar" maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Telefono 2</label>
                            <input type="text" class="form-control" id="telefono2_cliente_editar"
                                name="telefono2_cliente_editar" maxlength="10">
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
