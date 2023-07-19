<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFondofijoViaticosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fondofijo_viaticos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fondofijo_id');
            $table->bigInteger('viatico_id');
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
        Schema::dropIfExists('fondofijo_viaticos');
    }
}
