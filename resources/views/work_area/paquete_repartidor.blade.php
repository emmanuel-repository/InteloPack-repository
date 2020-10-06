<div class="container pb-3 pt-3">
    <div id="wizard">
        <h3>
            <div class="media">
                <div class="bd-wizard-step-icon"><i class="fa fa-barcode"></i></div>
                <div class="media-body">
                    <div class="bd-wizard-step-title">Escaner</div>
                    <div class="bd-wizard-step-subtitle">Paso 1</div>
                </div>
            </div>
        </h3>
        <section class="">
            <div class="container">
                <form id="form_validate_escaner">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Codigo de Barras escaneado</label>
                            <input type="number" class="form-control" id="bar_code_escaner" 
                                name="bar_code_escaner" >
                        </div>
                        <div class="form-group col-md-12 col-sm-6 col-lg-6">
                            <div id="interactive" class="viewport"></div>
                        </div>
                    </div>
                    <div class="form-group col-md-12 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <h3>
            <div class="media">
                <div class="bd-wizard-step-icon"><i class="fa fa-user"></i></div>
                <div class="media-body">
                    <div class="bd-wizard-step-title">Cliente</div>
                    <div class="bd-wizard-step-subtitle">Paso 2</div>
                </div>
            </div>
        </h3>
        <section>
            <form id="form_validate_cliente">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="recipient-name" class="col-form-label">Cliente registrado: </label>
                        <input class="form-control" type="checkbox" name="my-checkbox" data-bootstrap-switch
                            data-on-text="SI" data-off-text="NO" value="true" id="checkbox_cliente_frecuente">
                    </div>
                    <div class="form-group col-md-4 d-none" id="form_select_cliente">
                        <label for="recipient-name" class="col-form-label">Razon social</label>
                        <select class="form-control select2" id="razon_social_cliente" name="razon_social_cliente">
                            <option value="">Seleccione una Opción...</option>
                            @foreach($clientes as $item)
                            <option value="{{$item->id}}">{{$item->razon_social_cliente}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Nombre(s)*</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="70">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Primer Apellido*</label>
                        <input type="text" class="form-control" id="apellido_1" name="apellido_1" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="50">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Segundo Apelldo*</label>
                        <input type="text" class="form-control" id="apellido_2" name="apellido_2" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="50">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Razon Sociale*</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="100">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">RFC*</label>
                        <input type="text" class="form-control" id="rfc_cliente" name="rfc_cliente" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="14">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Estado*</label>
                        <div id="select_estado_cliente">
                            <select class="form-control select2" id="estado_cliente" name="estado_cliente">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Municipio*</label>
                        <div id="select_municipio_cliente">
                            <select class="form-control select2" id="municipio_cliente" name="municipio_cliente">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="recipient-name" class="col-form-label">Codigo Postal*</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="6">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="recipient-name" class="col-form-label">Colonia*</label>
                        <div id="select_colonia_cliente">
                            <select class="form-control select2" id="colonia_cliente" name="colonia_cliente">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="recipient-name" class="col-form-label">Calle*</label>
                        <input type="text" class="form-control" id="calle_cliente" name="calle_cliente" onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="100">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="recipient-name" class="col-form-label">No Exterior*</label>
                        <input type="text" class="form-control" id="no_exterior_cliente" name="no_exterior_cliente"
                            maxlength="12">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="recipient-name" class="col-form-label">No Interior</label>
                        <input type="text" class="form-control" id="no_interior_cliente" name="no_interior_cliente"
                            onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="12">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="recipient-name" class="col-form-label">Correo*</label>
                        <input type="email" class="form-control" id="correo_cliente" name="correo_cliente"
                            maxlength="100">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="recipient-name" class="col-form-label">Telefono 1*</label>
                        <input type="text" class="form-control" id="telefono_1_cliente" name="telefono_1_cliente"
                            onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="12">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="recipient-name" class="col-form-label">Telefono 2</label>
                        <input type="text" class="form-control" id="telefono_2_cliente" name="telefono_2_cliente"
                            onKeyUp="document.getElementById(this.id).value 
                                    = document.getElementById(this.id).value.toUpperCase()" maxlength="12">
                    </div>
                    <div class="form-group col-md-12 d-flex justify-content-end">
                        <a class="btn btn-light btn_cancelar mr-1 btn_previo">
                            <i class="fas fa-chevron-left"></i> Previo
                        </a>
                        <button class="btn btn-primary" type="submit">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </section>
        <h3>
            <div class="media">
                <div class="bd-wizard-step-icon"><i class="fa fa-location-arrow"></i></div>
                <div class="media-body">
                    <div class="bd-wizard-step-title">Salida</div>
                    <div class="bd-wizard-step-subtitle">Paso 3</div>
                </div>
            </div>
        </h3>
        <section>
            <div class="container">
                <form id="form_validate_salida">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre de Socursal</label>
                            <input type="text" class="form-control" id="nombre_sucursal_salida"
                                name="nombre_sucursal_salida" readonly value="{{$sucursal_salida->nombre_socursal}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. de socursal</label>
                            <input type="text" class="form-control" id="no_sucursal_salida" name="no_sucursal_salida"
                                readonly value="{{$sucursal_salida->no_socursal}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estado</label>
                            <input type="text" class="form-control" id="estado_sucursal_salida"
                                name="estado_sucursal_salida" readonly value="{{$sucursal_salida->estado_socursal}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio</label>
                            <input type="text" class="form-control" id="municipio_sucursal_salida"
                                name="municipio_sucursal_salida" readonly
                                value="{{$sucursal_salida->municipio_socursal}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Codigo Postal</label>
                            <input type="numbre" class="form-control" id="codigo_postal_sucursal_salida"
                                name="codigo_postal_sucursal_salida" readonly
                                value="{{$sucursal_salida->codigo_postal_socursal}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Colonia</label>
                            <input type="text" class="form-control" id="colonia_sucursal_salida"
                                name="colonia_sucursal_salida" readonly value="{{$sucursal_salida->colonia_socursal}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Calle</label>
                            <input type="text" class="form-control" id="calle_sucursal_salida"
                                name="calle_sucursal_salida" readonly value="{{$sucursal_salida->calle_socursal}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior</label>
                            <input type="text" class="form-control" id="no_exterior_sucursal_salida"
                                name="no_exterior_sucursal_salida" readonly
                                value="{{$sucursal_salida->no_exterior_socursal}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_sucursal_salida"
                                name="no_interior_sucursal_salida" readonly
                                value="{{$sucursal_salida->no_interior_socursal}}">
                        </div>
                        <div class="form-group col-md-12 d-flex justify-content-end">
                            <a class="btn btn-light btn_cancelar mr-1 btn_previo">
                                <i class="fas fa-chevron-left"></i> Previo
                            </a>
                            <button class="btn btn-primary" type="submit">
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <h3>
            <div class="media">
                <div class="bd-wizard-step-icon"><i class="fa fa-home"></i></div>
                <div class="media-body">
                    <div class="bd-wizard-step-title">Destino</div>
                    <div class="bd-wizard-step-subtitle">Paso 4</div>
                </div>
            </div>
        </h3>
        <section>
            <div class="container">
                <form id="form_validate_destino">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados*</label>
                            <select class="form-control select2" id="estado_destino" name="estado_destino">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio*</label>
                            <select class="form-control select2" id="municipio_destino" name="municipio_destino">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Codigo Postal*</label>
                            <input type="numbre" class="form-control" id="codigo_postal_destino"
                                name="codigo_postal_destino">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Colonia*</label>
                            <select class="form-control select2" id="colonia_destino" name="colonia_destino">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Calle*</label>
                            <input type="text" class="form-control" id="calle_destino" name="calle_destino"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="100">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior*</label>
                            <input type="text" class="form-control" id="no_exterior_destino" name="no_exterior_destino"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="14">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_destino"
                                name="no_interior_destino"
                                onKeyUp="document.getElementById(this.id).value = document.getElementById(this.id).value.toUpperCase()"
                                maxlength="14">
                        </div>
                        <div class="form-group col-md-12 d-flex justify-content-end">
                            <a class="btn btn-light btn_cancelar mr-1 btn_previo">
                                <i class="fas fa-chevron-left"></i> Previo
                            </a>
                            <button class="btn btn-primary" type="submit">
                                Guardar &nbsp;<i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>
            </div>
        </section>
    </div>
</div>