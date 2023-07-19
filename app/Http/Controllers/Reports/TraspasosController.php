<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;

class TraspasosController extends Controller
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
        if(Auth::user()->authorizePermisos(['Traspasos', 'Ver usuarios DualBiz']))
        {
            $usuario= "";
        }
        else if (Auth::user()->authorizePermisos(['Traspasos', 'Ver usuarios OAS']))
        {
            $users= User::where('dbiz_user','<>',NULL)->get()->pluck('dbiz_user')->toArray();
            $users= implode(",", $users);
            $usuario ="AND adusrCusr IN (".$users.")";
        }
        else
        {
            if(Auth::user()->dbiz_user == null)
            {
                $usuario= "AND adusrCusr = null";
            }
            else
            {
                $usuario= "AND adusrCusr = ".Auth::user()->dbiz_user;
            }
        }
        $query = 
        "SELECT * 
        FROM bd_admOlimpia.dbo.adusr 
        WHERE adusrMdel = 0 ".$usuario."
        AND (adusrCusr IN 
        (
            SELECT intrpCres
            FROM intrp
            GROUP BY intrpCres
        ))
        ORDER BY adusrNomb";
        $user = DB::connection('sqlsrv')->select(DB::raw($query));
        return view('reports.traspasos', compact('user'));
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
        $user = "AND intrpCres IS NULL";
        if($request->options)
        {
            $user = "AND intrpCres IN (".implode(",",$request->options).")"; 
        }  
        $fini = date("d/m/Y", strtotime($request->fini));
        $ffin = date("d/m/Y", strtotime($request->ffin));
        $filtro = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
        $query =
        "SELECT 
        intrpNtrp as 'NroTrans',
        CONVERT(varchar,intrpFtrp,103) as 'Fecha',
        intrpGlos as 'Glosa',
        intrpNtrE as 'TransaccionEgreso',
        almorg.inalmNomb as 'AlmacenOrigen',
        intrpNtrI as 'TransaccionIngreso',
        almdes.inalmNomb as 'AlmacenDestino',
        soli.adusrNomb as 'Solicitante',
        resp.adusrNomb as 'Responsable',        
        --intrpDoce as '??'
        CASE intrpStat
        WHEN 0 THEN 'TRASPASO'
        WHEN 1 THEN 'SIN PROCESAR'
        WHEN 2 THEN 'PROCESADO'
        END as Tipo
        FROM intrp 
        JOIN inalm as almdes ON almdes.inalmCalm = intrpCads
        JOIN inalm as almorg ON almorg.inalmCalm = intrpCaor
        JOIN bd_admOlimpia.dbo.adusr as resp ON resp.adusrCusr = intrpCres
        LEFT JOIN malog ON maLogNtra = intrpNtrp AND malogTtra = 1 AND malogCprg IN (256, 793)
        LEFT JOIN bd_admOlimpia.dbo.adusr as soli ON soli.adusrCusr = malogCusr
        WHERE
        intrpMdel = 0
        AND (intrpFtrp BETWEEN @fini AND @ffin)
        ".$user."
        ";
        $traspasos = DB::connection('sqlsrv')->select(DB::raw($filtro.$query));
        if($request->gen =="excel")
        {
            $titles =['Codigo',
            'Fecha',
            'Glosa',
            'Trans. Egreso',
            'Alamacen Origen',
            'Trans.Ingreso',
            'Alamacen Destino',           
            'Solicitante',
            'Responsable',            
            'Tipo'];
            $export = new ExcelExport($traspasos, $titles);    
            return Excel::download($export, 'Traspasos.xlsx');
        }
        else if($request->gen =="ver")
        {
            return view('reports.vista.traspasos', compact('traspasos'));
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
