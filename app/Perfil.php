<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = [
        'nombre', 'paterno', 'materno', 'ci', 'ci_e',
        'fecha_nac', 'telf', 'celu', 'direc', 'email', 'foto', 
        'area_id', 'cargo', 'fecha_ingreso', 'dias_vacacion',
        'corp_email', 'corp_telf', 'corp_int', 'corp_celu',
        'user_id', 'unidad_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function pc()
    {
        return $this->hasMany(InventarioPc::class);
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
}
