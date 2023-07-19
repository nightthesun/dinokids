<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomInvContsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tom_inv_conts', function (Blueprint $table) {
            $table->id();
            $table->integer('conteo_id');
            $table->integer('tom_inv_tom_id');
            $table->integer('user_id');
            $table->integer('estado');
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
        Schema::dropIfExists('tom_inv_conts');
    }
}
