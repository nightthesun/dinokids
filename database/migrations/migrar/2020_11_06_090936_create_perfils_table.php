<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfils', function (Blueprint $table) {
            $table->id();
            /*DATOS PERSONALES*/
            $table->string('nombre')->nullable();
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('ci')->unique()->nullable();
            $table->string('ci_e')->nullable();
            /*BASICO*/
            $table->date('fecha_nac')->nullable();
            $table->string('telf')->nullable(); 
            $table->string('celu')->nullable(); 
            $table->string('direc')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('foto')->nullable(); 

            /*DATOS DE EMPLEADO*/
            $table->bigInteger('area_id')->nullable();
            $table->string('corp_email')->nullable();
            $table->string('cargo')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->integer('dias_vacacion')->nullable();
            $table->string('corp_telf')->nullable();
            $table->string('corp_int')->nullable();
            $table->string('corp_celu')->nullable();                   

            /*DATOS DEL SISTEMAS*/
            $table->bigInteger('user_id')->unique()->nullable();
            $table->bigInteger('unidad_id')->nullable();
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
        Schema::dropIfExists('perfils');
    }
}
