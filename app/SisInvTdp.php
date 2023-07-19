<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SisInvTdp extends Model
{
    protected $fillable = [
        'name', 'desc', 'icon'
    ];
    public function SisInvFea()
    {
        //return $this->hasMany(Perfil::class, 'unidad_id');
    }
    
}
