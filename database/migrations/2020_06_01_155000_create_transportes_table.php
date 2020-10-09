<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transportes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_transporte', 20);
            $table->string('matricula_transporte', 20);
            $table->string('no_economico_transporte', 20);
            $table->string('estatus_transporte', 4);
            $table->string('estatus_asignado', 4);
            $table->unsignedBigInteger('socursal_id')->unsigned();
            $table->unsignedBigInteger('tipo_transporte_id')->unsigned();
            $table->foreign('socursal_id')->references('id')->on('socursals');
            $table->foreign('tipo_transporte_id')->references('id')->on('tipo_transportes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('transportes');
    }
}
