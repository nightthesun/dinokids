<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OdooSotck extends Model
{
    protected $fillable = [
        'codigo', 'descrip', 'stock'
    ];
}
