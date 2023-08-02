<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
  protected $fillable = [
    'name','description'
];
public function personas()
{
    return $this->hasMany(Personas::class, 'id_branch');
}
}
