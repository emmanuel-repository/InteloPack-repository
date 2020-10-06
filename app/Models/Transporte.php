<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transporte extends Model {

    public function select_transportes() {
        return DB::table('transportes as t')
            ->join('socursals as s', 's.id', "=", 't.socursal_id')
            ->join('tipo_transportes as tt', 'tt.id', '=', 't.tipo_transporte_id')
            ->select('t.*', 's.nombre_socursal', 'tt.descripcion_tipo_transporte')
            ->get();
    }

    public function select_transporte_socuersal($id_socursal) {
        return DB::table('transportes')
            ->select('id', 'no_transporte', 'matricula_transporte')
            ->where('estatus_transporte', 1)
            ->where('estatus_asignado_empleado', 1)
            ->where('socursal_id', $id_socursal)->get();
    }
}
