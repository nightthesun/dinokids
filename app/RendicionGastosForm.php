<?php

namespace App;

use App\DataForm;
use Illuminate\Database\Eloquent\Model;

class RendicionGastosForm extends Model
{
    protected $fillable = [
       'total', 'user_id', 'fecha_ini', 'fecha_fin'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function gastos()
    {
        return $this->hasMany(RendicionGastosDataForm::class);
    }
    public function firmas()
    {
        return $this->hasMany(FirmaRendicionGastos::class, 'form_id');
    }
    public function fondofijodata()
    {
        return $this->belongsToMany(RendicionFondoFijoDataForm::class, 'fondofijo_gastos', 'fondofijo_id', 'gasto_id');
    }
}
