<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomInvProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tom_inv_prods', function (Blueprint $table) {
            $table->id();
            //$table->string('marca_id');
            $table->string('prod')->nullable();
            $table->string('marca');            
            $table->string('descrip');
            $table->string('barcod')->nullable();
            $table->integer('cantidad');
            $table->string('um')->nullable();
            $table->integer('nuevo');
            $table->integer('cont_id');
            $table->integer("hoja");
            $table->integer("prod_ubi_id");
            $table->integer("stock_t")->nullable();
            $table->float("cost_t")->nullable();
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
        Schema::dropIfExists('tom_inv_prods');
    }
}
