<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_eventual', 70);
            $table->string('apellido_1_eventual', 50);
            $table->string('apellido_2_eventual', 50);
            $table->string('razon_social', 100);
            $table->string('rfc_eventual', 15);
            $table->string('estado_eventual', 50);
            $table->string('municipio_eventual', 50);
            $table->string('codigo_postal_eventual', 7);
            $table->string('colonia_eventual', 100);
            $table->string('calle_eventual', 50);
            $table->string('no_exterior_eventual', 14);
            $table->string('no_interior_eventual', 14);
            $table->string('correo_eventual', 100);
            $table->string('telefono_1_eventual', 14);
            $table->string('telefono_2_eventual', 14);
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
        Schema::dropIfExists('eventuals');
    }
}
