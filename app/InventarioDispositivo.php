<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioDispositivo extends Model
{
    protected $fillable = [
        'marca', 'modelo', 'num_serie', 'tipo', 'fecha_ingreso',
         'pc_id', 'caracteristicas', 'estado', 'ubicacion'
    ];
    public function scopeTipo($query, $tipo)
    {
        if($tipo)
        {
            return $query->where('tipo', 'LIKE', "%$tipo%");
        }
    }
    public function pc()
    {
        return $this->belongsTo(InventarioPc::class);
    }
}
