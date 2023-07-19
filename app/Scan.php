<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [
        'scan', 'name', 'ext'
    ];
    public function s_cotizaciones()
    {
        return $this->belongsToMany(CotizacionForm::class)->withTimestamps();
    }
}
