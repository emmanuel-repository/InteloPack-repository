<div class="card mb-1 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Generar folios de recolección</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="form_validate_bar_code">
            <div class="form-inline" id="impresion">
                <div class="input-group mb-2 mr-sm-2">
                    <label class="pr-2 col-form-label">Ingrese cantidad de folios a imprimir:</label>
                    <input type="number" class="form-control" id="cantidad_folios" 
                        name="cantidad_folios" min="1" max="100">
                </div>
                <div class="pr-2">
                    <button class="btn btn-light mb-2" id="btn_generar_bar_codes" type="submit" >
                        <i class="fas fa-barcode prueba"></i> Generar códigos
                    </button>
                </div>
                <div class="pr-2">
                    <a class="btn btn-primary mb-2 d-none" id="imprimir_codigos">
                        <i class="fas fa-print prueba"></i> Imprimir
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="card mb-1 card-outline card-primary">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Vista previa de Codigos de barras generados</h5>
            </div>
        </div>
    </div>
    <div class="card-body d-flex justify-content-center">
        <div id="add_bar_code" class="row d-flex justify-content-center"></div>
    </div>
</div>