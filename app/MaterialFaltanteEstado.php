<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialFaltanteEstado extends Model
{
    protected $fillable = [
        'estado', 'descripcion', 'user_id'
    ];
    public function materialfantantes()
    {
        return $this->belongsTo(CotizacionForm::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
