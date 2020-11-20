<?php

namespace App\Http\Controllers;

use App\Models\Socursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocursalController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Gestión de Sucursales | InteloPack';
        $data['work_area'] = 'socursal';
        $data['my_jquery'] = 'socursal.js';
        return view('main')->with($data);
    }

    public function create() {
        $array                 = array();
        $socursal              = new Socursal;
        $select_socursales     = $socursal::all();
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos";
        $data['response_data'] = $select_socursales;
        return response()->json($data);
    }

    public function store(Request $request) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'nombre_socursal'    => 'required|nullable',
            'estado_socursal'    => 'required|nullable',
            'municipio_socursal' => 'required|nullable',
            'codigo_postal'      => 'required|nullable',
            'colonia_socursal'   => 'required|nullable',
            'calle_socursal'     => 'required|nullable',
            'no_exterior'        => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $validator_nombre_socursal = Validator::make($request->all(), [
                'nombre_socursal' => 'unique:socursals',
            ]);
            if (!$validator_nombre_socursal->fails()) {
                $socursal                         = new Socursal;
                $socursal->nombre_socursal        = $request->input('nombre_socursal');
                $socursal->estado_socursal        = $request->input('estado_socursal');
                $socursal->municipio_socursal     = $request->input('municipio_socursal');
                $socursal->codigo_postal_socursal = $request->input('codigo_postal');
                $socursal->colonia_socursal       = $request->input('colonia_socursal');
                $socursal->calle_socursal         = $request->input('calle_socursal');
                $socursal->no_exterior_socursal   = $request->input('no_exterior');
                $socursal->no_interior_socursal   = $request->input('no_interior');
                $socursal->estatus_socursal       = 1;
                if ($socursal->save()) {
                    $id_socursal                  = $socursal->id;
                    $socursal_update              = Socursal::findOrFail($id_socursal);
                    $socursal_update->no_socursal = "SUC-" . $id_socursal;
                    $socursal_update->save();
                    $data['response_code'] = 200;
                    $data['response_text'] = 'Se guardarón con éxito los datos';
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = 'No se guardarón los datos';
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'Ya se encuestra registrada esa Sucursal con el mismo nombre';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el formulario';
        }
        return response()->json($data);
    }

    public function edit($id) {
        $data                       = array();
        $socursal                   = Socursal::findOrFail($id);
        $socursal->estatus_socursal = 1;
        if ($socursal->save()) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con éxito este registro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No dio de baja este registro";
        }
        return response()->json($data);
    }

    public function destroy($id) {
        $data                       = array();
        $socursal                   = Socursal::findOrFail($id);
        $socursal->estatus_socursal = 0;
        if ($socursal->save()) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se dio de baja con éxito este registro";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No dio de baja este registro";
        }
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nombre_socursal_editar'    => 'required|nullable',
            'estado_socursal_editar'    => 'required|nullable',
            'municipio_socursal_editar' => 'required|nullable',
            'codigo_postal_editar'      => 'required|nullable',
            'colonia_socursal_editar'   => 'required|nullable',
            'calle_socursal_editar'     => 'required|nullable',
            'no_exterior_editar'        => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $existe_nombre_socursal = Validator::make($request->all(), [
                'nombre_socursal_editar' => 'unique:socursals, nombre_socursal,' . $id,
            ]);
            if (!$existe_nombre_socursal->fails()) {
                $data                             = array();
                $socursal                         = Socursal::findOrFail($id);
                $socursal->nombre_socursal        = $request->input('nombre_socursal_editar');
                $socursal->estado_socursal        = $request->input('estado_socursal_editar');
                $socursal->municipio_socursal     = $request->input('municipio_socursal_editar');
                $socursal->codigo_postal_socursal = $request->input('codigo_postal_editar');
                $socursal->colonia_socursal       = $request->input('colonia_socursal_editar');
                $socursal->calle_socursal         = $request->input('calle_socursal_editar');
                $socursal->no_exterior_socursal   = $request->input('no_exterior_editar');
                $socursal->no_interior_socursal   = $request->input('no_interior_editar');
                if ($socursal->save()) {
                    $data['response_code'] = 200;
                    $data['response_text'] = "Se guardarón los cambios con éxito de este registro";
                } else {
                    $data['response_code'] = 500;
                    $data['response_text'] = "No se guardaron los cambios con exito de este registro";
                }
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = "Ya se encuentra registrado ese nombre con otra Sucursal";
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);

        return response()->json($data);
    }

    public function show($id) {}
}
