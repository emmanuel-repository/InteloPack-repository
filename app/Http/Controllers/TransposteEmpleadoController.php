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
     */

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data               = array();
        $data['titulo']     = 'Asignación de Transporte a Chófer | InteloPack';
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
                $data['response_text'] = 'Los datos de gurdaron con éxito';
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'No se gurdaron los datos';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el formulario';
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

    public function update(Request $request, $id) {
        $data                = array();
        $transporte_operador = new TransporteEmpleado;
        $array               = array(
            'id'            => $id,
            'operador_id'   => $request->input('operador_id'),
            'transporte_id' => $request->input('transporte_id'),
        );
        if ($transporte_operador->desasignacion_transporte_operador($array)) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con éxito este registro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No dio de baja este registro";
        }
        return response()->json($data);
    }

}
