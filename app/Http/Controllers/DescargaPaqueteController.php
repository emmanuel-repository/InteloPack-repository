<?php

namespace App\Http\Controllers;

use App\Models\CrossOver;
use App\Models\Paquete;
use App\Models\Socursal;
use App\Models\Transporte;
use App\Models\TransporteEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DescargaPaqueteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data               = array();
        $data['titulo']     = 'Descarga de Paquetes | InteloPack';
        $data['work_area']  = 'descarga_paquetes';
        $data['my_jquery']  = 'descarga_paquetes.js';
        $data['sucursales'] = Socursal::all()->where('estatus_socursal', 1);
        // $data['transportes'] = Transporte::all()->where('estatus_transporte', 1)
        //     ->where('estatus_asignado_empleado', 1);
        return view('main')->with($data);
    }

    public function store(Request $request) {
        $data          = array();
        $cross_over    = new CrossOver;
        $json_tabla    = json_decode($request->input('json_tabla'));
        $id_transporte = $request->input('transporte');
        $id_operador   = $request->input('id_operador');
        $id_empleado   = Auth::user()->id;
        $id_socuersal  = Auth::user()->socursal_id;
        if ($cross_over->insert_cross_over_descarga($json_tabla, $id_empleado, $id_socuersal,
            $id_transporte, $id_operador)) {
            $data['response_code'] = 200;
            $data['response_text'] = 'Se guardarón los datos con éxito';
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'No se guardarón los datos';
        }
        return response()->json($data);
    }

    public function edit($id) {
        $data    = array();
        $paquete = new Paquete;
        $valor   = $paquete->select_exit_paquete_descarga($id);
        $estatus = "Paquete llegando de ruta";
        if (isset($valor->id)) {
            $data['response_code'] = 200;
            $data['response_text'] = 'Existe el código de barras';
            $data['response_data'] = $estatus;
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'No existe el código de barras';
        }
        return response()->json($data);
    }

    public function show($id) {
        $array                 = array();
        $empleado              = new TransporteEmpleado;
        $select_empleado      = $empleado->select_transporte_operador_nombre($id);
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos";
        $data['response_data'] = $select_empleado;
        return response()->json($data);
    }

    public function update(Request $request, $id) {}

    public function destroy($id) {
        $array                 = array();
        $transporte            = new Transporte;
        $select_transporte      = $transporte->select_transporte_socuersal_descarga($id);
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos";
        $data['response_data'] = $select_transporte;
        return response()->json($data);
    }

    public function create() {}
}
