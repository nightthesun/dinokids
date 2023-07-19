<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdooRepVtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odoo_rep_vts', function (Blueprint $table) {
            $table->id();
            $table->string('cod')->nullable();
            $table->float('stockSuc')->nullable();
            $table->integer('cantidad')->nullable();
            $table->float('precioventa')->nullable();
            $table->float('pvp')->nullable();
            $table->float('descuento')->nullable();
            $table->float('costoF')->nullable();
            $table->float('total')->nullable();
            $table->string('grupo')->nullable();
            $table->integer('mes')->nullable();
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
        Schema::dropIfExists('odoo_rep_vts');
    }
}
