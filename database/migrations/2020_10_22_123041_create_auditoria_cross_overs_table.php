<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditoriaCrossOversTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auditoria_cross_overs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('paquete_id');
            $table->integer('empleado_operador_id');
            $table->integer('transporte_id');
            $table->integer('empleado_carga_id');
            $table->string('tipo', 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('auditoria_cross_overs');
    }
}
