<?php

namespace App\Http\Controllers;

use App\Models\Socursal;
use App\Models\TipoTransporte;
use App\Models\Transporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransporteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data                     = array();
        $data['titulo']           = 'Gestion de Transportes | InteloPack';
        $data['work_area']        = 'transportes';
        $data['my_jquery']        = 'trasportes.js';
        $data['sucursales']       = Socursal::all()->where('estatus_socursal', '1');
        $data['tipo_transportes'] = TipoTransporte::all()->where('estatus_tipo_transporte', '1');
        return view('main')->with($data);
    }

    public function create() {
        $data                  = array();
        $transporte            = new Transporte;
        $select_transporte     = $transporte->select_transportes();
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos";
        $data['response_data'] = $select_transporte;
        echo json_encode($data);
    }

    public function store(Request $request) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'matricula_transporte' => 'required|nullable',
            'sucursal'             => 'required|nullable',
            'tipo_transporte'      => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $exist_matricula_transporte = Validator::make($request->all(), [
                'matricula_transporte' => 'unique:transportes',
            ]);
            if (!$exist_matricula_transporte->fails()) {
                $exist_no_eco_transporte = Validator::make($request->all(), [
                    'no_economico_transporte' => 'unique:transportes',
                ]);
                if (!$exist_no_eco_transporte->fails()) {
                    $transporte                          = new Transporte;
                    $transporte->matricula_transporte    = $request->input('matricula_transporte');
                    $transporte->socursal_id             = $request->input('sucursal');
                    $transporte->tipo_transporte_id      = $request->input('tipo_transporte');
                    $transporte->no_economico_transporte = $request->input('no_economico_transporte');
                    $transporte->marca_transporte        = $request->input('marca_transporte');
                    if ($transporte->save()) {
                        $id_trasnporte                    = $transporte->id;
                        $trasnporte_update                = Transporte::findOrFail($id_trasnporte);
                        $trasnporte_update->no_transporte = "T-" . $id_trasnporte;
                        $trasnporte_update->save();
                        $data['response_code'] = 200;
                        $data['response_text'] = 'Se guardarón con exito los datos';
                    } else {
                        $data['response_code'] = 500;
                        $data['response_text'] = 'No se guardarón con exito los datos';
                    }
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = "Ya se encuentra registrado ese
                        transporte con esa Número economico";
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = "Ya se encuentra registrado ese transporte con esa Matricula";
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);
    }

    public function edit($id) {
        $data                           = array();
        $transporte                     = Transporte::findOrFail($id);
        $transporte->estatus_transporte = 1;
        if ($transporte->save()) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con exito este regisro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "Se dio de baja con exito este regisro";
        }
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'matricula_transporte_editar' => 'required|nullable',
            'sucursal_editar'             => 'required|nullable',
            'tipo_transporte_editar'      => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $existe_matricula = Validator::make($request->all(), [
                'matricula_transporte_editar' => 'unique:transportes,matricula_transporte,' . $id,
            ]);
            if (!$existe_matricula->fails()) {
                $existe_no_economico = Validator::make($request->all(), [
                    'no_economico_transporte_editar' => 'unique:transportes,no_economico_transporte,'
                    . $id,
                ]);
                if (!$existe_no_economico->fails()) {
                    $transporte                          = Transporte::findOrFail($id);
                    $transporte->matricula_transporte    = $request->input('matricula_transporte_editar');
                    $transporte->socursal_id             = $request->input('sucursal_editar');
                    $transporte->tipo_transporte_id      = $request->input('tipo_transporte_editar');
                    $transporte->no_economico_transporte = $request->input('no_economico_transporte_editar');
                    $transporte->marca_transporte        = $request->input('marca_transporte_editar');
                    if ($transporte->save()) {
                        $data['response_code'] = 200;
                        $data['response_text'] = "Se guardaron los cambios con exito de este regisro";
                    } else {
                        $data['response_code'] = 500;
                        $data['response_text'] = "No se guardaron los cambios con exito de este regisro";
                    }
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = "Ya se encuentra registrado ese
                    transporte con esa Número economico";
                }

            } else {
                $data['response_code'] = 500;
                $data['response_text'] = "Ya se encuentra registrado ese transporte con esa Matricula";
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);
    }

    public function destroy($id) {
        $data                           = array();
        $transporte                     = Transporte::findOrFail($id);
        $transporte->estatus_transporte = 0;
        if ($transporte->save()) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con exito este regisro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "Se dio de baja con exito este regisro";
        }
        return response()->json($data);
    }

    public function show($id) {}
}
