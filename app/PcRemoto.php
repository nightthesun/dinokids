<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PcRemoto extends Model
{
    protected $fillable = [
        'tipo', 'acceso', 'password', 'pc_id'
    ];
    public function pcremoto()
    {
        return $this->belongsTo(InventarioPc::class);
    }
}
