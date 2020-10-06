<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocursalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socursals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_socursal', 50);
            $table->string('no_socursal', 50);
            $table->string('estado_socursal', 50);
            $table->string('municipio_socursal', 50);
            $table->string('codigo_postal_socursal', 7);
            $table->string('colonia_socursal', 100);
            $table->string('calle_socursal', 100);
            $table->string('no_exterior_socursal', 12);
            $table->string('no_interior_socursal', 12);
            $table->string('estatus_socursal', 4);
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
        Schema::dropIfExists('socursals');
    }
}
