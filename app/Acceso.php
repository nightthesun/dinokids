<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    
    protected $fillable = [
        'user_id','permiso_id', 'program_id'
    ];
}
