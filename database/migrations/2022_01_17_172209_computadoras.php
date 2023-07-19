<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Computadoras extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('computadoras', function(Blueprint $table){
      $table->engine = 'InnoDB';
      $table->bigInteger('id');
      $table->string('tipo');
      $table->integer('ip');
      $table->string('estado');
      $table->integer('id_empleado');
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
