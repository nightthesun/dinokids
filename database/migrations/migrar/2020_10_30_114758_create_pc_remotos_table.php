<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcRemotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pc_remotos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('acceso');
            $table->string('password')->nullable();
            $table->integer('pc_id');
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
        Schema::dropIfExists('pc_remotos');
    }
}
