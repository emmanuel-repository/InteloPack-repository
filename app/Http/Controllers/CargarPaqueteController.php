<?php

namespace App\Http\Controllers;

use App\Models\CrossOver;
use App\Models\Paquete;
use App\Models\Socursal;
use App\Models\Transporte;
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
        $data          = array();
        $cross_over    = new CrossOver;
        $json_tabla    = json_decode($request->input('json_tabla'));
        $id_transporte = $request->input('transporte');
        $id_empleado   = Auth::user()->id;
        $id_socuersal  = Auth::user()->socursal_id;
        if ($cross_over->insert_cross_over($json_tabla, $id_empleado, $id_socuersal,
            $id_transporte)) {
            $data['response_code'] = 200;
            $data['response_text'] = 'Se guardarón los datos con exito';
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'No se guardarón los datos';
        }
        return response()->json($data);
    }

    public function show($id) {
        $data                  = array();
        $transporte            = new Transporte;
        $data['response_code'] = 200;
        $data['response_text'] = 'Datos de transporte';
        $data['response_data'] = $transporte->select_transporte_socuersal($id);
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
