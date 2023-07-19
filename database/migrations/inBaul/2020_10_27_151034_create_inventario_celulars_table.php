<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioCelularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_celulars', function (Blueprint $table) {
            $table->id();
            $table->string('imei');
            $table->string('num_serie')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->string('color')->nullable();
            $table->string('pantalla')->nullable();
            $table->string('rom')->nullable();
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('camara_principal')->nullable();
            $table->string('camara_frontal')->nullable();
            $table->string('so')->nullable();
            $table->boolean('sd');
            $table->string('bateria')->nullable();
            $table->string('linea')->nullable();
            $table->boolean('cargador');
            $table->boolean('cable_usb');
            $table->boolean('audifonos');
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
        Schema::dropIfExists('inventario_celulars');
    }
}
