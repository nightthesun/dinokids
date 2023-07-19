<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

/**
 * Class Empleado
 *
 * @property $id
 * @property $nombre
 * @property $paterno
 * @property $materno
 * @property $ci
 * @property $area
 * @property $cargo
 * @property $sucursal
 * @property $created_at
 * @property $updated_at
 *
 * @property Equipo[] $equipos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Empleado extends Model
{

  static $rules = [
    'nombre' => 'required',
    'paterno' => 'required',
    'materno' => 'required',
    'ci' => 'required|unique:empleados',
    'area' => 'required',
    'cargo' => 'required',
    'sucursal' => 'required',
    'ip' => 'required',
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['nombre', 'paterno', 'materno', 'ci', 'area', 'cargo', 'sucursal', 'ip'];


  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function equipos()
  {
    return $this->hasMany('App\Models\Equipo', 'id_empleado', 'id');
  }

  public function scopeUser($query, $buscar, $dato)
  {
    if ($buscar == 1 && $dato != '') {
      $resultado = Empleado::orderBy('id','DESC')
        ->select('empleados.*')
        ->where('nombre', 'LIKE', "%$dato%");
      return $resultado;
    } elseif ($buscar == 2 && $dato != '') {
      $resultado = Empleado::orderBy('id','DESC')
        ->select('empleados.*')
        ->where('nombre', 'LIKE', "%$dato%");
      return $resultado;
    }
  }
}
