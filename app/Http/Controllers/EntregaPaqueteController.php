<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntregaPaqueteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Registro de Entrega de Paquete | InteloPack';
        $data['work_area'] = 'entrega_paquete';
        $data['my_jquery'] = 'entrega_paquete.js';
        return view('main')->with($data);
    }

    public function show($id) {
        $paquete = new Paquete;
        if ($paquete->select_exit_entrega_paquete($id)) {
            $validar_tipo_empleado = $paquete->select_exit_entrega_paquete($id);
            $cliente_id            = $validar_tipo_empleado->cliente_id;
            $eventual_id           = $validar_tipo_empleado->eventual_id;
            if (is_null($cliente_id)) {
                $data['response_data'] = $paquete->select_paquete_cliente_eventual($id);
            } else if (is_null($eventual_id)) {
                $data['response_data'] = $paquete->select_paquete_cliente_registrado($id);
            }
            $data['response_code'] = 200;
            $data['response_text'] = "Si existe el paquete";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No existe el paquete";
        }
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        $data  = array();
        $paquete = new Paquete;
        $array = array(
            'bar_code'    => $id,
            'fecha'       => $request->input('fecha'),
            'hora'        => $request->input('hora'),
            'socursal_id' => Auth::user()->socursal_id,
            'empleado_id' => Auth::user()->id
        );
        if ($paquete->update_estatus_entrega($array)) {
            $data['response_code'] = 200;
            $data['response_text'] = 'El registro de entrega se a guardo con Exito';
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'El registro de entrega no se a guardo con Exito';
        }
        return response()->json($data);
    }

    public function edit($id) {}

    public function create() {}

    public function store(Request $request) {}

    public function destroy($id) {}
}
