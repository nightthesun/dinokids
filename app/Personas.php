<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    protected $fillable = [
        'first_name', 'last_name1', 'last_name2', 'ci', 'age',
        'birthdate', 'gender', 'nationality',  'foto', 
        'id_tipo', 'id_branch', 'city'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
  
    public function scopeUser($query, $buscar, $dato)
  {
    if ($buscar == 1 && $dato != '') {
      $resultado = Perfil::orderBy('id','DESC')
        ->select('perfils.*')
        ->where('nombre', 'LIKE', "%$dato%");
      return $resultado;
    } elseif ($buscar == 2 && $dato != '') {
      $resultado = Perfil::orderBy('id','DESC')
        ->select('perfils.*')
        ->where('ci', 'LIKE', "%$dato%");
      return $resultado;
    }
  }
  public function scopeUser2($query, $buscar, $dato)
  {
    if ($buscar == 1 && $dato != '') {
      $resultado = Personas::orderBy('id','DESC')
        ->select('reg_people.*')
        ->where('first_name', 'LIKE', "%$dato%");
      return $resultado;
    } elseif ($buscar == 2 && $dato != '') {
      $resultado = Personas::orderBy('id','DESC')
        ->select('reg_people.*')
        ->where('ci', 'LIKE', "%$dato%");
      return $resultado;
    }
  }
}
