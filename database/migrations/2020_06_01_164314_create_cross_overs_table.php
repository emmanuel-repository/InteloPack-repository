<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrossOversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cross_overs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hora_cross_over', 12);
            $table->string('fecha_cross_over', 12);
            $table->string('estatus_cross_over', 4);
            $table->unsignedBigInteger('paquete_id')->unsigned();
            $table->unsignedBigInteger('empleado_id')->unsigned();
            $table->unsignedBigInteger('socuersal_id')->unsigned();
            $table->unsignedBigInteger('transporte_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('paquete_id')->references('id')->on('paquetes');
            $table->foreign('socuersal_id')->references('id')->on('socursals');
            $table->foreign('transporte_id')->references('id')->on('transportes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cross_overs');
    }
}
