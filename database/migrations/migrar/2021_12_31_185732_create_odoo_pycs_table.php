<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdooPycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odoo_pycs', function (Blueprint $table) {
            $table->id();
            $table->string('cod')->nullable();
            $table->string('categ')->nullable();
            $table->string('descrip')->nullable();
            $table->float('precio_orig')->nullable();
            $table->string('moneda_orig')->nullable();
            $table->float('precio_costo')->nullable();
            $table->string('moneda_costo')->nullable();
            $table->float('precio_pub')->nullable();
            $table->date('f_ult_ingreso')->nullable();
            $table->integer('cant_ult_ingreso')->nullable();
            $table->string('ref_docum')->nullable();
            $table->integer('stock_actual')->nullable();
            $table->date('f_ult_venta')->nullable();
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
        Schema::dropIfExists('odoo_pycs');
    }
}
