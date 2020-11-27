<div class="card mb-1 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Historial de paquetes</h5>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a type="button" class="btn btn-sm btn-success text-white" id="btn_open_modal_barcode" data-toggle='tooltip' data-placement='right' title='Imprimir código de barra'>
                    <i class="fa fa-barcode"></i> Imprimir código de barra
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="recipient-name" class="col-form-label">No de guía:</label>
                <input type="text" class="form-control password1" id="no_guia" name="no_guia">
            </div>
            <div class="form-group col-md-3">
                <label for="recipient-name" class="col-form-label">Sucursales:</label>
                <select class="form-control" id="sucursal" name="sucursal">
                    <option value="">Seleccione una opción...</option>
                    @foreach($sucursales as $item)
                    <option value="{{$item->id}}">{{$item->nombre_socursal}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="recipient-name" class="col-form-label">Estatus paquete:</label>
                <select class="form-control" id="estatus_paquete" name="estatus_paquete">
                    <option value="">Seleccione una opción...</option>
                    <option value="1">En sucursal</option>
                    <option value="2">En ruta</option>
                    <option value="3">En sucursal intermedia</option>
                    <option value="4">Entregado a su destinatario</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="recipient-name" class="col-form-label">Entre fecha:</label>
                <input type="date" class="form-control password1" id="fecha_inicio" name="fecha_inicio">
            </div>
            <div class="form-group col-md-2">
                <label for="recipient-name" class="col-form-label">Y fecha:</label>
                <input type="date" class="form-control password1" id="fecha_final" name="fecha_final">
            </div>
            <div class="form-group col-md-1">
                <label for="recipient-name" class="col-form-label">&nbsp;</label>
                <a class="btn btn-primary form-control" id="btn_buscar">
                    <i class="fas fa-search"></i>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded table-sm" id="data_table_paquetes" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">No. de guía</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detalle_paquete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Paquete No. de guía: <b class="text-primary" id='text_no_paquete'></b>
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <form id="form_validate_usuario_agregar">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-1">
                            <h5 class="text-secondary">Datos de Cliente</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre(s)</label>
                            <input type="text" class="form-control" id="nombre_completo" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Primer Apellido</label>
                            <input type="text" class="form-control" id="primer_apellido" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo_apellido" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Razón Social</label>
                            <input type="text" class="form-control" id="razon_social" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">RFC</label>
                            <input type="text" class="form-control" id="rfc_cliente" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <h5 class="text-secondary">Datos de salida del Paquete</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Nombre de Sucursal</label>
                            <input type="text" class="form-control" id="nombre_socursal" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. de Sucursal</label>
                            <input type="text" class="form-control" id="no_socursal" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados</label>
                            <input type="email" class="form-control" id="estado_socursal" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio</label>
                            <input type="email" class="form-control" id="municipio_socursal" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Código Postal</label>
                            <input type="numbre" class="form-control" id="codigo_postal_socursal" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Colonia</label>
                            <input type="text" class="form-control" id="colonia_socursal" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Calle</label>
                            <input type="text" class="form-control" id="calle_socursal" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior</label>
                            <input type="text" class="form-control" id="no_exterio_socursal" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_socursal" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <h5 class="text-secondary">Datos de destino del Paquete</h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Estados</label>
                            <input type="email" class="form-control" id="estado_destino" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Municipio</label>
                            <input type="email" class="form-control" id="municipio_destino" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">Código Postal</label>
                            <input type="numbre" class="form-control" id="codigo_postal_destino" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Colonia</label>
                            <input type="text" class="form-control" id="colonia_destino" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">Calle</label>
                            <input type="text" class="form-control" id="calle_destino" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Exterior</label>
                            <input type="text" class="form-control" id="no_exterior_destino" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recipient-name" class="col-form-label">No. Interior</label>
                            <input type="text" class="form-control" id="no_interior_destino" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" id="btn_cancelar_privada_editar" data-dismiss="modal" aria-label="Close">
                        Cerrar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_bar_code" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Código de Barra</h5>
                <button class="close btn_cancelar" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_validate_editar_socursal">
                    <div class="form-row">
                        <div class="form-group col-md-4 d-flex justify-content-end ">
                            <label for="recipient-name" class="col-form-label">Número de código de barra:</label>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="number" min="0" class="form-control" id="numero_bar_code" name="numero_bar_code">
                        </div>
                        <div class="form-group col-md-4">
                            <button class="btn btn-outline-warning" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>Buscar
                            </button>
                        </div>
                        <div class="form-group col-md-12 d-flex justify-content-cente">
                            <div class='col-sm-12 d-flex justify-content-center'>
                                <canvas id='canvas_bar_code' class='barcodeTarget pb-5' width='150' height='150'></canvas>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <a class="btn btn-light btn_cancelar" id="btn_cancelar_privada_editar" data-dismiss="modal" aria-label="Close">
                        Cerrar
                    </a>
                    <a class="btn btn-primary" id="btn_imprimir_bar_code">
                        <i class="fa fa-print"></i> Imprimir
                    </a>
                </div>
            </div>
        </div>
    </div>
