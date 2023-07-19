<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockventas', function (Blueprint $table) {
            $table->id();
            $table->string('catprod')->nullable();
            $table->string('codprod');
            $table->string('desprod');
            $table->string('umprod');
            $table->string('canprod');
            $table->string('alm_origen');
            $table->string('alm_destino');
            $table->string('cod_user');
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
        Schema::dropIfExists('stockventas');
    }
}
