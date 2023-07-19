<?php

namespace App;

use App\Modulo;
use App\Permiso;
use Auth;
use Route;
use Illuminate\Database\Eloquent\Model;

class SubModulo extends Model
{
    protected $fillable = [
        'nombre', 'desc', 'modulo_id', 'route'
     ];
     
    public function modulos()
    {        
        return $this->belongsTo(Modulo::class, 'modulo_id');
    }
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    public function programs_activ($submod)
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
