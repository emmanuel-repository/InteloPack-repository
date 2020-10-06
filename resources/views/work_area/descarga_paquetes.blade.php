<div class="card mb-1 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Llenar Datos de Descarga de Paquetes</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form_validate_agregar_paquete">
            <div class="form-row pb-0">
                <div class="form-group col-md-4">
                    <label for="recipient-name" class="col-form-label">Transporte</label>
                    <select class="form-control select2" id="transporte" name="transporte">
                        <option value="">Seleccione una opción</option>
                        @foreach($transportes as $item)
                        <option value="{{$item->id}}">
                            No. de Transporte: {{$item->no_transporte}} |
                            Matricula: {{$item->matricula_transporte}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="recipient-name" class="col-form-label">Codigo de Barra</label>
                    <input type="text" class="form-control" id="codigo_barra" name="codigo_barra" maxlength="50">
                </div>
                <div class="col-md-4 pt-4 mt-3">
                    <a class="btn btn-light mr-1" id="btn_cancelar_paquete">
                        Cancelar
                    </a>
                    {{-- <button class="btn btn-success" id="btn_agregar" type="submit">Agregar</button> --}}
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mb-1 card-outline card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center m-0">
                <h5 class="text-secondary">Vista previa de Codigos de barras Generados</h5>
            </div>
            <div class="form-group col-md-6 d-flex justify-content-end m-0">
                <a class="btn btn-light mr-1" id="btn_limpiar_tabla" data-toggle='tooltip' 
                    data-placement='right' title='Limpiar tabla'>
                    <i class="fas fa-calendar-times"></i>
                </a>
                <a class="btn btn-primary" data-toggle='tooltip' id="btn_guardar_cargamento" 
                    data-placement='right'   title='Guardar paquetes en Transporte'>
                    <i class="fas fa-save"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded table-sm" id="tabla_paquetes" width="100%"
                cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">Codigo de Barra</th>
                        <th class="text-center">Transporte</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>