<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_cliente', 70);
            $table->string('apellido_1_cliente', 50);
            $table->string('apellido_2_cliente', 50);
            $table->string('razon_social_cliente', 50);
            $table->string('rfc_cliente', 50);
            $table->string('estado_cliente', 50);
            $table->string('municipio_cliente', 50);
            $table->string('codigo_postal_cliente', 7);
            $table->string('colonia_cliente', 100);
            $table->string('calle_cliente', 100);
            $table->string('no_exterior_cliente', 10);
            $table->string('no_interior_cliente', 10);
            $table->string('email_cliente', 70);
            $table->string('telefono_1_cliente', 14);
            $table->string('telefono_2_usuario', 14);
            $table->string('estatus_cliente', 4);
            $table->unsignedBigInteger('empleado_id')->unsigned();
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
        Schema::dropIfExists('clientes');
    }
}
