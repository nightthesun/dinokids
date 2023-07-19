<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionGastosDataForm extends Model
{
    protected $fillable = [
        'fecha', 'razon_s', 'centro_c', 'detalle', 'no_fac', 'monto', 
        'cuenta_c','tipo','gasto_id',
    ];
    
}
