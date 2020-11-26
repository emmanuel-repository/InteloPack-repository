<?php

namespace App\Http\Controllers;

use App\Mail\PaqueteMail;
use App\Models\Cliente;
use App\Models\Paquete;
use App\Models\Socursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
/*
 *Estatus de los Paquetes:
 * 1 -> Paquete creado o en espera de salida
 * 2 -> paquete en ruta a Almacen o para entregar a destinatario
 * 3 -> en socursal intermedia
 * 4 -> entregado
 * 5 -> Codigo de no de paquete que no se utilizado este se usa para
 * los codigos que se le generan a los repartiddores y se llevan en el caso de que
 * se quisiera recojer un paquete que un cliente quiera que se envie
 *
 * ALTER TABLE paquetes AUTO_INCREMENT =1000000;
 * */

class PaqueteController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $id_empleado             = Auth::user()->socursal_id;
        $data                    = array();
        $data['titulo']          = 'Paquete | InteloPack';
        $data['work_area']       = 'paquete';
        $data['my_jquery']       = 'paquete.js';
        $data['clientes']        = Cliente::all()->where('estatus_cliente', '1');
        $data['sucursal_salida'] = Socursal::findOrFail($id_empleado);
        return view('main')->with($data);
    }

    public function store(Request $request) {
        $data               = array();
        $paquete            = new Paquete;
        $id_empleado        = Auth::user()->id;
        $id_socursal        = Auth::user()->socursal_id;
        $socursal           = Socursal::findOrFail($id_socursal);
        $no_socursal        = $socursal->no_socursal;
        $no_socursal_substr = explode('-', $no_socursal);
        $array_paquete      = array(
            'estado_destino'        => $request->input('estado_destino'),
            'municipio_destino'     => $request->input('municipio_destino'),
            'codigo_postal_destino' => $request->input('codigo_postal_destino'),
            'colonia_destino'       => $request->input('colonia_destino'),
            'calle_destino'         => $request->input('calle_destino'),
            'no_exterior_destino'   => $request->input('no_exterior_destino'),
            'no_interior_destino'   => $request->input('no_interior_destino'),
            'cliente_id'            => $request->input('razon_social_cliente'),
            'socursal_id'           => $id_socursal,
            'empleado_id'           => $id_empleado,
        );
        $array_cross_over = array(
            'hora_cross_over'  => $request->input('hora'),
            'fecha_cross_over' => $request->input('fecha_hoy'),
            'empleado_id'      => $id_empleado,
            'socursal_id'      => $id_socursal,
        );
        $array_consecutivo = array(
            'empleado_id' => str_pad($id_empleado, 3, '0', STR_PAD_LEFT),
            'socursal_id' => str_pad($no_socursal_substr[1], 3, '0', STR_PAD_LEFT),
            'fecha'       => $request->input('fecha'),
            'fecha_hoy'   => $request->input('fecha_hoy'),
        );
        $insert = $paquete->insert($array_paquete, $array_cross_over, $array_consecutivo);
        if ($insert != '') {
            $data['response_code'] = 200;
            $data['response_text'] = "Si se guardarón los datos del paquete con éxito";
            $data['response_data'] = $insert;

        } else {
            $data['response_code'] = 200;
            $data['response_text'] = "No se guardarón los datos del paquete";
        }
        return response()->json($data);
    }

    public function create_paquete_eventual(Request $request) {
        $data               = array();
        $paquete            = new Paquete;
        $id_empleado        = Auth::user()->id;
        $id_socursal        = Auth::user()->socursal_id;
        $socursal           = Socursal::findOrFail($id_socursal);
        $no_socursal        = $socursal->no_socursal;
        $no_socursal_substr = explode('-', $no_socursal);
        $array_paquete      = array(
            'estado_destino'        => $request->input('estado_destino'),
            'municipio_destino'     => $request->input('municipio_destino'),
            'codigo_postal_destino' => $request->input('codigo_postal_destino'),
            'colonia_destino'       => $request->input('colonia_destino'),
            'calle_destino'         => $request->input('calle_destino'),
            'no_exterior_destino'   => $request->input('no_exterior_destino'),
            'no_interior_destino'   => $request->input('no_interior_destino'),
            'cliente_id'            => $request->input('razon_social_cliente'),
            'socursal_id'           => $id_socursal,
            'empleado_id'           => $id_empleado,
        );
        $array_cross_over = array(
            'hora_cross_over'  => $request->input('hora'),
            'fecha_cross_over' => $request->input('fecha'),
            'empleado_id'      => Auth::user()->id,
            'socursal_id'      => Auth::user()->socursal_id,
        );
        $array_eventual = array(
            'nombre_eventual'        => $request->input('nombre'),
            'apellido_1_eventual'    => $request->input('apellido_1'),
            'apellido_2_eventual'    => $request->input('apellido_2'),
            'razon_social'           => $request->input('razon_social'),
            'rfc_eventual'           => $request->input('rfc_cliente'),
            'estado_eventual'        => $request->input('estado_cliente'),
            'municipio_eventual'     => $request->input('municipio_cliente'),
            'codigo_postal_eventual' => $request->input('codigo_postal'),
            'colonia_eventual'       => $request->input('colonia_cliente'),
            'calle_eventual'         => $request->input('calle_cliente'),
            'no_exterior_eventual'   => $request->input('no_exterior_cliente'),
            'no_interior_eventual'   => $request->input('no_interior_cliente'),
            'correo_eventual'        => $request->input('correo_cliente'),
            'telefono_1_evnetual'    => $request->input('telefono_1_cliente'),
            'telefono_2_eventual'    => $request->input('telefono_2_cliente'),
        );
        $array_consecutivo = array(
            'empleado_id' => str_pad($id_empleado, 3, '0', STR_PAD_LEFT),
            'socursal_id' => str_pad($no_socursal_substr[1], 3, '0', STR_PAD_LEFT),
            'fecha'       => $request->input('fecha'),
            'fecha_hoy'   => $request->input('fecha_hoy'),
        );
        $insert = $paquete->insert_paquete_eventual($array_paquete, $array_eventual,
            $array_cross_over, $array_consecutivo);
        if ($insert != '') {
            $data['response_code'] = 200;
            $data['response_text'] = "Si se guardarón los datos del paquete con éxito";
            $data['response_data'] = $insert;
        } else {
            $data['response_code'] = 200;
            $data['response_text'] = "No se guardarón los datos del paquete";
        }
        return response()->json($data);
    }

    public function show($id) {
        $array                 = array();
        $select_cliente        = Cliente::findOrFail($id);
        $data['response_code'] = 200;
        $data['response_text'] = "Si hay datos de Cliente";
        $data['response_data'] = $select_cliente;
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        $data                = array();
        $nombre_completo     = $request->input('nombre_completo');
        $correo              = $request->input('correo');
        $no_rastreo          = $request->input('numero_codigo_barra');
        $array_email         = array(
            'nombre_completo'     => $nombre_completo,
            'numero_codigo_barra' => $no_rastreo,
        );
        Mail::to($correo)->send(new PaqueteMail($array_email));
        $data['response_code'] = 200;
        $data['response_text'] = "Si se envio el correo a cliente";
        return response()->json($data);
    }

    public function create() {}

    public function edit($id) {}

    public function destroy($id) {}
}
