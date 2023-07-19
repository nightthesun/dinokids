<?php

namespace App;

use App\RendicionGastosForm;
use App\RendicionGastosTransporteForm;
use App\LicenciaForm;
use App\CotizacionForm;
use Illuminate\Database\Eloquent\Model;

class DataForm extends Model
{
    protected $fillable = [
        'nombre', 'sucursal', 'nro', 'area',
        'ci', 'fecha', 'user_id',
        'nombre_s', 'ci_s', 'val',
        'total', 'tipo'
    ];
    public function rendiciongastos()
    {
        return $this->belongsToMany(RendicionGastosForm::class)->withTimestamps();
    }
    public function rendiciongastostransporte()
    {
        return $this->belongsToMany(rendiciongastostransporteForm::class)->withTimestamps();
    }
    public function licencias()
    {
        return $this->belongsToMany(licenciaForm::class)->withTimestamps();
    }
    public function vacaciones()
    {
        return $this->belongsToMany(VacacionForm::class)->withTimestamps();
    }
    public function cotizaciones()
    {
        return $this->belongsToMany(CotizacionForm::class)->withTimestamps();
    }
    public function planificaciones()
    {
        return $this->belongsToMany(PlanificacionForm::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function A_user()
    {
        return $this->belongsTo(User::class, 'R_user_id');
    }
    public function R_user()
    {
        return $this->belongsTo(User::class, 'A_user_id');
    }
}
