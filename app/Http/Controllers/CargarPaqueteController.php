<?php

namespace App\Http\Controllers;

use App\Models\CrossOver;
use App\Models\Empleado;
use App\Models\Paquete;
use App\Models\Socursal;
use App\Models\Transporte;
use App\Models\TransporteEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CargarPaqueteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data               = array();
        $data['titulo']     = 'Cargar Paquetes | InteloPack';
        $data['work_area']  = 'cargar_paquetes';
        $data['my_jquery']  = 'cargar_paquetes.js';
        $data['sucursales'] = Socursal::all()->where('estatus_socursal', 1);
        return view('main')->with($data);
    }

    public function store(Request $request) {
        $data                       = array();
        $cross_over                 = new CrossOver;
        $transporte_empleado        = new TransporteEmpleado;
        $paquete                    = new Paquete;
        $transporte                 = new Transporte;
        $json_tabla                 = json_decode($request->input('json_tabla'));
        $id_transporte              = $request->input('transporte');
        $id_operador                = $request->input('operador');
        $id_empleado                = Auth::user()->id;
        $id_socuersal               = Auth::user()->socursal_id;
        $select_transporte_operador = $transporte_empleado->select_transporte_operador($id_transporte);
        if (is_null($select_transporte_operador)) {
            $select_exist_transporte_operador =
            $transporte_empleado->select_exist_transporte_operador($id_operador);
            $array_exist = array(
                'id'                  => $select_exist_transporte_operador->id,
                'empleado_id'         => $select_exist_transporte_operador->empleado_id,
                'transporte_id'       => $select_exist_transporte_operador->transporte_id,
                'id_transporte_input' => $id_transporte,
            );
            if ($transporte_empleado->update_operador_transporte_carga_paquete($array_exist)) {
                if ($cross_over->insert_cross_over($json_tabla, $id_empleado, $id_socuersal,
                    $id_transporte, $id_operador)) {
                    $array_detalle_paquete    = $paquete->select_paquete_carga($json_tabla);
                    $array_detalla_transporte = $transporte->select_transporte_detalle($id_transporte);
                    $data['response_code']    = 200;
                    $data['response_data']    = $array_detalle_paquete;
                    $data['response_data_1']  = $array_detalla_transporte;
                    $data['response_text']    = 'Se guardarón los datos con éxito';
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = 'No se guardarón los datos';
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = '';
            }
        } else if ($id_operador == $select_transporte_operador->empleado_id) {
            if ($cross_over->insert_cross_over($json_tabla, $id_empleado, $id_socuersal,
                $id_transporte, $id_operador)) {
                $array_detalle_paquete    = $paquete->select_paquete_carga($json_tabla);
                $array_detalla_transporte = $transporte->select_transporte_detalle($id_transporte);
                $data['response_code']    = 200;
                $data['response_data']    = $array_detalle_paquete;
                $data['response_data_1']  = $array_detalla_transporte;
                $data['response_text']    = 'Se guardarón los datos con éxito';
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'No se guardarón los datos';
            }
        } else if ($id_operador != $select_transporte_operador->empleado_id) {
            $select_exist_transporte_operador =
            $transporte_empleado->select_exist_transporte_operador($id_operador);
            $array_exist = array(
                'id_exist'            => $select_exist_transporte_operador->id,
                'empleado_id_exist'   => $select_exist_transporte_operador->empleado_id,
                'transporte_id_exist' => $select_exist_transporte_operador->transporte_id,
                'id_transporte_input' => $id_transporte,
                'id_operador_input'   => $id_operador,
            );
            if ($transporte_empleado->update_asignacion_transporte_paquete($array_exist)) {
                if ($cross_over->insert_cross_over($json_tabla, $id_empleado, $id_socuersal,
                    $id_transporte, $id_operador)) {
                    $array_detalla_transporte = $transporte->select_transporte_detalle($id_transporte);
                    $data['response_code']    = 200;
                    $data['response_data']    = $array_detalle_paquete;
                    $data['response_data_1']  = $array_detalla_transporte;
                    $data['response_text']    = 'Se guardarón los datos con éxito';
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = 'No se guardarón los datos';
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = '';
            }
        }
        return response()->json($data);
    }

    public function show($id) {
        $data                    = array();
        $transporte              = new Transporte;
        $operadore               = new Empleado;
        $data['response_code']   = 200;
        $data['response_text']   = 'Datos de transporte';
        $data['response_data']   = $transporte->select_transporte_socuersal($id);
        $data['response_data_1'] = $operadore->select_empleado_operador($id);
        return response()->json($data);
    }

    public function edit($id) {
        $data    = array();
        $paquete = new Paquete;
        $valor   = $paquete->select_exit_paquete($id);
        $estatus = "";
        if (isset($valor->id)) {
            $estatus_paquete = $valor->estatus_paquete;
            if ($estatus_paquete == 1) {
                $estatus = "Paquete en espera de salir a ruta";
            } else if ($estatus_paquete == 3) {
                $estatus = "Paquete en sucursal intermedia a su antes de su entrega";
            }
            $data['response_code'] = 200;
            $data['response_text'] = 'Existe el código de barras';
            $data['response_data'] = $estatus;

        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'No existe el código de barras';
        }
        return response()->json($data);
    }

    public function create() {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}

}
