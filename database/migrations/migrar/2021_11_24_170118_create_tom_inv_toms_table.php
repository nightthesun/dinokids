<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomInvTomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tom_inv_toms', function (Blueprint $table) {
            $table->id();
            $table->integer('conteo_id')->nullable();
            $table->integer('ubi_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('ubi');
            $table->integer('suc_id');
            $table->date('fini');
            $table->date('ffin')->nullable();
            //$table->integer('nro');
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
        Schema::dropIfExists('tom_inv_toms');
    }
}
