<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Socursal;
use App\Models\TipoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data                   = array();
        $data['titulo']         = 'Gestion de Empleados | InteloPack';
        $data['work_area']      = 'empleado';
        $data['my_jquery']      = 'empleado.js';
        $data['sucursales']     = Socursal::all();
        $data['tipos_empleado'] = TipoEmpleado::all();
        return view('main')->with($data);
    }

    public function create() {
        $array                 = array();
        $empleado              = new Empleado;
        $select_empleado       = $empleado->select_empleados();
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos6";
        $data['response_data'] = $select_empleado;
        return response()->json($data);
    }

    public function store(Request $request) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'nombre_empleado'    => 'required|nullable',
            'apellido1_empleado' => 'required|nullable',
            'apellido2_empleado' => 'required|nullable',
            'email'              => 'required|nullable',
            'password_empleado'  => 'required|nullable',
            'tipo_empleado'      => 'required|nullable',
            'sucursal'           => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $existe_email = Validator::make($request->all(), [
                'email' => 'unique:empleados',
            ]);
            if (!$existe_email->fails()) {
                $empleado                      = new Empleado;
                $empleado->nombre_empleado     = $request->input('nombre_empleado');
                $empleado->apellido_1_empleado = $request->input('apellido1_empleado');
                $empleado->apellido_2_empleado = $request->input('apellido2_empleado');
                $empleado->email               = $request->input('email');
                $empleado->password            = bcrypt($request->input('password_empleado'));
                $empleado->tipo_empleado_id    = $request->input('tipo_empleado');
                $empleado->socursal_id         = $request->input('sucursal');
                if ($empleado->save()) {
                    $id_empleado = $empleado->id;
                    $empleado_update = Empleado::findOrFail($id_empleado);
                    $empleado_update->no_empleado = 'EMP-' . $id_empleado;
                    $empleado_update->save();
                    $data['response_code'] = 200;
                    $data['response_text'] = 'Se guardarón con exito los datos';
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = 'No se guardarón con exito los datos';
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'Ya se encustra registrada esa correo en algún otro Empleado';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);
    }

    public function edit($id) {
        $data                       = array();
        $empleado                   = Empleado::findOrFail($id);
        $empleado->estatus_empleado = 1;
        if ($empleado->save()) {
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
            'nombre_empleado_editar'    => 'required|nullable',
            'apellido1_empleado_editar' => 'required|nullable',
            'apellido2_empleado_editar' => 'required|nullable',
            'email_empleado_editar'     => 'required|nullable',
            'tipo_empleado_editar'      => 'required|nullable',
            'sucursal_editar'           => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $existe_email = Validator::make($request->all(), [
                'email_empleado_editar' => 'unique:empleados,email,' . $id,
            ]);
            if (!$existe_email->fails()) {
                $empleado                      = Empleado::findOrFail($id);
                $empleado->nombre_empleado     = $request->input('nombre_empleado_editar');
                $empleado->apellido_1_empleado = $request->input('apellido1_empleado_editar');
                $empleado->apellido_2_empleado = $request->input('apellido2_empleado_editar');
                $empleado->email               = $request->input('email_empleado_editar');
                $empleado->tipo_empleado_id    = $request->input('tipo_empleado_editar');
                $empleado->socursal_id         = $request->input('sucursal_editar');
                $empty_password   = empty($request->input('password_empleado_editar'));
                $is_null_password = is_null($request->input('password_empleado_editar'));
                $password_actual  = $empleado->password;
                if ($empty_password || $is_null_password) {
                    $empleado->password = $password_actual;
                } else {
                    $empleado->password = bcrypt($request->input('password_empleado_editar'));
                }
                if ($empleado->save()) {
                    $data['response_code'] = 200;
                    $data['response_text'] = "Se guardaron los cambios con exito de este regisro";
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = "No se guardaron los cambios con exito de este regisro";
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'Ya se encustra registrada esa correo en algún otro Empleado';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);

    }

    public function destroy($id) {
        $data                       = array();
        $empleado                   = Empleado::findOrFail($id);
        $empleado->estatus_empleado = 0;
        if ($empleado->save()) {
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
