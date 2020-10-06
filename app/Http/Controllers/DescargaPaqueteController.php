<?php

namespace App\Http\Controllers;

use App\Models\CrossOver;
use App\Models\Paquete;
use App\Models\Transporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DescargaPaqueteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data                = array();
        $data['titulo']      = 'Descarga de Paquetes | InteloPack';
        $data['work_area']   = 'descarga_paquetes';
        $data['my_jquery']   = 'descarga_paquetes.js';
        $data['transportes'] = Transporte::all()->where('estatus_transporte', 1)
            ->where('estatus_asignado_empleado', 1);
        return view('main')->with($data);
    }

    public function store(Request $request) {
        $data          = array();
        $cross_over    = new CrossOver;
        $json_tabla    = json_decode($request->input('json_tabla'));
        $id_transporte = $request->input('transporte');
        $id_empleado   = Auth::user()->id;
        $id_socuersal  = Auth::user()->socursal_id;
        if ($cross_over->insert_cross_over_descarga($json_tabla, $id_empleado, $id_socuersal,
            $id_transporte)) {
            $data['response_code'] = 200;
            $data['response_text'] = 'Se guardarón los datos con exito';
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
            $data['response_text'] = 'Existe el codigo de barras';
            $data['response_data'] = $estatus;

        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'No existe el codigo de barras';
        }
        return response()->json($data);
    }

    public function update(Request $request, $id) {}

    public function destroy($id) {}

    public function create() {}

    public function show($id) {}
}
