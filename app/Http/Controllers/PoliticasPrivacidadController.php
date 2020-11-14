<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliticasPrivacidadController extends Controller {

    public function index() {
        $data              = array();
        $data['titulo']    = 'Politicas de Privacidad | InteloPack';
        $data['my_jquery'] = 'politicas.js';
        return view('politicas_privacidad')->with($data);
    }

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
