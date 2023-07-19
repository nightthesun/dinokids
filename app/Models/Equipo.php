<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipo
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
 * @property Empleado $empleado
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Equipo extends Model
{
    
    static $rules = [
		'marca' => 'required',
		'tipo' => 'required',
		'modelo' => 'required',
		'ns' => 'required',
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
    protected $fillable = ['marca','tipo','modelo','ns','caracteristicas','estado','id_empleado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function empleado()
    {
      return $this->hasOne('App\Perfil', 'id', 'id_empleado');
    }
    

}
