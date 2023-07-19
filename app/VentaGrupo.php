<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaGrupo extends Model
{
    protected $fillable = [
        'title', 'abre', 'name', 'id_segmento'
    ];
}
