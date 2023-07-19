<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionGastosTransporteDataForm extends Model
{
    protected $fillable = [
        'fecha','hora_ini', 'hora_fin', 'razon_s', 'centro_c', 'motivo', 'monto'
    ];
}
