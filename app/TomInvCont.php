<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TomInvCont extends Model
{
    protected $fillable = [
        'conteo_id', 'tom_inv_tom_id', 'user_id', 'estado'
    ];
    public function Funcionarios()
    {
        return $this->belongsTo(Perfil::class, 'user_id');
    }
    public function Toma()
    {
        return $this->belongsTo(TomInvTom::class, 'tom_inv_tom_id');
    }
    public function Prods()
    {
        return $this->hasMany(TomInvProd::class, 'cont_id');
    }
}
