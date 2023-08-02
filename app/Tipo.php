<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
  protected $fillable = [
    'name','decription'
];
public function personas()
{
    return $this->hasMany(Personas::class, 'id_tipo');
}
}
