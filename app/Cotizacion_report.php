<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Cotizacion_report extends Model
{
    protected $table = 'observacion_cotizacions';// llamada de la tabla observacion
    protected $fillable = ['id','idObs','textObs','user_id','nroMod','nro','nroA','nroP','nroT','fechaC'];

    public function estadosS()
    {
    
       return $this->belongsTo(observacion_estados::class,'cotizacion_form_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
