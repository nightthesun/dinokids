<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendicionGastosViaticoFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendicion_gastos_viatico_forms', function (Blueprint $table) {
            $table->id();
            $table->string('saldo');
            $table->integer('user_id');
            $table->string('tipo_gasto');
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
        Schema::dropIfExists('rendicion_gastos_viatico_forms');
    }
}
