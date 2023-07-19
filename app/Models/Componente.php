<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Componente
 *
 * @property $id
 * @property $tipo
 * @property $marca
 * @property $modelo
 * @property $caracteristicas
 * @property $estado
 * @property $id_compu
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Componente extends Model
{
    
    static $rules = [
		'tipo' => 'required',
		'marca' => 'required',
		'modelo' => 'required',
		'caracteristicas' => 'required',
		'estado' => 'required',
		'id_compu' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo','marca','modelo','caracteristicas','estado','id_compu'];



}
