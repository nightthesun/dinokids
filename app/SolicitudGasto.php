<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudGasto extends Model
{
    protected $fillable = [
        'fecha', 'centro_c', 'cuenta_c', 'detalle', 'monto', 'motivo', 'perfil_id', 'estado'
    ];
    
}
