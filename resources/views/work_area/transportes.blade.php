<div class="card mb-3 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Lista de Transportes</h5>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a type="button" class="btn btn-sm btn-success text-white" id="btn_open_modal_transporte"
                    data-toggle='tooltip' data-placement='right' title='Agregar Empleado'>
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded table-sm" id="data_table_transportes" width="100%"
                cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">No. transporte</th>
                        <th class="text-center">Matricula</th>
                        <th class="text-center">Socursal</th>
                        <th class="text-center">Tipo transporte</th>
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

<div class="modal fade" id="modal_agregar_transporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Transporte</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_transporte">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Matricula*</label>
                            <input type="text" class="form-control" id="matricula_transporte"
                                name="matricula_transporte" maxlength="20" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Número economico*</label>
                            <input type="text" class="form-control" id="no_economico_transporte"
                                name="no_economico_transporte" maxlength="20" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Marca*</label>
                            <input type="text" class="form-control" id="marca_transporte"
                                name="marca_transporte" maxlength="50" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Socuersal*</label>
                            <select class="form-control select2" id="sucursal" name="sucursal">
                                <option value="">SELECCIONE UNA OPICIÓN...</option>
                                @foreach($sucursales as $item)
                                <option value="{{$item->id}}">{{$item->nombre_socursal}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Tipo de transporte*</label>
                            <select class="form-control" id="tipo_transporte" name="tipo_transporte">
                                <option value="">SELECCIONE UNA OPICIÓN...</option>
                                @foreach($tipo_transportes as $item)
                                <option value="{{$item->id}}">{{$item->descripcion_tipo_transporte}}</option>
                                @endforeach
                            </select>
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

<div class="modal fade" id="modal_editar_transporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar datos de Transporte</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_editar_transporte">
                @method('put')
                <div class="modal-body">
                    <div class="form-row">
                        <input type="text" class="form-control d-none" id="id_transporte_editar"
                            name="id_transporte_editar">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Matricula*</label>
                            <input type="text" class="form-control" id="matricula_transporte_editar"
                                name="matricula_transporte_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Número economico*</label>
                            <input type="text" class="form-control" id="no_economico_transporte_editar"
                                name="no_economico_transporte_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Marca*</label>
                            <input type="text" class="form-control" id="marca_transporte_editar"
                                name="marca_transporte_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Socuersal*</label>
                            <select class="form-control select2" id="sucursal_editar" name="sucursal_editar">
                                @foreach($sucursales as $item)
                                <option value="{{$item->id}}">{{$item->nombre_socursal}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Tipo de Transporte*</label>
                            <select class="form-control" id="tipo_transporte_editar" name="tipo_transporte_editar">
                                @foreach($tipo_transportes as $item)
                                <option value="{{$item->id}}">{{$item->descripcion_tipo_transporte}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" id="btn_cancelar_privada_editar" data-dismiss="modal"
                        aria-label="Close">
                        Cancelar
                    </a>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
