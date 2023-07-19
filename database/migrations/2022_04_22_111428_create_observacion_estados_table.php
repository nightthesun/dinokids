<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacion_estados', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->string('textObs1')->nullable();
            $table->string('textObs2')->nullable();
            $table->integer('cotizacion_form_id')->nullable();
            $table->integer('nroMod')->nullable();
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
        Schema::dropIfExists('observacion_estados');
    }
}
