<?php

namespace App\Http\Controllers;

use App\Mail\PaqueteMail;
use App\Models\Cliente;
use App\Models\Paquete;
use App\Models\Socursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaqueteRepartidorController extends Controller {

    public function __construct() {
        $this->middleware('auth:empleado');
    }

    public function index() {
        $id_empleado             = Auth::user()->socursal_id;
        $data                    = array();
        $data['titulo']          = 'Paquetes Repartidor| InteloPack';
        $data['work_area']       = 'paquete_repartidor';
        $data['my_jquery']       = 'paquete_repartidor.js';
        $data['clientes']        = Cliente::all()->where('estatus_cliente', '1');
        $data['sucursal_salida'] = Socursal::findOrFail($id_empleado);
        return view('main')->with($data);
    }

    public function update(Request $request, $id) {
        $data          = array();
        $paquete       = new Paquete;
        $nombre        = $request->input('nombre');
        $apellido_1    = $request->input('apelido_1');
        $apellido_2    = $request->input('apellido_2');
        $correo        = $request->input('correo');
        $array_paquete = array(
            'hora_cross_over'       => $request->input('hora'),
            'fecha_cross_over'      => $request->input('fecha'),
            'bar_code'              => $request->input('bar_code'),
            'estado_destino'        => $request->input('estado_destino'),
            'municipio_destino'     => $request->input('municipio_destino'),
            'codigo_postal_destino' => $request->input('codigo_postal_destino'),
            'colonia_destino'       => $request->input('colonia_destino'),
            'calle_destino'         => $request->input('calle_destino'),
            'no_exterior_destino'   => $request->input('no_exterior_destino'),
            'no_interior_destino'   => $request->input('no_interior_destino'),
            'razon_social'          => $request->input('razon_social'),
            'socursal_id'           => Auth::user()->socursal_id,
            'empleado_id'           => Auth::user()->id,
        );
        if ($paquete->update_paquete_repartidor($array_paquete)) {
            $array_email = array(
                'nombre_completo'     => $nombre . ' ' . $apellido_1 . ' ' . $apellido_2,
                'numero_codigo_barra' => $request->input('bar_code')
            );
            Mail::to($correo)->send(new PaqueteMail($array_email));
            $data['response_code'] = 200;
            $data['response_text'] = "Se realizo la operacion";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No se realizo la operacion";
        }
        return response()->json($data);
    }

    public function store(Request $request) {
        $data          = array();
        $paquete       = new Paquete;
        $nombre        = $request->input('nombre');
        $apellido_1    = $request->input('apelido_1');
        $apellido_2    = $request->input('apellido_2');
        $correo        = $request->input('correo');
        $array_paquete = array(
            'bar_code'              => $request->input('bar_code'),
            'fecha_cross_over'      => $request->input('fecha'),
            'hora_cross_over'       => $request->input('hora'),
            'nombre'                => $request->input('nombre'),
            'apellido_1'            => $request->input('apellido_1'),
            'apellido_2'            => $request->input('apellido_2'),
            'razon_social'          => $request->input('razon_social'),
            'rfc'                   => $request->input('rfc'),
            'estado'                => $request->input('estado'),
            'municipio'             => $request->input('municipio'),
            'codigo_postal'         => $request->input('codigo_postal'),
            'colonia'               => $request->input('colonia'),
            'calle'                 => $request->input('calle'),
            'no_exterior'           => $request->input('no_exterior'),
            'no_interior'           => $request->input('no_exterior'),
            'correo'                => $request->input('correo'),
            'telefono_1'            => $request->input('telefono_1'),
            'telefono_2'            => $request->input('telefono_2'),
            'estado_destino'        => $request->input('estado_destino'),
            'municipio_destino'     => $request->input('municipio_destino'),
            'codigo_postal_destino' => $request->input('codigo_postal_destino'),
            'colonia_destino'       => $request->input('colonia_destino'),
            'calle_destino'         => $request->input('calle_destino'),
            'no_exterior_destino'   => $request->input('no_exterior_destino'),
            'no_interior_destino'   => $request->input('no_interior_destino'),
            'socursal_id'           => Auth::user()->socursal_id,
            'empleado_id'           => Auth::user()->id,
        );
        if ($paquete->update_paquete_repartidor_eventual($array_paquete)) {
            $array_email = array(
                'nombre_completo'     => $nombre . ' ' . $apellido_1 . ' ' . $apellido_2,
                'numero_codigo_barra' => $request->input('bar_code'),
            );
            Mail::to($correo)->send(new PaqueteMail($array_email));
            $data['response_code'] = 200;
            $data['response_text'] = "Se realizo la operacion";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No se realizo la operacion";
        }
        return response()->json($data);
    }

    public function show($id) {
        $paquete = new Paquete;
        if($paquete->select_exit_paquete_repartidor($id)){
            $data['response_code'] = 200;
            $data['response_text'] = "Si existe el paquete";
        } else {
            $data['response_code'] = 500;
            $data['response_text'] = "No existe el paquete";
        }
         return response()->json($data);
    }

    public function create() {}

    public function edit($id) {}

    public function destroy($id) {}
}
