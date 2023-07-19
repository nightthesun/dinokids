<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionGastosViaticoDataForm extends Model
{
    protected $fillable = [
        'fecha', 'centro_c', 'n_fac', 'n_recibo', 'proveedor', 'importe', 'detalle', 'tipo'
    ];
}
