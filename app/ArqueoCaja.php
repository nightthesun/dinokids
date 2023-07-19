<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArqueoCaja extends Model
{
    protected $fillable = [
        'unidad', 'moneda', 'responsable',  'fecha', 'hora', 'caja', 'cantidad200', 'importe200', 'cantidad100',
        'importe100', 'cantidad50', 'importe50', 'cantidad20', 'importe20', 'cantidad10',
        'importe10', 'BBtotal', 'C5MB', 'I5MB', 'C2MB', 'I2MB', 'C1MB', 'I1MB', 'C05MB',
        'I05MB', 'C02MB', 'I02MB', 'C01MB', 'I01MB', 'MBtotal', 'C100BDA', 'I100BDA',
        'C50BDA', 'I50BDA', 'C20BDA', 'I20BDA', 'C10BDA', 'I10BDA', 'C5BDA', 'I5BDA', 'DAtotal',
        'DABtotal', 'OBMtotal', 'ICC', 'ICCF', 'ICSF', 'IOC', 'CCtotal', 'IDCC', 'IDCC1', 'IDCC2',
        'IDCC3', 'DCtotal', 'TGB', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function firmas()
    {
        return $this->hasMany(FirmaVacacion::class, 'form_id');
    }
}
