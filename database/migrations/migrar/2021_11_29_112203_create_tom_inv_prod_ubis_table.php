<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomInvProdUbisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tom_inv_prod_ubis', function (Blueprint $table) {
            $table->id();
            $table->string('descrip');
            $table->string('tom_id');
            $table->integer('nro');
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
        Schema::dropIfExists('tom_inv_prod_ubis');
    }
}
