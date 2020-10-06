<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;

class GestionPaqueteriaController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $data              = array();
        $data['titulo']    = 'Gestion de Paqueteria | InteloPack';
        $data['work_area'] = 'gestion_paqueteria';
        $data['my_jquery'] = 'gestion_paqueteria.js';
        return view('main')->with($data);
    }

    public function create() {
        $array                 = array();
        $paquete               = new Paquete;
        $select_paquete        = $paquete::all()->where('estatus_paquete', '<>', '4');
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos";
        $data['response_data'] = $select_paquete;
        return response()->json($data);
    }

    public function store(Request $request) {
        $data        = array();
        $paquete     = new Paquete;
        $id_eventual = $request->input('id_eventual');
        $id_cliente  = $request->input('id_cliente');
        $id_paquete  = $request->input('id_paquete');
        if (!is_null($id_cliente)) {
            $select_paquete        = $paquete->select_paquete($id_paquete);
            $data['response_code'] = 200;
            $data['response_text'] = "Si hay datos de Privada";
            $data['response_data'] = $select_paquete;
        } else {
            $select_paquete_eventual = $paquete->select_paquete_eventual($id_paquete);
            $data['response_code']   = 200;
            $data['response_text']   = "Si hay datos de Privada";
            $data['response_data']   = $select_paquete_eventual;
        }
        return response()->json($data);
    }

    public function show($id) {
        $data           = array();
        $paquete        = new Paquete;
        $select_paquete = $paquete->select_bar_code($id);
        if (!is_null($select_paquete)) {
            if ($select_paquete->estatus_paquete != 3) {
                $data['response_code'] = 200;
                $data['response_text'] = "Si hay datos de Privada";
                $data['response_data'] = $select_paquete->no_paquete;
            } else {
                $data['response_code'] = 500;
                $data['response_text'] = "Ese paquete ya no se le puede recuperar codigo de
                    barra ya que fue entregado a su destinatario";
            }
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "Ese numero del Codigo de barra no existe,
                favor de ingresar un numero valido";
        }
        return response()->json($data);
    }

    public function update(Request $request, $id) {}

    public function edit($id) {}

    public function destroy($id) {}
}
