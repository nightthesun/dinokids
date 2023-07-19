<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialFaltante extends Model
{
    protected $fillable = [
        'codigo', 'material', 'cantidad', 'coment', 'motivo', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function estados()
    {
        return $this->hasmany(MaterialFaltanteEstado::class);
    }
}
