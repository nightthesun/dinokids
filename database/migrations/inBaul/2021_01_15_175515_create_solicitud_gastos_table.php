<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_gastos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('centro_c');
            $table->string('cuenta_c');
            $table->string('detalle');
            $table->float('monto',20,2);
            $table->string('motivo');
            $table->integer('estado')->nullable();
            $table->integer('perfil_id')->nullable();
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
        Schema::dropIfExists('solicitud_gastos');
    }
}
