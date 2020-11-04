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
        return DB::table('transportes as t')
            ->select('t.id', 't.no_transporte', 't.matricula_transporte')
            ->where('t.estatus_transporte', 1)
            ->where('t.socursal_id', $id_socursal)->get();
    }

    public function select_transporte_detalle($id_transporte) {
        return DB::table('transportes as t')
            ->join('tipo_transportes as tp', 'tp.id', "=", 't.tipo_transporte_id')
            ->select('t.matricula_transporte', 't.no_economico_transporte',
                't.marca_transporte', 't.matricula_transporte',
                'tp.descripcion_tipo_transporte')
            ->where('t.id', $id_transporte)
            ->first();
    }
}
