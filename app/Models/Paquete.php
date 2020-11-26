<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paquete extends Model {

    public function insert($array_paquete, $array_cross_over, $array_consecutivo) {
        DB::beginTransaction();
        try {
            $consecutivo = DB::table('paquetes')
                ->select(DB::raw('LPAD(count(id) + 1, 3, 0) as folio_consecutivo'))
                ->where('created_at', 'like', '%' . $array_consecutivo['fecha_hoy'] . '%')
                ->get();
            $no_paquete = $array_consecutivo['socursal_id'] . $array_consecutivo['fecha']
            . $array_consecutivo['empleado_id'] . $consecutivo[0]->folio_consecutivo;
            $id = DB::table('paquetes')->insertGetId([
                'consecutivo_paquete'   => $consecutivo[0]->folio_consecutivo,
                'no_paquete'            => $no_paquete,
                'estado_destino'        => $array_paquete['estado_destino'],
                'municipio_destino'     => $array_paquete['municipio_destino'],
                'codigo_postal_destino' => $array_paquete['codigo_postal_destino'],
                'colonia_destino'       => $array_paquete['colonia_destino'],
                'calle_destino'         => $array_paquete['colonia_destino'],
                'no_exterior_destino'   => $array_paquete['no_exterior_destino'],
                'no_interior_destino'   => $array_paquete['no_interior_destino'],
                'cliente_id'            => $array_paquete['cliente_id'],
                'socursal_id'           => $array_paquete['socursal_id'],
                'empleado_id'           => $array_paquete['empleado_id'],
                'created_at'            => date("Y-m-d H:i:s"),
                'updated_at'            => date("Y-m-d H:i:s"),
            ]);
            DB::table('cross_overs')->insert([
                'hora_cross_over'  => $array_cross_over['hora_cross_over'],
                'fecha_cross_over' => $array_cross_over['fecha_cross_over'],
                'paquete_id'       => $id,
                'empleado_id'      => $array_cross_over['empleado_id'],
                'socursal_id'      => $array_cross_over['socursal_id'],
                'created_at'       => date("Y-m-d H:i:s"),
                'updated_at'       => date("Y-m-d H:i:s"),
            ]);
            DB::commit();
            return $no_paquete;
        } catch (\Exception $e) {
            DB::rollback();
            return '';
        }
    }

    function insert_paquete_eventual($array_paquete, $array_eventual, 
        $array_cross_over, $array_consecutivo) {
        DB::beginTransaction();
        try {
            $consecutivo = DB::table('paquetes')
                ->select(DB::raw('LPAD(count(id) + 1, 3, 0) as folio_consecutivo'))
                ->where('created_at', 'like', '%' . $array_consecutivo['fecha_hoy'] . '%')
                ->get();
            $no_paquete = $array_consecutivo['socursal_id'] . $array_consecutivo['fecha']
            . $array_consecutivo['empleado_id'] . $consecutivo[0]->folio_consecutivo;
            $id_enventual = DB::table('eventuals')->insertGetId([
                'nombre_eventual'        => $array_eventual['nombre_eventual'],
                'apellido_1_eventual'    => $array_eventual['apellido_1_eventual'],
                'apellido_2_eventual'    => $array_eventual['apellido_2_eventual'],
                'razon_social'           => $array_eventual['razon_social'],
                'rfc_eventual'           => $array_eventual['rfc_eventual'],
                'estado_eventual'        => $array_eventual['estado_eventual'],
                'municipio_eventual'     => $array_eventual['municipio_eventual'],
                'codigo_postal_eventual' => $array_eventual['codigo_postal_eventual'],
                'colonia_eventual'       => $array_eventual['colonia_eventual'],
                'calle_eventual'         => $array_eventual['calle_eventual'],
                'no_exterior_eventual'   => $array_eventual['no_exterior_eventual'],
                'no_interior_eventual'   => $array_eventual['no_interior_eventual'],
                'correo_eventual'        => $array_eventual['correo_eventual'],
                'telefono_1_eventual'    => $array_eventual['telefono_1_evnetual'],
                'telefono_2_eventual'    => $array_eventual['telefono_2_eventual'],
                'created_at'             => date("Y-m-d H:i:s"),
                'updated_at'             => date("Y-m-d H:i:s"),
            ]);
            $id_paquete = DB::table('paquetes')->insertGetId([
                'consecutivo_paquete'   => $consecutivo[0]->folio_consecutivo,
                'no_paquete'            => $no_paquete,
                'estado_destino'        => $array_paquete['estado_destino'],
                'municipio_destino'     => $array_paquete['municipio_destino'],
                'codigo_postal_destino' => $array_paquete['codigo_postal_destino'],
                'colonia_destino'       => $array_paquete['colonia_destino'],
                'calle_destino'         => $array_paquete['calle_destino'],
                'no_exterior_destino'   => $array_paquete['no_exterior_destino'],
                'no_interior_destino'   => $array_paquete['no_interior_destino'],
                'eventual_id'           => $id_enventual,
                'socursal_id'           => $array_paquete['socursal_id'],
                'empleado_id'           => $array_paquete['empleado_id'],
                'created_at'            => date("Y-m-d H:i:s"),
                'updated_at'            => date("Y-m-d H:i:s"),
            ]);
            DB::table('cross_overs')->insert([
                'hora_cross_over'  => $array_cross_over['hora_cross_over'],
                'fecha_cross_over' => $array_cross_over['fecha_cross_over'],
                'paquete_id'       => $id_paquete,
                'empleado_id'      => $array_cross_over['empleado_id'],
                'socursal_id'      => $array_cross_over['socursal_id'],
                'created_at'       => date("Y-m-d H:i:s"),
                'updated_at'       => date("Y-m-d H:i:s"),
            ]);
            DB::commit();
            return $no_paquete;
        } catch (\Exception $e) {
            DB::rollback();
            return '';
        }
    }

    public function select_paquete($id) {
        return DB::table('paquetes as p')
            ->join('clientes as cl', 'cl.id', '=', 'p.cliente_id')
            ->join('socursals as s', 's.id', '=', 'p.socursal_id')
            ->select('p.no_paquete', 'p.estado_destino', 'p.municipio_destino',
                'p.codigo_postal_destino', 'p.colonia_destino', 'p.calle_destino',
                'p.no_exterior_destino', 'p.no_interior_destino', 'p.estatus_paquete',
                'cl.nombre_cliente as nombre', 'cl.apellido_1_cliente as apellido_1',
                'cl.apellido_2_cliente as apellido_2', 'cl.razon_social_cliente as razon_social',
                'cl.rfc_cliente as rfc', 's.nombre_socursal',
                's.no_socursal', 's.estado_socursal', 's.municipio_socursal',
                's.codigo_postal_socursal', 's.colonia_socursal', 's.calle_socursal',
                's.no_exterior_socursal', 's.no_interior_socursal')
            ->where('p.id', $id)
            ->first();
    }

    public function select_paquete_eventual($id) {
        return DB::table('paquetes as p')
            ->join('eventuals as ev', 'ev.id', '=', 'p.eventual_id')
            ->join('socursals as s', 's.id', '=', 'p.socursal_id')
            ->select('p.no_paquete', 'p.estado_destino', 'p.municipio_destino',
                'p.codigo_postal_destino', 'p.colonia_destino', 'p.calle_destino',
                'p.no_exterior_destino', 'p.no_interior_destino', 'ev.nombre_eventual as nombre',
                'ev.apellido_1_eventual as apellido_1', 'ev.apellido_2_eventual as apellido_2',
                "ev.razon_social as razon_social", 'ev.rfc_eventual as rfc', 's.nombre_socursal',
                's.no_socursal', 's.estado_socursal', 's.municipio_socursal',
                's.codigo_postal_socursal', 's.colonia_socursal', 's.calle_socursal',
                's.no_exterior_socursal', 's.no_interior_socursal')
            ->where('p.id', $id)
            ->first();
    }

    public function select_bar_code($numero_bar_code) {
        return DB::table('paquetes')->where('no_paquete', $numero_bar_code)->first();
    }

    public function insert_bar_codes_recoleccion($array) {
        DB::beginTransaction();
        try {
            $data_array = array();
            $data_error = array();
            for ($i = 0; $i < $array['cantidad_bar_code']; $i++) {
                $consecutivo = DB::table('paquetes')
                    ->select(DB::raw('LPAD(count(id) + 1, 3, 0) as folio_consecutivo'))
                    ->where('created_at', 'like', '%' . $array['fecha_hoy'] . '%')
                    ->get();
                $no_paquete = $array['socursal_id'] .
                $array['fecha'] . $array['empleado_id'] .
                $consecutivo[0]->folio_consecutivo;
                DB::table('paquetes')->insert([
                    'consecutivo_paquete' => $consecutivo[0]->folio_consecutivo,
                    'no_paquete'          => $no_paquete,
                    'estatus_paquete'     => 5,
                    'empleado_id'         => $array['empleado_id'],
                    'created_at'          => date("Y-m-d H:i:s"),
                    'updated_at'          => date("Y-m-d H:i:s"),
                ]);
                $data_array[$i] = $no_paquete;
            }
            DB::commit();
            return $data_array;
        } catch (\Exception $e) {
            DB::rollback();
            return $data_error;
        }
    }

    public function select_exit_paquete($codigo_barras) {
        return DB::table('paquetes')->select('id', 'estatus_paquete')
            ->where('no_paquete', $codigo_barras)
            ->whereNotIn('estatus_paquete', [2, 4, 5])
            ->first();
    }

    public function select_exit_paquete_descarga($codigo_barras) {
        return DB::table('paquetes')->select('id', 'estatus_paquete')
            ->where('no_paquete', $codigo_barras)
            ->whereNotIn('estatus_paquete', [1, 3, 4, 5])
            ->first();
    }

    public function select_paquete_cliente_registrado($bar_code) {
        return DB::table('paquetes as p')
            ->join('clientes as c', 'c.id', '=', 'p.cliente_id')
            ->select('c.nombre_cliente as nombre', 'c.apellido_1_cliente as apellido_1',
                'c.apellido_2_cliente as apellido_2', 'p.no_paquete', 'p.created_at')
            ->where('p.no_paquete', $bar_code)
            ->first();
    }

    public function select_paquete_cliente_eventual($bar_code) {
        return DB::table('paquetes as p')
            ->join('eventuals as e', 'e.id', '=', 'p.eventual_id')
            ->select('e.nombre_eventual as nombre', 'e.apellido_1_eventual as apellido_1',
                'e.apellido_2_eventual as apellido_2', 'p.no_paquete', 'p.created_at')
            ->where('p.no_paquete', $bar_code)
            ->first();
    }

    public function select_exit_paquete_repartidor($bar_code) {
        return DB::table('paquetes as p')->select('id')
            ->where('p.no_paquete', $bar_code)
            ->where('estatus_paquete', '=', '5')
            ->first();
    }

    public function select_exit_entrega_paquete($bar_code) {
        return DB::table('paquetes')
            ->select('id', 'cliente_id', 'eventual_id')
            ->where('no_paquete', $bar_code)
            ->whereNotIn('estatus_paquete', [4, 5])
            ->first();
    }

    public function update_paquete_repartidor($array) {
        DB::beginTransaction();
        try {
            $cliente = DB::table('clientes')->select('id')
                ->where('razon_social_cliente', $array['razon_social'])
                ->first();
            $paquete = DB::table('paquetes')->select('id')
                ->where('no_paquete', $array['bar_code'])
                ->first();
            $transporte_empleado = DB::table('transporte_empleados')->select('transporte_id')
                ->where('empleado_id', $array['empleado_id'])
                ->first();
            DB::table('paquetes')
                ->where('no_paquete', $array['bar_code'])
                ->update([
                    'estatus_paquete'       => 2,
                    'cliente_id'            => $cliente->id,
                    'estado_destino'        => $array['estado_destino'],
                    'municipio_destino'     => $array['municipio_destino'],
                    'codigo_postal_destino' => $array['codigo_postal_destino'],
                    'colonia_destino'       => $array['colonia_destino'],
                    'calle_destino'         => $array['calle_destino'],
                    'no_exterior_destino'   => $array['no_exterior_destino'],
                    'no_interior_destino'   => $array['no_interior_destino'],
                    'socursal_id'           => $array['socursal_id'],
                    'empleado_id'           => $array['empleado_id'],
                ]);
            DB::table('cross_overs')->insert([
                'paquete_id'       => $paquete->id,
                'hora_cross_over'  => $array['hora_cross_over'],
                'fecha_cross_over' => $array['fecha_cross_over'],
                'empleado_id'      => $array['empleado_id'],
                'socursal_id'      => $array['socursal_id'],
                'created_at'       => date("Y-m-d H:i:s"),
                'updated_at'       => date("Y-m-d H:i:s"),
            ]);
            DB::table('cross_overs')->insert([
                'paquete_id'         => $paquete->id,
                'hora_cross_over'    => $array['hora_cross_over'],
                'fecha_cross_over'   => $array['fecha_cross_over'],
                'estatus_cross_over' => 2,
                'empleado_id'        => $array['empleado_id'],
                'socursal_id'        => $array['socursal_id'],
                'transporte_id'      => $transporte_empleado->transporte_id,
                'created_at'         => date("Y-m-d H:i:s"),
                'updated_at'         => date("Y-m-d H:i:s"),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function update_paquete_repartidor_eventual($array) {
        DB::beginTransaction();
        try {
            $paquete = DB::table('paquetes')->select('id')
                ->where('no_paquete', $array['bar_code'])
                ->first();
            $transporte_empleado = DB::table('transporte_empleados')->select('transporte_id')
                ->where('empleado_id', $array['empleado_id'])
                ->first();
            $id_eventual = DB::table('eventuals')->insertGetId([
                'nombre_eventual'        => $array['nombre'],
                'apellido_1_eventual'    => $array['apellido_1'],
                'apellido_2_eventual'    => $array['apellido_2'],
                'razon_social'           => $array['razon_social'],
                'rfc_eventual'           => $array['rfc'],
                'estado_eventual'        => $array['estado'],
                'municipio_eventual'     => $array['municipio'],
                'codigo_postal_eventual' => $array['codigo_postal'],
                'colonia_eventual'       => $array['colonia'],
                'calle_eventual'         => $array['calle'],
                'no_exterior_eventual'   => $array['no_exterior'],
                'no_interior_eventual'   => $array['no_interior'],
                'correo_eventual'        => $array['correo'],
                'telefono_1_eventual'    => $array['telefono_1'],
                'telefono_2_eventual'    => $array['telefono_2'],
                'created_at'             => date("Y-m-d H:i:s"),
                'updated_at'             => date("Y-m-d H:i:s"),
            ]);
            DB::table('paquetes')
                ->where('no_paquete', $array['bar_code'])
                ->update([
                    'estatus_paquete'       => 2,
                    'eventual_id'           => $id_eventual,
                    'estado_destino'        => $array['estado_destino'],
                    'municipio_destino'     => $array['municipio_destino'],
                    'codigo_postal_destino' => $array['codigo_postal_destino'],
                    'colonia_destino'       => $array['colonia_destino'],
                    'calle_destino'         => $array['calle_destino'],
                    'no_exterior_destino'   => $array['no_exterior_destino'],
                    'no_interior_destino'   => $array['no_interior_destino'],
                    'socursal_id'           => $array['socursal_id'],
                    'empleado_id'           => $array['empleado_id'],
                ]);
            DB::table('cross_overs')->insert([
                'paquete_id'       => $paquete->id,
                'hora_cross_over'  => $array['hora_cross_over'],
                'fecha_cross_over' => $array['fecha_cross_over'],
                'empleado_id'      => $array['empleado_id'],
                'socursal_id'      => $array['socursal_id'],
                'created_at'       => date("Y-m-d H:i:s"),
                'updated_at'       => date("Y-m-d H:i:s"),
            ]);
            DB::table('cross_overs')->insert([
                'paquete_id'         => $paquete->id,
                'hora_cross_over'    => $array['hora_cross_over'],
                'fecha_cross_over'   => $array['fecha_cross_over'],
                'estatus_cross_over' => 2,
                'empleado_id'        => $array['empleado_id'],
                'socursal_id'        => $array['socursal_id'],
                'transporte_id'      => $transporte_empleado->transporte_id,
                'created_at'         => date("Y-m-d H:i:s"),
                'updated_at'         => date("Y-m-d H:i:s"),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function update_estatus_entrega($array) {
        DB::beginTransaction();
        try {
            $paquete = DB::table('paquetes')->select('id')
                ->where('no_paquete', $array['bar_code'])
                ->first();
            $transporte_empleado = DB::table('transporte_empleados')->select('transporte_id')
                ->where('empleado_id', $array['empleado_id'])
                ->first();
            DB::table('paquetes')->where('no_paquete', $array['bar_code'])
                ->update(['estatus_paquete' => 4]);
            DB::table('cross_overs')->insert([
                'paquete_id'         => $paquete->id,
                'hora_cross_over'    => $array['hora'],
                'fecha_cross_over'   => $array['fecha'],
                'estatus_cross_over' => 4,
                'empleado_id'        => $array['empleado_id'],
                'socursal_id'        => $array['socursal_id'],
                'transporte_id'      => $transporte_empleado->transporte_id,
                'created_at'         => date("Y-m-d H:i:s"),
                'updated_at'         => date("Y-m-d H:i:s"),
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function select_existe_paquete($bar_code) {
        return DB::table('paquetes as p')
            ->select('id', 'p.cliente_id', 'p.eventual_id')
            ->where('p.no_paquete', $bar_code)
            ->where('estatus_paquete', '<>', '5')
            ->first();
    }

    public function select_paquete_carga($json_tabla) {
        $array_paquete = array();
        for ($i = 0; $i < count($json_tabla); $i++) {
            $array_paquete[$i] = DB::table('paquetes as p')
                ->select('no_paquete', 'estado_destino', 'municipio_destino',
                    'colonia_destino', 'calle_destino', 'no_exterior_destino',
                    'no_interior_destino', 'codigo_postal_destino')
                ->where('p.no_paquete', $json_tabla[$i]->no_paquete)
                ->first();
        }
        return $array_paquete;
    }

    public function select_paquete_historial($id_socursal) {
        return DB::table('paquetes as p')
            ->select('p.*')
            ->where('socursal_id', '=', $id_socursal)
            ->where('estatus_paquete', '<>', '5')
            ->limit(100)
            ->get();
        return $array_paquete;
    }

    public function select_paquete_filtros($array) {
        $id_socursal     = $array['id_socursal'];
        $estatus_paquete = $array['estatus_paquete'];
        $fecha_inicio    = $array['fecha_inicio'];
        $fecha_final     = $array['fecha_final'];
        $query           = "select * from paquetes where estatus_paquete <> 5 ";
        if (!empty($id_socursal)) {
            $query .= "and socursal_id = " . $id_socursal . " ";
        }
        if (!empty($estatus_paquete)) {
            $query .= "and estatus_paquete = '" . $estatus_paquete . "' ";
        }
        if (!empty($fecha_inicio) && empty($fecha_final)) {
            $query .= "and created_at like '%" . $fecha_inicio . "%' ";
        }
        if (!empty($fecha_inicio) && !empty($fecha_final)) {
            $query .= "and created_at  between '"
                . $fecha_inicio . "' and '" . $fecha_final . "' ";
        }
        return DB::select($query);
    }

    public function prueba_query($array) {
        DB::beginTransaction();
        try {
            $data_array       = array();
            $data_error       = array();
            $socuesal_formato = str_pad($array['socuersal_id'], 3, '0', STR_PAD_LEFT);
            $empleado_formato = str_pad($array['empleado_id'], 3, '0', STR_PAD_LEFT);
            $fecha            = $array['fecha_hoy'];
            for ($i = 0; $i < 20; $i++) {
                $con = DB::table('paquetes')
                    ->select(DB::raw('LPAD(count(id) + 1, 3, 0) as folio_consecutivo'))
                    ->where('created_at', 'like', '%' . $fecha . '%')
                    ->get();

                $no_paquete = $socuesal_formato . '-' .
                $array['fecha'] . '-' . $empleado_formato . '-' .
                $con[0]->folio_consecutivo;

                DB::table('paquetes')->insert([
                    'consecutivo_paquete'   => $con[0]->folio_consecutivo,
                    'no_paquete'            => $no_paquete,
                    'estado_destino'        => 'Nombre' . $i,
                    'municipio_destino'     => 'apellido' . $i,
                    'codigo_postal_destino' => '123456',
                    'colonia_destino'       => '212343',
                    'calle_destino'         => '223',
                    'no_exterior_destino'   => '23',
                    'no_interior_destino'   => '23',
                    'created_at'            => date("Y-m-d H:i:s"),
                    'updated_at'            => date("Y-m-d H:i:s"),
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
