<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Historia
 *
 * @property $id
 * @property $marca
 * @property $tipo
 * @property $modelo
 * @property $ns
 * @property $caracteristicas
 * @property $estado
 * @property $id_empleado
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Historia extends Model
{

  static $rules = [
    'marca' => 'required',
    'tipo' => 'required',
    'modelo' => 'required',
    'caracteristicas' => 'required',
    'estado' => 'required',
    'id_empleado' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['marca', 'tipo', 'modelo', 'ns', 'caracteristicas', 'estado', 'id_empleado'];

  public function empleado()
  {
    return $this->hasOne('App\Models\Empleado', 'id', 'id_empleado');
  }

  public function scopeCpu($query, $buscar, $dato)
  {
    if ($buscar == 1 && $dato != '') {
      $resultado = Historia::orderBy('id', 'DESC')
        ->select('historias.*')
        ->where('marca', 'LIKE', "%$dato%");
      return $resultado;
    } elseif ($buscar == 2 && $dato != '') {
      $resultado = Historia::orderBy('id', 'DESC')
        ->select('historias.*')
        ->where('modelo', 'LIKE', "%$dato%");
      return $resultado;
    }
  }
}
