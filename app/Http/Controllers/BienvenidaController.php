<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BienvenidaController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Bienvenida | InteloPack';
        $data['work_area'] = 'bienvenida';
        $data['my_jquery'] = 'bienvenida.js';
        return view('main')->with($data);
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
