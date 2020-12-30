<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visita extends Model {

    public function insert_visita($array) {
        DB::beginTransaction();
        try {
            $paquete = DB::table('paquetes')->select('id')
                ->where('no_paquete', $array['no_paquete'])
                ->first();
            DB::table('visitas')->insert([
                'descripcion_visita' => $array['descripcion_visita'],
                'fecha_visita'        => $array['fecha'],
                'paquete_id'         => $paquete->id,
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
}
