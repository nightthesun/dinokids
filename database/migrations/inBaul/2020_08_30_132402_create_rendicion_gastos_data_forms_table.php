<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendicionGastosDataFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendicion_gastos_data_forms', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('centro_c');
            $table->string('cuenta_c');
            $table->string('razon_s');
            $table->string('detalle');
            $table->integer('no_fac');
            $table->float('monto',20,2);
            $table->integer('rendicion_gastos_form_id')->nullable();
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
        Schema::dropIfExists('rendicion_gastos_data_forms');
    }
}
