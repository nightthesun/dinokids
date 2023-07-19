<?php

namespace App;

use App\DataForm;
use Illuminate\Database\Eloquent\Model;

class LicenciaForm extends Model
{
  protected $fillable = [
    'motivo', 'hora_ini', 'hora_fin',
    'fecha_ini', 'fecha_fin', 'dias', 'horas', 'estado', 'detalle_estado', 'user_id', 'jefe_id', 'admin_id'
  ];
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function jefe()
  {
    return $this->belongsTo(User::class);
  }
  public function admin()
  {
    return $this->belongsTo(User::class);
  }
  public function area()
  {
    return $this->belongsTo(Area::class, 'area_id');
  }
  public function firmas()
  {
    return $this->hasMany(FirmaLicencia::class, 'form_id');
  }

  public function scopeEstado($query, $estado)
  {
    if ($estado == 'Aceptada' || $estado == 'Rechazada') {
      return $query->where('estado', 'LIKE', "%$estado%");
    } elseif ($estado == 'null') {
      return $query->where('estado', '=', null);
    }
  }
  public function scopeUser($query, $buscar, $dato)
  {
    if ($buscar == 1 && $dato != '') {
      $resultado = LicenciaForm::join('perfils', 'perfils.user_id', '=', 'licencia_forms.user_id')
        ->select('licencia_forms.*')
        ->where('perfils.nombre', 'LIKE', "%$dato%");
      return $resultado;
    } elseif ($buscar == 2 && $dato != '') {
      $resultado = LicenciaForm::join('perfils', 'perfils.user_id', '=', 'licencia_forms.user_id')
        ->select('licencia_forms.*')
        ->where('perfils.ci', '=', "$dato");
      return $resultado;
    }
  }
}
