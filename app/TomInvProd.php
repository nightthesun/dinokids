<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TomInvProd extends Model
{
    protected $fillable = [
        'conteo_id',
        'marca',
        'prod',
        'descrip',
        'barcod',
        'cantidad',
        'ubi_id',
        'suc_id',
        'um',
        'user_id',
        'nuevo',
        'cont_id',
        'hoja',
        'prod_ubi_id',
        'stock_t',
        'stock_t'
    ];
    public function Tomas($tom_id)
    {
        $prod = $this->whereHas('conts', function ($query ) use ($tom_id) {
            return $query->where('tom_inv_tom_id', '=', $tom_id);
        })->with(['Conts', 'Ubi'])->get();
        return $prod;
    }
    public function Conts()
    {
        return $this->belongsTo(TomInvCont::class, 'cont_id');
    }
    public function Ubi()
    {
        return $this->belongsTo(TomInvProdUbi::class, 'prod_ubi_id');
    }
}
