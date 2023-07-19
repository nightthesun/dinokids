<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionEstado extends Model
{
    protected $fillable = [
        'estado', 'descripcion'
    ];
    public function cotizaciones()
    {
        return $this->belongsTo(CotizacionForm::class);
    }
}
