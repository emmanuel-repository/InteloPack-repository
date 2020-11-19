<div class="card mb-3 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Lista de Empleados</h5>
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
            <table class="table table-bordered table-striped rounded table-sm" id="data_table_empleados" width="100%"
                cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">Nombre completo</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Sucursal</th>
                        <th class="text-center">Tipo Usuario</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_agregar_empleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Empleado</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_empleado_agregar">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="70">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Primer Apellido*</label>
                            <input type="text" class="form-control" id="apellido1_empleado" name="apellido1_empleado"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Segundo Apellido*</label>
                            <input type="text" class="form-control" id="apellido2_empleado" name="apellido2_empleado"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Correo*</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="70">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Contraseña*</label>
                            <input type="password" class="form-control password1" id="password_empleado"
                                name="password_empleado" maxlength="20" minlength="6">
                            <span id="show-password"><i class="fa fa-fw fa-eye password-icon" id="eye"></i></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Tipo de Usuario*</label>
                            <select class="form-control select2" id="tipo_empleado" name="tipo_empleado">
                                <option value="">Seleccione una opción...</option>
                                @foreach($tipos_empleado as $item)
                                <option value="{{$item->id}}">{{$item->descripcion_tipo_empleado}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Socursal*</label>
                            <select class="form-control" id="sucursal" name="sucursal">
                                <option value="">Seleccione una opción...</option>
                                @foreach($sucursales as $item)
                                <option value="{{$item->id}}">{{$item->nombre_socursal}}</option>
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

<div class="modal fade" id="modal_editar_empleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar datos de Empleado</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_empleado_editar">
                @method('put')
                <div class="modal-body">
                    <div class="form-row">
                        <input type="text" class="form-control d-none" id="id_empleado_editar"
                            name="id_empleado_editar">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Nombre*</label>
                            <input type="text" class="form-control" id="nombre_empleado_editar"
                                name="nombre_empleado_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Primer Apellido*</label>
                            <input type="text" class="form-control" id="apellido1_empleado_editar"
                                name="apellido1_empleado_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Segundo Apellido*</label>
                            <input type="text" class="form-control" id="apellido2_empleado_editar"
                                name="apellido2_empleado_editar" maxlength="50"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Correo*</label>
                            <input type="email" class="form-control" id="email_empleado_editar"
                                name="email_empleado_editar" maxlength="50">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Contraseña</label>
                            <input type="password" class="form-control password2" id="password_empleado_editar"
                                name="password_empleado_editar" maxlength="20">
                            <span id="show-password_edit"><i class="fa fa-fw fa-eye password-icon" id="eye_edit"></i></span>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password_empleado_editar" maxlength="20">
                        </div> --}}
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Tipo de Usuario*</label>
                            <select class="form-control select2" id="tipo_empleado_editar" name="tipo_empleado_editar">
                                @foreach($tipos_empleado as $item)
                                <option value="{{$item->id}}">{{$item->descripcion_tipo_empleado}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Socursal*</label>
                            <select class="form-control" id="sucursal_editar" name="sucursal_editar">
                                @foreach($sucursales as $item)
                                <option value="{{$item->id}}">{{$item->nombre_socursal}}</option>
                                @endforeach
                            </select>
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