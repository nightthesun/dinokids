<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TraspasoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cabecera = 
        "SELECT 
        intrpNtrp as 'NroTrans',
        CONVERT(varchar,intrpFtrp,103) as 'Fecha',
        intrpGlos as 'Glosa',
        intrpNtrE as 'TransEgreso',
        almorg.inalmNomb as 'AlmacenOrigen',
        intrpNtrI as 'TransIngreso',
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
        LEFT JOIN malog ON maLogNtra = CAST(intrpNtrp as varchar) AND malogTtra = 1 AND malogCprg IN (256, 793) 
        LEFT JOIN bd_admOlimpia.dbo.adusr as soli ON soli.adusrCusr = malogCusr
        WHERE intrpNtrp = ".$request->id." AND intrpMdel = 0";
        $t_cab = DB::connection('sqlsrv')->select(DB::raw($cabecera));
        $detalle =
        "SELECT 
        intpdItem as 'Item',
        intpdCpro as 'Codigo',
        inproNomb as 'Descrip',
        intpdCanB as 'Cantidad',
        inumeAbre as 'UM'
        FROM intpd
        LEFT JOIN inpro ON inproCpro = intpdCpro AND inproMdel = 0
        LEFT JOIN inume ON inumeCume = intpdCumb AND inumeMDel = 0
        WHERE intpdNtrp = ".$request->id." AND intpdMdel = 0
        "; 
        $t_det = DB::connection('sqlsrv')->select(DB::raw($detalle));
        return response()->json(['detalle'=>$t_det, 'cabecera'=>$t_cab]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

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
