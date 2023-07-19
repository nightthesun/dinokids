<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionGastosViaticoForm extends Model
{
    protected $fillable = [
        'saldo', 'user_id', 'tipo_gasto'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function dataform()
    {
        return $this->hasMany(RendicionGastosViaticoDataForm::class);
    }
    public function firmas()
    {
        return $this->hasMany(FirmaRendicionGastosViatico::class, 'form_id');
    }
}
