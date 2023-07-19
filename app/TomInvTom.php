<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TomInvTom extends Model
{
    protected $fillable = [
        'conteo_id',
        'user_id',
        'nro',
        'ubi',
        'suc_id',
        'fini',
        'ffin'
    ];
    public function Sucs()
    {
        return $this->belongsTo(Unidad::class, 'suc_id');
    }
    /*public function Sucs()
    {
        return $this->belongsTo(Unidad::class, 'suc_id');
    }*/
    public function Funcionarios()
    {
        return $this->belongsTo(Perfil::class, 'user_id');
    }
    public function Conts()
    {
        return $this->hasMany(TomInvCont::class, 'tom_inv_tom_id');
    }
    
}