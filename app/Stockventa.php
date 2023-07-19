<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stockventa extends Model
{
    protected $fillable = [
      'catprod','codprod','desprod','umprod','canprod','alm_origen','alm_destino','cod_user'
    ];
}
