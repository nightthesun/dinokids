<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionFondoFijoForm extends Model
{
    protected $fillable = [
        'total_asignado', 'saldo_final', 'total_reponer',
        'user_id', 'unidad_id', 'fecha_ini', 'fecha_fin', 'estado'
     ];
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
     public function firmas()
     {
         return $this->hasMany(FirmaRendicionFondoFijo::class, 'form_id');
     }
     public function fondodata()
    {
        return $this->hasMany(RendicionFondoFijoDataForm::class, 'fondo_id');
    }
}
