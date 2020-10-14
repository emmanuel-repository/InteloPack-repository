<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransporteEmpleado extends Model {

    public function select_transporte_empleado() {
        return DB::table('transporte_empleados as te')
            ->join('empleados as e', 'e.id', "=", 'te.empleado_id')
            ->join('transportes as t', 't.id', "=", 'te.transporte_id')
            ->join('socursals as s', 's.id', '=', 'e.socursal_id')
            ->select('te.id', 't.no_transporte', 't.matricula_transporte', 'e.nombre_empleado',
                'e.apellido_1_empleado', 'e.apellido_2_empleado', 's.nombre_socursal')
            ->get();
    }

    public function insert_transporte_empleado($id_chofer, $id_transporte) {
        DB::beginTransaction();
        try {
            DB::table('transporte_empleados')->insert([
                'empleado_id'   => $id_chofer,
                'transporte_id' => $id_transporte,
                'created_at'    => date("Y-m-d H:i:s"),
                'updated_at'    => date("Y-m-d H:i:s"),
            ]);
            DB::table('empleados')
                ->where('id', $id_chofer)
                ->update(['estatus_asignado_transporte' => 1]);

            DB::table('transportes')
                ->where('id', $id_transporte)
                ->update(['estatus_asignado_empleado' => 1]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function select_empleado_choferes($id_sucursal) {
        return DB::table('empleados as e')
            ->where('tipo_empleado_id', 4)
            ->where('estatus_asignado_transporte', 0)
            ->where('estatus_empleado', 1)
            ->where('socursal_id', $id_sucursal)
            ->select('e.id', 'e.nombre_empleado', 'e.apellido_1_empleado',
                'e.apellido_2_empleado', 'no_empleado')
            ->get();
    }

    public function select_transportes($id_sucursal) {
        return DB::table('transportes as t')
            ->where('estatus_transporte', 1)
            ->where('estatus_asignado_empleado', 0)
            ->where('socursal_id', $id_sucursal)
            ->select('t.id', 't.no_transporte', 't.matricula_transporte')
            ->get();
    }

    public function update_desagsinar_transporte($id) {
        DB::beginTransaction();
        try {
            DB::table('empleados')
                ->where('id', $id_chofer)
                ->update(['estatus_asignado_transporte' => 1]);

            DB::table('transportes')
                ->where('id', $id_transporte)
                ->update(['estatus_asignado_empleado' => 1]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
