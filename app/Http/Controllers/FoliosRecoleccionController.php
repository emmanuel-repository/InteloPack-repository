<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Socursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FoliosRecoleccionController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Folios de Recolección | InteloPack';
        $data['work_area'] = 'folios_recoleccion';
        $data['my_jquery'] = 'folios_recoleccion.js';
        return view('main')->with($data);
    }

    public function store(Request $request) {
        $data      = array();
        $validator = Validator::make($request->all(), [
            'cantidad_bar_code' => 'required|nullable',
        ]);
        if (!$validator->fails()) {
            $paquete             = new Paquete;
            $id_socursal         = Auth::user()->socursal_id;
            $socursal            = Socursal::findOrFail($id_socursal);
            $no_socursal         = $socursal->no_socursal;
            $no_socursal_substr  = explode('-', $no_socursal);
            $empleado_id         = str_pad(Auth::user()->id, 3, '0', STR_PAD_LEFT);
            $socursal_formateada = str_pad($no_socursal_substr[1], 3, '0', STR_PAD_LEFT);
            $array = array(
                'cantidad_bar_code' => $request->input('cantidad_bar_code'),
                'fecha_hoy'         => $request->input('fecha_hoy'),
                'fecha'             => $request->input('fecha'),
                'socursal_id'       => $socursal_formateada,
                'empleado_id'       => $empleado_id,
            );
            $array_data = $paquete->insert_bar_codes_recoleccion($array);
            if (count($array_data) > 0) {
                $data['response_code'] = 200;
                $data['response_text'] = 'Se generarón los códigos de barras';
                $data['response_data'] = $array_data;
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'No se generarón los códigos de barras';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisar el formulario';
        }
        return response()->json($data);
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}

    public function create() {}

}
