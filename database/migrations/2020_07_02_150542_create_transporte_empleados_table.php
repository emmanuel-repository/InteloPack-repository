<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransporteEmpleadosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transporte_empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('empleado_id')->unsigned();
            $table->unsignedBigInteger('transporte_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('transporte_id')->references('id')->on('transportes');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('transporte_empleados');
    }
}
