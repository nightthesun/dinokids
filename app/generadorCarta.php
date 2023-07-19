<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class generadorCarta extends Model
{
   
    //relacion 1:1 de generador de cartas a perfil de suario
   /**
    *  protected $table = 'generador_cartas';
    * protected $fillable = [
    *'perfil_id'
    * ];
    *   public function perfiles()     {        return $this->hasOne(Perfil::class);    }
    *
    */
    protected $table = 'contador_p_d_f';
        protected $fillable=['id','contador','link','created_at','updated_at'];
        
}
