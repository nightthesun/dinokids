<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioPc extends Model
{
    protected $fillable = [
        'perfil_id', 'area', 'ip', 'funcionario', 'ci',
        'estado', 'ubicacion', 'observaciones', 'nombre', 'tipo', 'area_id', 'unidad_id'
    ];
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }
    public function dispositivo()
    {
        return $this->hasMany(InventarioDispositivo::class, 'pc_id');
    }
    public function remoto()
    {
        return $this->hasMany(PcRemoto::class, 'pc_id');
    }
    public function areas()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function unidades()
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }
}
