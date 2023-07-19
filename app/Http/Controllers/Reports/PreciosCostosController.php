<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;

class PreciosCostosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $lista_precio = 
        "SELECT * 
        FROM vtlis 
        WHERE vtLisMdel = 0 
        AND vtLisActv = 1
        AND vtlisClis NOT IN(23,26,27,28)";
        $almacen = 
        "SELECT * 
        FROM inalm 
        JOIN inloc ON inlocCloc = inalmCloc
        WHERE inalmMdel = 0 AND inalmStat = 1
        ORDER BY inalmCloc";
        $locales = 
        "SELECT * 
        FROM inloc 
        WHERE inlocMdel = 0 AND inlocStat = 0";
        $local = DB::connection('sqlsrv')->select(DB::raw($locales));
        $almacen = DB::connection('sqlsrv')->select(DB::raw($almacen));
        $lista = DB::connection('sqlsrv')->select(DB::raw($lista_precio));
        $loc_alm = [];
        foreach ($local as $loc) {
            foreach ($almacen as $kalm => $alm) {
                if($alm->inalmCloc == $loc->inlocCloc)
                {
                    $loc_alm[$loc->inlocNomb][]=$almacen[$kalm];
                }                
            }
        }
        $loc_lis = [];
        foreach ($local as $loc) {
            foreach ($lista as $klis => $lis) {
                if($lis->vtLisCloc == $loc->inlocCloc)
                {
                    $loc_lis[$loc->inlocNomb][]=$lista[$klis];
                }                
            }
        }
        return view('reports.precioscostos', compact('loc_lis', 'loc_alm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->alm_options)
        {
            $almacen = '['.implode("],[",$request->alm_options).']';
        }
        if($request->lis_options)
        {
            foreach ($request->lis_options as $value) {
                $lista[] = "[".$value."]";
                $lista_select[]="CONVERT(VARCHAR, cast(ISNULL([".$value."],0) as money),1) as [".$value."]";
            }  
            $lista_piv = implode(",",$lista);         
        } 
        //return dd($lista);
        $query= "SELECT
        codProd, Descrip,
        ".implode(',',$lista_select)."
        FROM
        (
        SELECT 
            --vtLidClis as 'codlis',
            inproCpro as 'codProd',
            inproNomb as Descrip,
            vtLisDesc as 'Lista',				
            vtLidPrco as 'Precio'
            --vtLidCmon as 'Moneda',
            --vtLidDscu as 'Descuento',
            --vtLidActv as 'Activo = 1 Deshab = 0',
            --vtLidTipo as 'Tipo 1=Prod 2=Servicios'
            --vtLidTcom as 'Tio Comision 1=IMPORTE 2=PORCENTUAL',
            --vtLidMcom as 'Comision'
            FROM inpro
            LEFT JOIN vtLid ON vtLidCpro = inproCpro
            JOIN vtLis ON vtLisClis = vtLidClis AND vtLisMdel = 0
            WHERE inproMdel = 0 AND inproStat = 0
        ) as precio
        pivot
        (
          max(precio.Precio)
          for precio.Lista IN (
              ".$lista_piv."
            )
        ) as lista
        ";
        $preciocosto = DB::connection('sqlsrv')->select(DB::raw($query));
        $titulos = $request->lis_options;
        if($request->gen =="export")
        {
            $pdf = \PDF::loadView('reports.pdf.cuentasporcobrar', compact('cxc', 'sum', 'sum_estado', 'fecha'))
            ->setOrientation('landscape')
            ->setPaper('letter')
            ->setOption('footer-right','Pag [page] de [toPage]')
            ->setOption('footer-font-size',8);
            return $pdf->inline('Cuentas Por Cobrar Al_'.$fecha.'.pdf');
        }
        elseif($request->gen =="excel")
        {
            $titles = ['Codigo', 'Descrip'];
            foreach ($titulos as $key => $value) {
                $titles[] = $value;
            }
            $export = new ExcelExport($preciocosto, $titles);    
            return Excel::download($export, 'PRECIOSCOSTOS.xlsx');
        }
        else if($request->gen =="ver")
        {
            $titles = [['data'=>'codProd','title'=>'Codigo'], ['data'=>'Descrip','title'=>'Descrip']];
            foreach ($titulos as $key => $value) {
                $titles[] = ['data'=>$value,'title'=>$value];
            }
            return view('reports.vista.precioscostos', compact('preciocosto', 'titles'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
