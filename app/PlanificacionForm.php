<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanificacionForm extends Model
{
    protected $fillable = [
        'activ', 'estado', 'coment', 'user_id', 'fecha', 'post'
    ];
    public function dataforms()
    {
        return $this->belongsToMany(DataForm::class)->withTimestamps();
    }
    public function scopeFecha($query, $fecha)
    {
      if($fecha)
      { 
        return $query->where('fecha', 'LIKE', "%$fecha%");
      }
        
    }
    public function scopeFechap($query, $fecha, $user_id)
    {
      if($fecha)
      { 
        return $query
          ->where('fecha', 'LIKE', "%$fecha%");

      }
        
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
