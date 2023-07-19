<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendicionFondoFijoFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendicion_fondo_fijo_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->float('total_asignado',20,2)->nullable();
            $table->float('saldo_final',20,2)->nullable();
            $table->float('total_reponer',20,2)->nullable();
            $table->string('unidad')->nullable();
            $table->date('fecha_ini')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('unidad_id')->nullable();
            $table->integer('estado')->nullable();
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
        Schema::dropIfExists('rendicion_fondo_fijo_forms');
    }
}
