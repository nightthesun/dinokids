<?php

namespace App;

use App\DataForm;
use Illuminate\Database\Eloquent\Model;

class RendicionGastosTransporteForm extends Model
{
    protected $fillable = [
        'total', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function gastostransportes()
    {
        return $this->hasMany(RendicionGastosTransporteDataForm::class);
    }
    public function firmas()
    {
        return $this->hasMany(FirmaRendicionGastosTransporte::class, 'form_id');
    }
}
