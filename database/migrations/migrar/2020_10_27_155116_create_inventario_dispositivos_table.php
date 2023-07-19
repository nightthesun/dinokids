<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioDispositivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_dispositivos', function (Blueprint $table) {
            $table->id();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('num_serie')->nullable();
            $table->string('tipo')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('caracteristicas')->nullable();
            $table->integer('pc_id');
            $table->string('estado')->nullable();
            $table->string('ubicacion')->nullable();
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
        Schema::dropIfExists('inventario_dispositivos');
    }
}
