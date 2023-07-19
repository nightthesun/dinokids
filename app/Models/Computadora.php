<?php

namespace App\Models;

use Componentes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Computadora
 *
 * @property $id
 * @property $tipo
 * @property $ip
 * @property $estado
 * @property $created_at
 * @property $updated_at
 * @property Componente[] $equipos
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Computadora extends Model
{

  static $rules = [
    'tipo' => 'required',
    'ip' => 'required',
    'estado' => 'required',
    'id_empleado' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['tipo', 'ip', 'estado', 'id_empleado'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function empleados()
  {
    return $this->hasMany('App\Models\Empleado', 'id_empleado', 'id');
  }
  public function componentes()
  {
    return $this->hasMany('App\Models\Componente', 'id_compu', 'id');
  }
}
