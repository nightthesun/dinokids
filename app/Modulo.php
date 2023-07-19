<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Route;
class Modulo extends Model
{
    protected $fillable = [
        'nombre', 'desc'
     ];
     public function submodulos()
     {
         return $this->hasMany(SubModulo::class);
     }
     public function programs()
     {
         return $this->hasMany(Program::class);
     }
     public function programs_activ($mod)
     {
        foreach($mod->submodulos as $submod)
        {
            if(Auth::user()->tieneSubModulo($submod->id))
            {
                foreach($submod->programs as $prog)
                {
                    if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) 
                    && $prog->sub_modulo_id
                    && $prog->route == Route::currentRouteName()
                    )
                    {
                        return true;
                    }
                }
                
            }
        } 
        foreach($mod->programs as $prog)
        { 
            if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) 
            && !$prog->sub_modulo_id
            && $prog->route == Route::currentRouteName()
            )
            {
                return true;
            }
        }
            
    }
}
