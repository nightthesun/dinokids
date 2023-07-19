<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $fillable = [
        'nombre', 'descrip'
    ];
    public function perfiles()
    {
        return $this->hasMany(Perfil::class, 'unidad_id');
    }
}
