<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
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
            $paquete           = new Paquete;
            $cantidad_bar_code = $request->input('cantidad_bar_code');
            $fecha             = $request->input('fecha');
            $empleado_id       = Auth::user()->id;
            $array_data        = $paquete->insert_bar_codes_recoleccion($cantidad_bar_code,
                $fecha, $empleado_id);
            if (count($array_data) > 0) {
                $data['response_code'] = 200;
                $data['response_text'] = 'Se generarón los codigos de Barras';
                $data['response_data'] = $array_data;
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = 'No se generarón los codigos de Barras';
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = 'Favor de revisa el Formulario';
        }
        return response()->json($data);
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}

    public function create() {}

}
