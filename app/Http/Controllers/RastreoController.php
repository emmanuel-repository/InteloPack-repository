<?php

namespace App\Http\Controllers;

use App\Models\CrossOver;
use App\Models\Paquete;
use Illuminate\Http\Request;

class RastreoController extends Controller {

    public function index () {
        $data              = array();
        $data['titulo']    = 'Rastreo de Paquete | InteloPack';
        $data['my_jquery'] = 'rastreo_paquete.js';
        return view('rastreo_paquete')->with($data);
    }

    public function show($id) {
        $data              = array();
        $data['titulo']    = 'Rastreo de Paquete | InteloPack';
        $data['my_jquery'] = 'rastreo_paquete.js';
        return view('rastreo_paquete')->with($data);
    }

    public function edit($id) {
        $data         = array();
        $paquete      = new Paquete;
        $cross_over   = new CrossOver;
        $tipo_cliente = $paquete->select_existe_paquete($id);
        if (!is_null($tipo_cliente)) {
            $id_paquete               = $tipo_cliente->id;
            $cliente_id               = $tipo_cliente->cliente_id;
            $eventual_id              = $tipo_cliente->eventual_id;
            $selec_detalle_cross_over = $cross_over->select_detalle_cross_over($id_paquete);
            if (!is_null($cliente_id)) {
                $select_cliente_registrado = $paquete->select_paquete_cliente_registrado($id);
                $data['response_code']     = 200;
                $data['response_text']     = "Si hay datos";
                $data['response_data']     = $select_cliente_registrado;
                $data['response_data_1']     = $selec_detalle_cross_over;
            } else if (!is_null($eventual_id)) {
                $select_cliente_eventual = $paquete->select_paquete_cliente_eventual($id);
                $data['response_code']   = 200;
                $data['response_text']   = "Si hay datos6";
                $data['response_data']   = $select_cliente_eventual;
                $data['response_data_1']     = $selec_detalle_cross_over;
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No existe ese Numero de Guia";
        }
        return response()->json($data);
    }

    public function create() {}

    public function store(Request $request) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
