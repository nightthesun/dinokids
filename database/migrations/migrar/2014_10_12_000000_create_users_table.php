<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            /*DATOS DE USUARIO*/
            $table->id();
            $table->string('name')->unique();
            $table->string('password');
            $table->boolean('val')->nullable();
            $table->boolean('elim')->nullable();
            $table->integer('dbiz_user')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
