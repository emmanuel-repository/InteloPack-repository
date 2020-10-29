<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CrossOver extends Model {

    public function insert_cross_over($array_paquetes, $id_empleado, $id_socursal,
        $id_transporte, $id_operador) {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($array_paquetes); $i++) {
                $datos_paquete = DB::table('paquetes')
                    ->where('no_paquete', $array_paquetes[$i]->no_paquete)
                    ->select('id')->first();
                DB::table('cross_overs')->insert([
                    'hora_cross_over'    => $array_paquetes[$i]->hora,
                    'fecha_cross_over'   => $array_paquetes[$i]->fecha,
                    'estatus_cross_over' => 2,
                    'paquete_id'         => $datos_paquete->id,
                    'empleado_id'        => $id_empleado,
                    'socursal_id'        => $id_socursal,
                    'transporte_id'      => $id_transporte,
                    'created_at'         => date("Y-m-d H:i:s"),
                    'updated_at'         => date("Y-m-d H:i:s"),
                ]);
                DB::table('paquetes')
                    ->where('id', $datos_paquete->id)
                    ->update(['estatus_paquete' => 2]);
                DB::table('auditoria_cross_overs')->insert([
                    'paquete_id'           => $datos_paquete->id,
                    'socursal_id'          => $id_socursal,
                    'empleado_operador_id' => $id_operador,
                    'transporte_id'        => $id_transporte,
                    'empleado_carga_id'    => $id_empleado,
                    'tipo'                 => 'CARGA PAQUETE',
                    'created_at'           => date("Y-m-d H:i:s"),
                    'updated_at'           => date("Y-m-d H:i:s"),
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function update_asignacion_transporte($array) {
        DB::beginTransaction();
        try {
            //editar la nueva asignacion de carga
            // subir la carga al transporte
            DB::table('transporte_empleados')
                ->where('id', '=', $array['id_tranporte_empleado'])
                ->delete();
            DB::table('transportes')
                ->where('id', $array['id_transporte_cambio'])
                ->update(['estatus_asignado_empleado' => 0]);
            DB::table('empleados')
                ->where('id', $array['id_empleado_cambio'])
                ->update(['estatus_asignado_transporte' => 0]);
                
            DB::table('transporte_empleados')
                ->where('transporte_id', $array['id_transporte_anterior'])
                ->update(['empleado_id' => $array['id_operador_anterior']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    // public function insert_cross_over_change_operador($array_paquetes, $id_empleado,
    //     $id_socursal, $id_transporte, $id_operador) {
    //     DB::beginTransaction();
    //     try {
    //         for ($i = 0; $i < count($array_paquetes); $i++) {
    //             $datos_paquete = DB::table('paquetes')
    //                 ->where('no_paquete', $array_paquetes[$i]->no_paquete)
    //                 ->select('id')->first();
    //             DB::table('cross_overs')->insert([
    //                 'hora_cross_over'    => $array_paquetes[$i]->hora,
    //                 'fecha_cross_over'   => $array_paquetes[$i]->fecha,
    //                 'estatus_cross_over' => 2,
    //                 'paquete_id'         => $datos_paquete->id,
    //                 'empleado_id'        => $id_empleado,
    //                 'socursal_id'        => $id_socursal,
    //                 'transporte_id'      => $id_transporte,
    //                 'created_at'         => date("Y-m-d H:i:s"),
    //                 'updated_at'         => date("Y-m-d H:i:s"),
    //             ]);
    //             DB::table('paquetes')
    //                 ->where('id', $datos_paquete->id)
    //                 ->update(['estatus_paquete' => 2]);
    //         }
    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return false;
    //     }
    // }

    public function insert_cross_over_descarga($array_paquetes, $id_empleado,
        $id_socursal, $id_transporte) {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($array_paquetes); $i++) {
                $datos_paquete = DB::table('paquetes')
                    ->where('no_paquete', $array_paquetes[$i]->no_paquete)
                    ->select('id')->first();
                DB::table('cross_overs')->insert([
                    'hora_cross_over'    => $array_paquetes[$i]->hora,
                    'fecha_cross_over'   => $array_paquetes[$i]->fecha,
                    'estatus_cross_over' => 3,
                    'paquete_id'         => $datos_paquete->id,
                    'empleado_id'        => $id_empleado,
                    'socursal_id'        => $id_socursal,
                    'transporte_id'      => $id_transporte,
                    'created_at'         => date("Y-m-d H:i:s"),
                    'updated_at'         => date("Y-m-d H:i:s"),
                ]);
                DB::table('paquetes')
                    ->where('id', $datos_paquete->id)
                    ->update(['estatus_paquete' => 3]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function select_detalle_cross_over($id) {
        return DB::table('cross_overs as c')
            ->join('socursals as s', 's.id', '=', 'c.socursal_id')
            ->select('c.hora_cross_over', 'c.fecha_cross_over',
                'c.estatus_cross_over', 's.nombre_socursal', 's.estado_socursal')
            ->where('paquete_id', $id)
            ->get();
    }
}
