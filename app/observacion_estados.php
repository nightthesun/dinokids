<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class observacion_estados extends Model
{
    protected $table = 'observacion_estados';
    protected $fillable = [
        'id','estado', 'textObs1','textObs2','cotizacion_form_id','created_at','updated_at'
    ];
    public function cotizaciones()
    {
        return $this->belongsTo(Cotizacion_report::class);
    }
}
