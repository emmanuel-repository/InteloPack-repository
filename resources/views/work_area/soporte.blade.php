<div class="card mb-3 card-outline card-danger">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <h5 class="text-secondary">Soporte</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="recipient-name" class="col-form-label">Correo salida:</label>
            <input class="form-control" placeholder="Correo" value="{{Auth::user()->email}}" name="correo" id="correo" readonly>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Asunto:" name="asunto" id="asunto">
        </div>
        <div class="form-group">
            <textarea id="compose-textarea" class="form-control" style="height: 300px"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button id="btn_enviar" class="btn btn-primary">
                <i class="far fa-envelope"></i> Enviar</button>
        </div>
    </div>
</div>
