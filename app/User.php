<?php

namespace App;

use App\Role;
use App\Form;
use App\Permiso;
use App\SubModulo;
use App\Modulo;
use App\User;
use App\Acceso;
use Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'val','dbiz_user', 'password', 'elim'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];  

    public function forms()
    {
        return $this->belongsToMany(Form::class)->withTimestamps();
    }

    public function perfiles()
    {
        return $this->hasOne(Perfil::class, 'user_id');
    }

    
    public function tieneModulo($sm)
    {
        $user = Auth::user();
        $modulo = Modulo::find($sm);
        $acces = Acceso::where('user_id', $user->id)->get();
        foreach($acces as $ac)
        {          
            if(Program::find($ac->program_id) && $mod = Program::find($ac->program_id)->modulos)
            {
                if($mod->id == $sm)
                {
                    return true;
                }
            } 
            elseif(Program::find($ac->program_id) && $mod = Program::find($ac->program_id)->submodulos->modulos)
            {
                if($mod->id == $sm)
                {
                    return true;
                }
            } 
        }
        return false;
    }

    public function tieneSubModulo($sm)
    {
        $user = Auth::user();
        $submodulo = SubModulo::find($sm);
        $acces = Acceso::where('user_id', $user->id)->get();
        foreach($acces as $ac)
        {
            if($submod = Program::find($ac->program_id)->submodulos)
            {
                if($submod->id == $sm)
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function authorizePermisos($permisos)
    {
        if(count($permisos)>1)
        {
            $state = $this->hasPermiso($permisos[0], $permisos[1]);
            return $state;
        }
        else
        {
            return dd('La variable: '.$permisos[0].' no sirve We');
        }
        //Para varios permisos, inpresar solo una variable.
        //$state = $this->hasAnyPermisos($permisos);
        //return $state;
    }
    
    public function hasAnyPermisos($permisos)
    {
        if (is_array($permisos)) {
            foreach ($permisos as $per) {
                if ($this->hasPermiso($per[0], $per[1])) {
                    return true;
                }
            }
        } else {
            if ($this->hasPermiso($p, $p2)) {
                 return true; 
            }   
        }
        return false;
    }
    
    public function hasPermiso($p, $p2)
    {
        $program = Program::where('nombre', $p)->first();
        $perm = Permiso::where('p', $p2)->first();
        $user = Auth::user();
        if($program && $perm &&(Acceso::where('program_id',$program->id)
        ->where('permiso_id', $perm->id)
        ->where('user_id', $user->id)
        ->first()))
        {
            return true;
        }               
        return false;
    }
    
    public function tienePermiso($program, $permiso)
    {
        if(Acceso::where('program_id',$program)
        ->where('permiso_id', $permiso)
        ->where('user_id', $this->id)
        ->first())
        {
            return true;
        }               
        return false;
    }

}
