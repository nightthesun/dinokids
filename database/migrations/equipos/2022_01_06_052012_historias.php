<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Historias extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('historias', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('marca');
      $table->string('tipo');
      $table->string('modelo');
      $table->string('ns')->nullable();
      $table->string('caracteristicas');
      $table->string('estado');
      $table->bigInteger('id_empleado');
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
    //
  }
}
