<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            
            $table->string('OV')->nullable();
            $table->string('n_lic')->nullable();//NUMERO DE LICITACION
                      
            $table->string('nit')->nullable();
            $table->string('empresa');
            $table->string('unid');
            $table->string('nombre_resp')->nullable();//RESPONSABLE DE PROCESO
            $table->string('nombre_contac');
            $table->string('telf_contac')->nullable();
            $table->string('descrip');
            $table->string('pdf')->nullable();
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
        Schema::dropIfExists('cotizacion_forms');
    }
}
