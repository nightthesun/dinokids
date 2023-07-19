<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempStockParam extends Model
{
    protected $fillable = [
        'user_id', 'alm_id'
    ];     
}
