<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'nombre','descip'
    ];
    public function perfiles()
    {
        return $this->hasMany(Perfil::class, 'area_id');
    }
}
