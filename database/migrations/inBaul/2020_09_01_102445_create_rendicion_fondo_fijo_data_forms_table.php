<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendicionFondoFijoDataFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendicion_fondo_fijo_data_forms', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('centro_c')->nullable();
            $table->string('cuenta_c')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('razon_s')->nullable();
            $table->string('concepto')->nullable();
            $table->integer('n_fac')->nullable();
            $table->integer('n_recib')->nullable();
            $table->float('debe',20,2)->nullable();
            $table->float('haber',20,2)->nullable();
            $table->float('saldo',20,2)->nullable();
            $table->integer('fondo_id')->nullable();
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
        Schema::dropIfExists('rendicion_fondo_fijo_data_forms');
    }
}
