<?php

namespace App\Http\Controllers;

use App\Models\Socursal;
use App\Models\TransporteEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransposteEmpleadoController extends Controller {

    /**
     * Empleado estatus_asignado_transporte = 1 es que ya se encuentra asignado a un
     * transporte.
     * Transporte  estatus_asignado_empleado = 1 es que ya se encuentra un empleado asignado
     * .
     */

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data               = array();
        $data['titulo']     = 'Asignacion de Transporte a Chofer | InteloPack';
        $data['work_area']  = 'transporte_empleado';
        $data['my_jquery']  = 'transporte_empleado.js';
        $data['sucursales'] = Socursal::all()->where('estatus_socursal', 1);
        return view('main')->with($data);
    }

    public function create() {
        $array                       = array();
        $transporte_empleado         = new TransporteEmpleado;
        $select_transporte_empleados = $transporte_empleado->select_transporte_empleados();
        $data['response_code']       = 200;
        $data['response_text']       = "Si hay datos";
        $data['response_data']       = $select_transporte_empleados;
        return response()->json($data);
    }

    public function store(Request $request) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'chofer'     => 'required|nullable',
            'transporte' => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $transporte_empleado = new TransporteEmpleado;
            $id_chofer           = $request->input('chofer');
            $id_transporte       = $request->input('transporte');
            if ($transporte_empleado->insert_transporte_empleado($id_chofer, $id_transporte)) {
                $data['response_code'] = 200;
                $data['response_text'] = 'Los datos de gurdaron con Exito';
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'No se gurdaron los datos con Exito';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);
    }

    public function show($id) {
        $data                  = array();
        $empleado              = new TransporteEmpleado;
        $data['response_code'] = 200;
        $data['response_text'] = 'Datos de empleado';
        $data['response_data'] = $empleado->select_empleado_choferes($id);
        return response()->json($data);
    }

    public function edit($id) {
        $data                  = array();
        $transporte            = new TransporteEmpleado;
        $data['response_code'] = 200;
        $data['response_text'] = 'Datos de Transporte';
        $data['response_data'] = $transporte->select_transportes($id);
        return response()->json($data);

    }

    public function destroy($id) {}

    public function update(Request $request, $id) {}

}
