<div class="card mb-1 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Lista Transportes asignados</h5>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a type="button" class="btn btn-sm btn-success text-white" id="btn_open_modal_transporte"
                    data-toggle='tooltip' data-placement='right' title='Asignar Chofer a Transporte'>
                    <i class="fas fa-truck"></i>
                    Asignar Chofer a Transportes
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded table-sm" id="data_table_transporte_empleado"
                width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">No. transporte</th>
                        <th class="text-center">Matricula</th>
                        <th class="text-center">Nombre chofer</th>
                        <th class="text-center">Socursal</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_transporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Chofer a Transporte</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_transporte_empleado">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">Socursal*</label>
                            <select class="form-control select2" id="sucursal" name="sucursal">
                                <option value="">Seleccione una opción</option>
                                @foreach($sucursales as $item)
                                <option value="{{$item->id}}">{{$item->nombre_socursal}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">Chofer*</label>
                            <select class="form-control select2" id="chofer" name="chofer">
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="recipient-name" class="col-form-label">Transporte*</label>
                            <select class="form-control" id="transporte" name="transporte">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" id="" data-dismiss="modal"
                        aria-label="Close">
                        Cancelar
                    </a>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
