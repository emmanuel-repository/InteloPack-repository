<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Empleado extends Authenticatable {
    use Notifiable;

    protected $guard = 'empleado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function select_empleados() {
        return DB::table('empleados as e')
            ->join('tipo_empleados as t', 't.id', "=", 'e.tipo_empleado_id')
            ->join('socursals as s', 's.id', '=', 'e.socursal_id')
            ->select('e.id', 'e.nombre_empleado', 'e.apellido_1_empleado', 'e.apellido_2_empleado',
                'e.email', 'e.estatus_empleado', 'e.tipo_empleado_id', 'e.socursal_id',
                's.nombre_socursal', 't.descripcion_tipo_empleado')->get();
    }

    public function select_login($email) {
        return DB::table('empleados as e')->select('e.estatus_empleado')
            ->where('e.email', 'like BINARY', $email)->first();
    }

    public function select_empleado_operador($id_socursal) {
        return DB::table('empleados as  e')
            ->leftJoin('transporte_empleados as te', 'te.empleado_id', '=', 'e.id')
            ->select('e.id', 'e.no_empleado', 'e.nombre_empleado', 'e.apellido_1_empleado',
                'e.apellido_2_empleado', 'te.transporte_id')
            ->where('e.estatus_empleado', 1)
            ->where('e.tipo_empleado_id', 4)
            ->where('e.socursal_id', $id_socursal)->get();
    }

}
