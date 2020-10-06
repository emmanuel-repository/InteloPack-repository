<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_empleado', 70);
            $table->string('apellido_1_empleado', 50);
            $table->string('apellido_2_empleado', 50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('estatus_empleado', 4);
            $table->string('estatus_asignado_transporte', 4);
            $table->unsignedBigInteger('tipo_empleado_id')->unsigned();
            $table->unsignedBigInteger('tipo_transporte_id')->unsigned();
            $table->unsignedBigInteger('socursal_id')->unsigned();
            $table->foreign('tipo_empleado_id')->references('id')->on('tipo_empleados');
            $table->foreign('tipo_transporte_id')->references('id')->on('tipo_transportes');
            $table->foreign('socursal_id')->references('id')->on('socursals');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('empleados');
    }
}
