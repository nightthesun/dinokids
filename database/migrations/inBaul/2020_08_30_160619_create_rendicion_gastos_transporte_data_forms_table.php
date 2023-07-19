<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendicionGastosTransporteDataFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendicion_gastos_transporte_data_forms', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('hora_ini');
            $table->string('hora_fin');
            $table->string('centro_c');
            $table->string('razon_s');
            $table->string('motivo');
            $table->float('monto',20,2);
            $table->integer('rendicion_gastos_transporte_form_id')->nullable();
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
        Schema::dropIfExists('rendicion_gastos_transporte_data_forms');
    }
}
