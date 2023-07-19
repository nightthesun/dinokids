<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDualOdooProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dual_odoo_prods', function (Blueprint $table) {
            $table->id();
            $table->string('o_cod')->nullable();
            $table->string('o_desc')->nullable();
            $table->string('o_um')->nullable();
            $table->string('d_cod')->nullable();
            $table->string('d_desc')->nullable();
            $table->integer('o_um_id')->nullable();
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
        Schema::dropIfExists('dual_odoo_prods');
    }
}
