<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdooStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odoo_stocks', function (Blueprint $table) {
            $table->id();
            $table->string("cod")->nullable();
            $table->float("stock")->nullable();
            $table->integer("mes")->nullable();
            $table->date("fecha")->nullable();
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
        Schema::dropIfExists('odoo_stocks');
    }
}
