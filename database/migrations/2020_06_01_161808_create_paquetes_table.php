<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaquetesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_paquete', 25);
            $table->string('estado_destino', 50);
            $table->string('municipio_destino', 50);
            $table->string('codigo_postal_destino', 7);
            $table->string('colonia_destino', 50);
            $table->string('calle_destino', 100);
            $table->string('no_exterior_destino', 14);
            $table->string('no_interior_destino', 14);
            $table->string('estatus_paquete', 4);
            $table->unsignedBigInteger('cliente_id')->unsigned();
            $table->unsignedBigInteger('eventual_id')->unsigned();
            $table->unsignedBigInteger('socursal_id')->unsigned();
            $table->unsignedBigInteger('empleado_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('eventual_id')->references('id')->on('eventuals');
            $table->foreign('socursal_id')->references('id')->on('socuersals');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('paquetes');
    }
}
