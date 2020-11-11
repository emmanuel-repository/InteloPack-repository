<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoporteController extends Controller {
    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Soporte | InteloPack';
        $data['work_area'] = 'soporte';
        $data['my_jquery'] = 'soporte.js';
        return view('main')->with($data);
    }

    public function create() {}

    public function store(Request $request) {
        $data                  = array();
        $data['response_code'] = 200;
        $data['response_text'] = 'Se envio el mensaje';
        return response()->json($data);
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
