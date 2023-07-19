<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_entregas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('empresa');
            $table->string('direc');
            $table->string('coordinar');
            $table->date('fecha_entrega');
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
        Schema::dropIfExists('solicitud_entregas');
    }
}
