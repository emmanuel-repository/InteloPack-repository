<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PruebaController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        return view('prueba');
    }

    public function store(Request $request) {
        $data    = array();
        $paquete = new Paquete;
        $array   = array(
            'fecha'        => $request->input('fecha'),
            'socuersal_id' => Auth::user()->socursal_id,
            'empleado_id'  => Auth::user()->id,
        );
        
        if ($paquete->prueba_query($array)) {
            $data['response_code'] = 200;
            $data['response_text'] = "Se guardarón";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No se guardarón";
        }

        return response()->json($data);
    }

    public function create() {

    }

    public function show($id) {

    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id) {

    }
}
