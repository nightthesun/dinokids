<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ResumenVentasCobrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.resumenventascobros');
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
        $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
        $bancos_q= 
        "SELECT cbcbaCcba, CONCAT(cbcbaCtaB, '(',admonAbrv,')') as banco
        FROM cbCba
        JOIN crent ON crentCent = cbcbaCent
        JOIN bd_admOlimpia.dbo.admon ON admonCmon = cbcbaCmon
        ";
        $bancos = DB::connection('sqlsrv')->select(DB::raw($bancos_q));
        $bid = [];
        $bna = [];
        $bsum = [];
        $bdesc = [];
        foreach ($bancos as $key => $value) {
            $bid[] = "[".$value->cbcbaCcba."]";
            $bna[] = 
            "SUM(ISNULL([".$value->cbcbaCcba."],0)) as [". $value->cbcbaCcba. "]";
            $bsum[] = "SUM(banc.[".$value->cbcbaCcba."]) as [". $value->cbcbaCcba. "]";
            $bdesc[] = "REPLACE(cast(ROUND(ISNULL([".$value->cbcbaCcba."],0),2) as decimal(10,2)),',', '.') as [".$value->banco."]"; 
            $btitle[$value->cbcbaCcba]= $value->banco;
        }
        $bid = implode(",",$bid);
        $bna = implode(",",$bna);
        $bsum = implode(",",$bsum);
        $bdesc = implode(",",$bdesc);

        $ventas = 
        "SELECT
        vloc.inlocNomb as 'local',
        ventas.tip as grupo,
        vmon.admonAbrv as 'moneda',
        REPLACE(cast(ROUND(ISNULL(tot,0),2) as decimal(10,2)),',', '.') as 'tot',
        REPLACE(cast(ROUND(ISNULL(efe,0),2) as decimal(10,2)),',', '.') as 'efe',
        REPLACE(cast(ROUND(ISNULL(ban,0),2) as decimal(10,2)),',', '.') as 'ban',
        REPLACE(cast(ROUND(ISNULL(cxc,0),2) as decimal(10,2)),',', '.') as 'cxc',
        REPLACE(cast(ROUND(ISNULL(tar,0),2) as decimal(10,2)),',', '.') as 'tar',
        REPLACE(cast(ROUND(ISNULL(Mot,0),2) as decimal(10,2)),',', '.') as 'mot',
        REPLACE(cast(ROUND(ISNULL(Otr,0),2) as decimal(10,2)),',', '.') as 'otr',
        REPLACE(cast(ROUND(ISNULL([1],0),2) as decimal(10,2)),',', '.')  as b1,
        REPLACE(cast(ROUND(ISNULL([2],0),2) as decimal(10,2)),',', '.')  as b2,
        REPLACE(cast(ROUND(ISNULL([3],0),2) as decimal(10,2)),',', '.')  as b3,
        REPLACE(cast(ROUND(ISNULL([4],0),2) as decimal(10,2)),',', '.')  as b4,
        REPLACE(cast(ROUND(ISNULL([5],0),2) as decimal(10,2)),',', '.')  as b5,
        REPLACE(cast(ROUND(ISNULL([6],0),2) as decimal(10,2)),',', '.')  as b6,
        REPLACE(cast(ROUND(ISNULL([7],0),2) as decimal(10,2)),',', '.')  as b7,
        REPLACE(cast(ROUND(ISNULL([8],0),2) as decimal(10,2)),',', '.')  as b8
        FROM 
        (
        --VENTAS
        SELECT Tip, loc, mon,
        SUM(tot) as 'tot',
        SUM(efe) as 'efe',
        SUM(ban) as 'ban',
        SUM(cxc) as 'cxc',
        SUM(tar) as 'tar',
        SUM(Mot) as 'mot',
        SUM(Otr) as 'otr'
        FROM
        (
            SELECT 
            CASE         
                WHEN cptraCusr IN (22,23,24,49,41,46) THEN 'BALLIVIAN'
                WHEN cptraCusr IN (25,26,27,50,42,28) THEN 'HANDAL'
                WHEN cptraCusr IN (32,33,34,52,43,29,57) THEN 'CALACOTO' 
                WHEN cptraCusr IN (35,36,38,51,44,37) THEN 'MARISCAL'   
                WHEN cptraCusr IN (4/*,7,2,5,3*/) THEN 'OTROS'
                ELSE adusrNomb
            END as tip,
            cptraCusr as 'usr', 
            cptraCloc as 'loc',  
            SUM(cptraImpT) as 'tot', 
            cptraMtra as 'mon', SUM(cptraCajS) as 'efe', 
            SUM(cptraBanS) as 'ban', SUM(cptraCxcS) as 'cxc', SUM(cptraTarS) as 'tar', 
            SUM(cptraMcnS) as 'Mot', SUM(cptraCheS+cptraCmpS+cptraOpPd) as 'Otr'
            FROM cptra
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21 AND (cptraCloc IS NOT NULL)
            AND cptraCusr NOT IN (9)
            GROUP BY cptraCusr, adusrNomb, cptraCloc, cptraMtra
        ) as resumen
        GROUP BY tip,  loc, mon
        ) as ventas
        FULL OUTER JOIN
        (
        --BANCOS VENTAS
        SELECT 
            grupo,cbbtrCloc, 
            SUM([1]) as [1],
            SUM([2]) as [2],
            SUM([3]) as [3],
            SUM([4]) as [4],
            SUM([5]) as [5],
            SUM([6]) as [6],
            SUM([7]) as [7],
            SUM([8]) as [8]
        FROM
        (
            SELECT 
            CASE         
            WHEN cbbtrCusr IN (22,23,24,49,41,46) THEN 'BALLIVIAN'
            WHEN cbbtrCusr IN (25,26,27,50,42,28) THEN 'HANDAL'
            WHEN cbbtrCusr IN (32,33,34,52,43,29,57) THEN 'CALACOTO' 
            WHEN cbbtrCusr IN (35,36,38,51,44,37) THEN 'MARISCAL'   
            WHEN cbbtrCusr IN (4,47,7,2,5,3) THEN 'OTROS'
            ELSE adusrNomb
            END as grupo,
            cbbtrCusr,
            cbbtrCloc, 
            SUM([1]) as [1],SUM([2]) as [2],SUM([3]) as [3],SUM([4]) as [4],
            SUM([5]) as [5],SUM([6]) as [6],SUM([7]) as [7],SUM([8]) as [8] --,  cbbtrCent, cbbtrCcba, cbbtrCmon
            FROM 
            (
            SELECT * FROM cbbtr
            )cbbtr
            PIVOT
            (
                SUM(cbbtrImpo)
                FOR cbbtrCcba IN (".$bid.")
            ) as b
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cbbtrCusr 
            JOIN cptrd ON cptrdNtrD = cbbtrNtra AND cptrdTtra = 12
            JOIN cptra ON cptraNtra = cptrdNtra AND cptraMdel = 0 AND cptraTtra = 21
            WHERE cbbtrMdel = 0 AND cbbtrTtra = 1 AND (cbbtrCloc IS NOT NULL)
            GROUP BY cbbtrCusr,adusrNomb,cbbtrCloc
        ) as resumen
        GROUP BY grupo, cbbtrCloc
        ) as vbanco
        ON vbanco.grupo = ventas.tip AND vbanco.cbbtrCloc = ventas.loc
        LEFT JOIN bd_admOlimpia.dbo.admon as vmon ON ventas.mon = vmon.admonCmon
        LEFT JOIN inloc as vloc ON ventas.loc = vloc.inlocCloc
        ORDER BY vloc.inlocNomb
        ";
        $resum = DB::connection('sqlsrv')->select(DB::raw($vari . $ventas));
        $resumen=[];
        foreach ($resum as $key => $value) {
            if (!array_key_exists($value->local, $resumen)) 
            {
                $resumen[$value->local] = [$resum[$key]];
            }
            else
            {
                array_push($resumen[$value->local], $resum[$key]);
            }
        }
        $cobros = 
        "SELECT
        vloc.inlocNomb as 'local',
        ventas.tip as grupo,
        vmon.admonAbrv as 'moneda',
        REPLACE(cast(ROUND(ISNULL(tot,0),2) as decimal(10,2)),',', '.') as 'tot',
        REPLACE(cast(ROUND(ISNULL(efe,0),2) as decimal(10,2)),',', '.') as 'efe',
        REPLACE(cast(ROUND(ISNULL(ban,0),2) as decimal(10,2)),',', '.') as 'ban',
        REPLACE(cast(ROUND(ISNULL(cxc,0),2) as decimal(10,2)),',', '.') as 'cxc',
        REPLACE(cast(ROUND(ISNULL(tar,0),2) as decimal(10,2)),',', '.') as 'tar',
        REPLACE(cast(ROUND(ISNULL(Mot,0),2) as decimal(10,2)),',', '.') as 'mot',
        REPLACE(cast(ROUND(ISNULL(Otr,0),2) as decimal(10,2)),',', '.') as 'otr'
        FROM 
        (
        --VENTAS
        SELECT Tip, loc, mon,
        SUM(tot) as 'tot',
        SUM(efe) as 'efe',
        SUM(ban) as 'ban',
        SUM(cxc) as 'cxc',
        SUM(tar) as 'tar',
        SUM(Mot) as 'mot',
        SUM(Otr) as 'otr'
        FROM
        (
            SELECT 
            CASE         
                WHEN cptraCusr IN (22,23,24,49,41,46) THEN 'BALLIVIAN'
                WHEN cptraCusr IN (25,26,27,50,42,28) THEN 'HANDAL'
                WHEN cptraCusr IN (32,33,34,52,43,29,57) THEN 'CALACOTO' 
                WHEN cptraCusr IN (35,36,38,51,44,37) THEN 'MARISCAL'   
                WHEN cptraCusr IN (4/*,7,2,5,3*/) THEN 'OTROS'
                ELSE adusrNomb
            END as tip,
            cptraCusr as 'usr', 
            cptraCloc as 'loc',  
            SUM(cptraImpT) as 'tot', 
            cptraMtra as 'mon', SUM(cptraCajS) as 'efe', 
            SUM(cptraBanS) as 'ban', SUM(cptraCxcS) as 'cxc', SUM(cptraTarS) as 'tar', 
            SUM(cptraMcnS) as 'Mot', SUM(cptraCheS+cptraCmpS+cptraOpPd) as 'Otr'
            FROM cptra
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21 AND (cptraCloc IS NOT NULL)
            AND cptraCusr NOT IN (9)
            GROUP BY cptraCusr, adusrNomb, cptraCloc, cptraMtra
        ) as resumen
        GROUP BY tip,  loc, mon
        ) as ventas
        LEFT JOIN bd_admOlimpia.dbo.admon as vmon ON ventas.mon = vmon.admonCmon
        LEFT JOIN inloc as vloc ON ventas.loc = vloc.inlocCloc
        ORDER BY vloc.inlocNomb
        ";
        $resum_c = DB::connection('sqlsrv')->select(DB::raw($vari . $cobros));
        if($request->gen =="export")
        {
            $pdf = \PDF::loadView('reports.pdf.resumenventastotal', compact('resumen', 'ffin', 'fini', 'total', 'totalgen'))
            //->setOrientation('landscape')
            ->setPaper('letter')
            ->setOption('footer-right','Pag [page] de [toPage]')
            ->setOption('footer-font-size',8);
            return $pdf->inline('Resumen_de_Ventas_Del_'.$fini.'Al_'.$ffin.'.pdf');
        }
        elseif($request->gen =="excel")
        {
            $export = new ResumenVentasTotal($resum, $ffin, $ffin);    
            return Excel::download($export, 'Resumen de Ventas.xlsx');
        }
        else if($request->gen =="ver")
        {
            return view('reports.vista.resumenventascobros', compact('resumen', 'resum_c','ffin', 'fini', 'btitle'));
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
