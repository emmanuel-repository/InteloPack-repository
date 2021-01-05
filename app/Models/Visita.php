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
                'fecha_visita'       => $array['fecha'],
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

    public function select_visitas($no_paquete) {
        DB::beginTransaction();
        try {
            $paquete = DB::table('paquetes as p')->select('p.id')
                ->where('p.no_paquete', $no_paquete)->first();
            $vistas = DB::table('visitas')
                ->select('descripcion_visita', 'fecha_visita as fecha_cross_over',
                    DB::raw('"3.5" as estatus_cross_over'))
                ->where('paquete_id', $paquete->id)->orderBy('fecha_cross_over', 'desc')->get();
            DB::commit();
            return $vistas;
        } catch (\Throwable $th) {
            return $vistas = $th;
        }
    }
}
