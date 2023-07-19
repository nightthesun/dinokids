<?php

namespace App;

use App\Modulo;
use App\Permiso;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'nombre', 'desc', 'sub_modulo_id','modulo_id', 'route', 'icon'
     ];
    public function submodulos()
    {        
        return $this->belongsTo(SubModulo::class, 'sub_modulo_id');
    }
    public function modulos()
    {        
        return $this->belongsTo(Modulo::class, 'modulo_id');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class)->withTimestamps();
    }
}
