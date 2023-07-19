<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioPcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_pcs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('nombre')->nullable();   
            $table->string('area')->nullable();
            $table->string('ip')->nullable();
            $table->string('funcionario')->nullable();
            $table->string('ci')->nullable();
            $table->integer('estado')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('perfil_id')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('area_id')->nullable();
            $table->integer('unidad_id')->nullable();
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
        Schema::dropIfExists('inventario_pcs');
    }
}
