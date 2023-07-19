<?php

namespace App;

use App\DataForm;
use App\Scan;
use Illuminate\Database\Eloquent\Model;


class CotizacionForm extends Model
{
    protected $fillable = [
        'empresa', 'unid', 'nombre_resp', 'nombre_contac', 'OV', 'n_lic',
        'telf_contac', 'descrip', 'estado',
        'segui', 'segui_descrip', 'entrega', 'entrega_descrip', 'nro', 'nit', 'user_id' 
    ];
    public function scopeNit($query, $nit)
    {
        if($nit)
        {
            return $query->where('nit', 'LIKE', "%$nit%");
        }
    }
    public function scopeEmpresa($query, $empresa)
    {
        if($empresa)
        {
            return $query->where('empresa', 'LIKE', "%$empresa%");
        }
    }
    public function scans()
    {
        return $this->belongsToMany(Scan::class)->withTimestamps();
    }
    public function estados()
    {
        return $this->hasmany(CotizacionEstado::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
