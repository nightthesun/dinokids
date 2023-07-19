<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendicionGastosViaticoDataFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendicion_gastos_viatico_data_forms', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('centro_c');
            $table->integer('n_fac');
            $table->integer('n_recibo');
            $table->string('proveedor');
            $table->float('importe');
            $table->string('detalle',20,2);
            $table->string('tipo');
            
            $table->integer('rendicion_gastos_viatico_form_id')->nullable();
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
        Schema::dropIfExists('rendicion_gastos_viatico_data_forms');
    }
}
