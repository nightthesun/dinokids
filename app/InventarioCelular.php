<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioCelular extends Model
{
    protected $fillable = [
        'imei', 'num_serie', 'nombre_comercial', 'modelo', 'marca', 'color',
        'pantalla', 'rom', 'cpu', 'ram', 'camara_principal', 'camara_frontal', 
        'so', 'sd', 'bateria', 'linea', 'cargador', 'cable_usb', 'audifonos'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
