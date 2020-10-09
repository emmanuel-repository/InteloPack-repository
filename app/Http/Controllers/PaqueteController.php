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
 *Estatus de los Paquetes
 *
 * 1 -> Paquete creado o en espera de salida
 * 2 -> paquete en ruta a Almacen o para entregar a destinatario
 * 3 -> en socursal intermedia
 * 4 -> entregado
 * 5 -> Codigo de no de paquete que no se utilizado este se usa para
 * los codigos que se le generan a los repartiddores y se llevan en el caso de que
 * se quisiera recojer un paquete que un cliente quiera que se envie
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
            'socursal_id'           => Auth::user()->socursal_id,
            'empleado_id'           => Auth::user()->id,
            'created_at'            => date("Y-m-d H:i:s"),
            'updated_at'            => date("Y-m-d H:i:s"),
        );
        $array_cross_over = array(
            'hora_cross_over'  => $request->input('hora'),
            'fecha_cross_over' => $request->input('fecha'),
            'empleado_id'      => Auth::user()->id,
            'socursal_id'      => Auth::user()->socursal_id,
        );
        $insert = $paquete->insert($array_paquete, $array_cross_over);
        if ($insert > 0) {
            $array_data = array(
                'id_paquete'  => $insert,
                'no_sucursal' => $no_socursal_substr[1],
            );
            $data['response_code'] = 200;
            $data['response_text'] = "Si se guardaran los datos del paquete de cliente registrado";
            $data['response_data'] = $array_data;
        } else {
            $data['response_code'] = 200;
            $data['response_text'] = "No se guardaran los datos del paquete de cliente registrado";
        }
        return response()->json($data);
    }

    public function create_paquete_eventual(Request $request) {
        $data               = array();
        $paquete            = new Paquete;
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
            'socursal_id'           => Auth::user()->socursal_id,
            'empleado_id'           => Auth::user()->id,
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
        $insert = $paquete->insert_paquete_eventual($array_paquete, $array_eventual, 
            $array_cross_over);
        if ($insert > 0) {
            $array_data = array(
                'id_paquete'  => $insert,
                'no_sucursal' => $no_socursal_substr[1],
            );
            $data['response_code'] = 200;
            $data['response_text'] = "Si se guardaran los datos del paquete de cliente registrado";
            $data['response_data'] = $array_data;
        } else {
            $data['response_code'] = 200;
            $data['response_text'] = "No se guardaran los datos del paquete de cliente registrado";
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
        $id_socursal         = Auth::user()->socursal_id;
        $paquete             = Paquete::findOrFail($id);
        $paquete->no_paquete = $request->input('numero_codigo_barra');
        $nombre_completo     = $request->input('nombre_completo');
        $correo              = $request->input('correo');
        $no_rastreo          = $request->input('numero_codigo_barra');
        if ($paquete->save()) {
            $array_email = array(
                'nombre_completo'     => $nombre_completo,
                'numero_codigo_barra' => $no_rastreo,
            );
            Mail::to($correo)->send(new PaqueteMail($array_email));
            $data['response_code'] = 200;
            $data['response_text'] = "Se realizo la operacion";
        } else {
            $data['response_code'] = 550;
            $data['response_text'] = "No se realizo la operacion";
        }
        return response()->json($data);
    }

    public function create() {}

    public function edit($id) {}

    public function destroy($id) {}
}
