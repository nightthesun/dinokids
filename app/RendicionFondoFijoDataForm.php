<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionFondoFijoDataForm extends Model
{
    protected $fillable = [
        'fecha', 'centro_c', 'cuenta_c', 'user_id', 'razon_s', 
        'concepto', 'n_fac','n_recib', 'debe', 'haber', 'saldo', 'fondo_id', 'estado'
    ];
    public function fondo()
    {
        return $this->belongsTo(RendicionFondoFijoForm::class, "fondo_id");
    }
    public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
}
