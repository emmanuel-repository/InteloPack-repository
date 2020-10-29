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
        $json_tabla                 = json_decode($request->input('json_tabla'));
        $id_transporte              = $request->input('transporte');
        $id_operador                = $request->input('operador');
        $id_empleado                = Auth::user()->id;
        $id_socuersal               = Auth::user()->socursal_id;
        $select_transporte_operador = $transporte_empleado->select_transporte_operador($id_transporte);
        if ($select_transporte_operador->empleado_id == $id_operador) {
            if ($cross_over->insert_cross_over($json_tabla, $id_empleado, $id_socuersal,
                $id_transporte, $id_operador)) {
                $data['response_code'] = 200;
                $data['response_text'] = 'Se guardarón los datos con exito';
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'No se guardarón los datos';
            }
        } else {
            $select_exist_transporte = $transporte_empleado->select_exist_transporte_operador($id_operador);
            if (!is_null($select_exist_transporte)) {
                $array = array(
                    'id_tranporte_empleado'  => $select_exist_transporte->id,
                    'id_empleado_cambio'     => $select_exist_transporte->empleado_id,
                    'id_transporte_cambio'   => $select_exist_transporte->transporte_id,
                    'id_transporte_anterior' => $id_transporte,
                    'id_operador_anterior'   => $id_operador,
                );
                if ($cross_over->update_asignacion_transporte($array)) {
                    if ($cross_over->insert_cross_over($json_tabla, $id_empleado, $id_socuersal,
                        $id_transporte, $id_operador)) {
                        $data['response_code'] = 200;
                        $data['response_text'] = 'Se guardarón los datos con exito';
                    } else {
                        $data['response_code'] = 500;
                        $data['response_text'] = 'No se guardarón los datos';
                    }
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = 'No se guardarón los datos';
                }
            } else {
                // solo hay que realizar el solo el cambio de estatus;
                dd($transporte->update_nueva_asignacion_tranporte_empleado());
                // if($transporte_empleado->){

                // }
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
                $estatus = "Paquete en socursal intermedia a su antes de su entrega";
            }
            $data['response_code'] = 200;
            $data['response_text'] = 'Existe el codigo de barras';
            $data['response_data'] = $estatus;

        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'No existe el codigo de barras';
        }
        return response()->json($data);
    }

    public function create() {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}

}
