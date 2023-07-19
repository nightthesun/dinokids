<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermisoProgram extends Model
{
    protected $table = 'permiso_programs';

    protected $fillable = [
        'permiso_id', 'program_id'
    ];
}