<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB; 
use DataTables; 

class ParetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.pareto');
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
        $fini = date("d/m/Y", strtotime($request->fini));  
        $ffin = date("d/m/Y", strtotime($request->ffin));
        $qpareto = 
        "WITH vent AS
        (
            SELECT vtvtdCpro as prod,
            SUM(vtvtdCant) as cant, 
            SUM(vtvtdImpT-vtvtdDesT) as total
            FROM vtvtd
            JOIN vtVta ON vtvtaNtra = vtvtdNTra
            WHERE vtvtdMdel = 0 AND vtvtaFtra BETWEEN '".$fini."' AND '".$ffin."'
            GROUP BY vtvtdCpro
        ), ventP AS
        (
            SELECT prod,cant, total, total*100/(SELECT SUM(total) as total FROM vent) as partic
            FROM vent	
        ), fin AS
        (
            SELECT *,
            SUM(SUM(partic)) OVER (ORDER BY partic DESC) AS particAcum
            FROM ventP
            GROUP BY prod,cant,total,partic
        ), pareto AS
        (
            SELECT *,
            CASE 
                WHEN particAcum <=80 THEN 'A' 
                WHEN particAcum > 80 AND particAcum <=95 THEN 'B' 
                WHEN particAcum > 95 THEN 'C' 
            END as clas
            FROM fin 
        )
        ";
        if($request->pareto == "pareto"){
            $pareto = DB::connection('sqlsrv')
            ->select(DB::raw($qpareto. 
            "SELECT prod,cant,
            CONVERT(varchar,CAST(total as money),1) as totalf,
            CONVERT(varchar,CAST(partic as decimal(20,2)),1) as partic,
            CAST(particAcum as decimal(20,2)) as particAcum, clas, total as Gtot
            FROM pareto ORDER BY total DESC"
        ));
            return Datatables::of($pareto)->make();  
        }
        else if ($request->pareto == "analisis"){
            $paretoA = DB::connection('sqlsrv')
            ->select(DB::raw
            ($qpareto. 
            ", paretoF AS(
                SELECT clas, CAST(COUNT(clas) as float) as n, SUM(total) as ventas
                FROM pareto
                GROUP BY clas
            )
            SELECT clas, n as ene, CAST(n*100/(SELECT SUM(n) as n FROM paretoF) as decimal(20,2)) as particN, 
            CAST(Ventas as money) as Ventas, 
            CAST(ventas*100/(SELECT SUM(ventas) as ventas FROM paretoF) as decimal(20,2)) as particVentas
            FROM paretoF
            "));
            return Datatables::of($paretoA)->make();  
        }
        //return response()->json($pareto); 
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
