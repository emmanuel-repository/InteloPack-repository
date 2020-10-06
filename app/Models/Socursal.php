<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Socursal extends Model {

    public function select_socursales() {
        return DB::table('socursals')->where('estatus_socursal', '1')->get();
    }

}
