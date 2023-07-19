<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqueoCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arqueo_cajas', function (Blueprint $table) {
            $table->id();
            $table->string('unidad');
            $table->string('moneda');
            $table->string('responsable');
            $table->date('fecha');
            $table->string('caja');
            $table->string('hora');

            $table->integer('cantidad200')->nullable();
            $table->integer('importe200')->nullable();
            $table->integer('cantidad100')->nullable();
            $table->integer('importe100')->nullable();
            $table->integer('cantidad50')->nullable();
            $table->integer('importe50')->nullable();
            $table->integer('cantidad20')->nullable();
            $table->integer('importe20')->nullable();
            $table->integer('cantidad10')->nullable();
            $table->integer('importe10')->nullable();
            $table->integer('BBtotal')->nullable();

            $table->integer('C5MB')->nullable();
            $table->integer('I5MB')->nullable();
            $table->integer('C2MB')->nullable();
            $table->integer('I2MB')->nullable();
            $table->integer('C1MB')->nullable();
            $table->integer('I1MB')->nullable();
            $table->integer('C05MB')->nullable();
            $table->integer('I05MB')->nullable();
            $table->integer('C02MB')->nullable();
            $table->integer('I02MB')->nullable();
            $table->integer('C01MB')->nullable();
            $table->integer('I01MB')->nullable();
            $table->integer('MBtotal')->nullable();

            $table->integer('C100BDA')->nullable();
            $table->integer('I100BDA')->nullable();
            $table->integer('C50BDA')->nullable();
            $table->integer('I50BDA')->nullable();
            $table->integer('C20BDA')->nullable();
            $table->integer('I20BDA')->nullable();
            $table->integer('C10BDA')->nullable();
            $table->integer('I10BDA')->nullable();
            $table->integer('C5BDA')->nullable();
            $table->integer('I5BDA')->nullable();
            $table->integer('DAtotal')->nullable();
            $table->integer('DABtotal')->nullable();
            $table->integer('OBMtotal')->nullable();

            $table->integer('ICC')->nullable();
            $table->integer('ICCF')->nullable();
            $table->integer('ICSF')->nullable();
            $table->integer('IOC')->nullable();
            $table->integer('CCtotal')->nullable();

            $table->integer('IDCC')->nullable();
            $table->integer('IDCC1')->nullable();
            $table->integer('IDCC2')->nullable();
            $table->integer('IDCC3')->nullable();
            $table->integer('DCtotal')->nullable();

            $table->integer('TGB')->nullable();

            $table->integer('user_id');
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
        Schema::dropIfExists('arqueo_cajas');
    }
}
