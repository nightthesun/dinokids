<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $fillable = [
        'desc', 'p'
    ];
    
    public function programs()
    {
        return $this->belongsToMany(Program::class)->withTimestamps();
    }
}
