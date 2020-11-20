<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Gestion de Clientes | InteloPack';
        $data['work_area'] = 'cliente';
        $data['my_jquery'] = 'cliente.js';
        return view('main')->with($data);
    }

    public function create() {
        $array                 = array();
        $cliente               = new Cliente;
        $select_cliente        = $cliente::all();
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos";
        $data['response_data'] = $select_cliente;
        return response()->json($data);
    }

    public function store(Request $request) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'nombre_cliente'        => 'required|nullable',
            'apellido1_cliente'     => 'required|nullable',
            'apellido2_cliente'     => 'required|nullable',
            'razon_social_cliente'  => 'required|nullable',
            'rfc_cliente'           => 'required|nullable',
            'estado_cliente'        => 'required|nullable',
            'municipio_cliente'     => 'required|nullable',
            'codigo_postal_cliente' => 'required|nullable',
            'colonia_cliente'       => 'required|nullable',
            'calle_cliente'         => 'required|nullable',
            'no_exterior_cliente'   => 'required|nullable',
            'email_cliente'         => 'required|nullable',
            'telefono1_cliente'     => 'required|nullable'
        ]);
        if (!$validator->fails()) {
            $exist_razon_social = Validator::make($request->all(), [
                'razon_social_cliente' => 'unique:clientes',
            ]);
            if (!$exist_razon_social->fails()) {
                $cliente                        = new Cliente;
                $cliente->nombre_cliente        = $request->input('nombre_cliente');
                $cliente->apellido_1_cliente    = $request->input('apellido1_cliente');
                $cliente->apellido_2_cliente    = $request->input('apellido2_cliente');
                $cliente->razon_social_cliente  = $request->input('razon_social_cliente');
                $cliente->rfc_cliente           = $request->input('rfc_cliente');
                $cliente->estado_cliente        = $request->input('estado_cliente');
                $cliente->municipio_cliente     = $request->input('municipio_cliente');
                $cliente->codigo_postal_cliente = $request->input('codigo_postal_cliente');
                $cliente->colonia_cliente       = $request->input('colonia_cliente');
                $cliente->calle_cliente         = $request->input('calle_cliente');
                $cliente->no_exterior_cliente   = $request->input('no_exterior_cliente');
                $cliente->no_interior_cliente   = $request->input('no_interior_cliente');
                $cliente->email_cliente         = $request->input('email_cliente');
                $cliente->telefono_1_cliente    = $request->input('telefono1_cliente');
                $cliente->telefono_2_cliente    = $request->input('telefono2_cliente');
                $cliente->empleado_id           = Auth::user()->id;
                if ($cliente->save()) {
                    $data['response_code'] = 200;
                    $data['response_text'] = 'Se guardarón con éxito los datos';
                } else {
                    $data['response_code'] = 200;
                    $data['response_text'] = 'No se guardarón los datos';
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'Ya se encuentra registrado un Cliente con esa razón social';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisar el formulario';
        }
        return response()->json($data);
    }

    public function edit($id) {
        $data                     = array();
        $cliente                  = Cliente::findOrFail($id);
        $cliente->estatus_cliente = 1;
        if ($cliente->save()) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con éxito este registro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No dio de baja este registro";
        }
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'nombre_cliente_editar'        => 'required|nullable',
            'apellido1_cliente_editar'     => 'required|nullable',
            'apellido2_cliente_editar'     => 'required|nullable',
            'razon_social_cliente_editar'  => 'required|nullable',
            'rfc_cliente_editar'           => 'required|nullable',
            'estado_cliente_editar'        => 'required|nullable',
            'municipio_cliente_editar'     => 'required|nullable',
            'codigo_postal_cliente_editar' => 'required|nullable',
            'colonia_cliente_editar'       => 'required|nullable',
            'calle_cliente_editar'         => 'required|nullable',
            'no_exterior_cliente_editar'   => 'required|nullable',
            'email_cliente_editar'         => 'required|nullable',
            'telefono1_cliente_editar'     => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $exist_razon_social = Validator::make($request->all(), [
                'razon_social_cliente_editar' => 'unique:clientes,razon_social_cliente,' . $id,
            ]);
            if (!$exist_razon_social->fails()) {
                $cliente                        = Cliente::findOrFail($id);
                $cliente->nombre_cliente        = $request->input('nombre_cliente_editar');
                $cliente->apellido_1_cliente    = $request->input('apellido1_cliente_editar');
                $cliente->apellido_2_cliente    = $request->input('apellido2_cliente_editar');
                $cliente->razon_social_cliente  = $request->input('razon_social_cliente_editar');
                $cliente->rfc_cliente           = $request->input('rfc_cliente_editar');
                $cliente->estado_cliente        = $request->input('estado_cliente_editar');
                $cliente->municipio_cliente     = $request->input('municipio_cliente_editar');
                $cliente->codigo_postal_cliente = $request->input('codigo_postal_cliente_editar');
                $cliente->colonia_cliente       = $request->input('colonia_cliente_editar');
                $cliente->calle_cliente         = $request->input('calle_cliente_editar');
                $cliente->no_exterior_cliente   = $request->input('no_exterior_cliente_editar');
                $cliente->no_interior_cliente   = $request->input('no_interior_cliente_editar');
                $cliente->email_cliente         = $request->input('email_cliente_editar');
                $cliente->telefono_1_cliente    = $request->input('telefono1_cliente_editar');
                $cliente->telefono_2_cliente    = $request->input('telefono2_cliente_editar');
                $cliente->empleado_id           = Auth::user()->id;
                if ($cliente->save()) {
                    $data['response_code'] = 200;
                    $data['response_text'] = "Se guardarón los cambios con éxito";
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = "No se guardarón los cambios de este registro";
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'Ya se encuentra registrado un cliente con esa razón social';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el formulario';
        }
        return response()->json($data);

    }

    public function destroy($id) {
        $data                     = array();
        $cliente                  = Cliente::findOrFail($id);
        $cliente->estatus_cliente = 0;
        if ($cliente->save()) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con éxito este registro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No dio de baja este registro";
        }
        return response()->json($data);
    }

    public function show($id) {}
}
