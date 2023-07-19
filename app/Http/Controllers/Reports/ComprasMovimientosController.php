<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComprasMovExport;
use Auth; 
class ComprasMovimientosController extends Controller
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
        if(Auth::user()->tienePermiso(3, 1)){
            return view('reports.compras_movimientos');
        }
        return redirect()->back();
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
        $fecha_ini = date("d-m-Y", strtotime($request->fecha_ini));
        $fecha_fin = date("d-m-Y", strtotime($request->fecha_fin));
        $categ = $request->categoria;
        $prod = $request->producto;
        switch(true)
        {
            case($prod && $categ):
                $filtro = "WHERE   marc.maconNomb LIKE '%".$categ."%' 
                AND (inpro.inproCpro LIKE '%".$prod."%'
                OR inpro.inproNomb LIKE '%".$prod."%')";
                break;
            case($prod):
                $filtro = "WHERE (inpro.inproCpro LIKE '%".$prod."%'
                OR inpro.inproNomb LIKE '%".$prod."%')";
                break;
            case($categ):
                $filtro = "WHERE   marc.maconNomb LIKE '%".$categ."%'";
                break;
            default:
                $filtro = '';
        }   
        $filter = "DECLARE @fini as date, @ffin as date
        SELECT @fini ='".$fecha_ini."', @ffin = '".$fecha_fin."'";    
        //return dd($request);
        $query = 
        "SELECT
        marc.maconNomb as categoria,
        ISNULL(intrd.intrdCpro, inpro.inproCpro) as codigo, 
        inpro.inproNomb as descripcion, 
        umpro.inumeAbre as umprod,
        REPLACE(ISNULL(compr.cos, intrd.intrdCTmi/intrd.intrdCanb),',', '.') as precio_orig,
        ISNULL(compr.admonAbrv, Minv.admonAbrv ) as moneda_preco,
        ISNULL(REPLACE(intrd.intrdCTmi/intrd.intrdCanb,',', '.'),0) as costultcomp,
        Minv.admonAbrv as monedacostultcomp,
        (CASE compr.cmOcmCimp 
        WHEN 1 THEN 'IMPORTACION'
        WHEN 0 THEN 'COMPRA LOCAL' END
        ) AS tipo_compra,
        REPLACE(cosprom.promcos,',', '.') as costo_promed,
        Mpromcos.admonAbrv as moneda_costo_promed,
        REPLACE(pvp.vtLidPrco,',', '.') as pvp,
        CONVERT(varchar, cym.intraFtra, 103) as fecha_ult,
        REPLACE(intrd.intrdCanb,',', '.') as cantultcomp,        
        inume.inumeAbre as um_ultcomp, 
        cym.intraNtrI as codtransini,
        compr.crentNomb as prov,
        REPLACE(ISNULL(Total,0),',', '.') as stockTotal,  
        REPLACE(ISNULL(stocks.AC2,0),',', '.') as stockAC2,
        REPLACE(ISNULL(AC1,0),',', '.') as stockAC1,
        REPLACE(ISNULL(Planta,0),',', '.') as stockAlto,
        REPLACE(ISNULL(Handal,0),',', '.') as stockHAN,
        REPLACE(ISNULL(Ballivian,0),',', '.') as stockBALL,
        REPLACE(ISNULL(Mariscal,0),',', '.') as stockMARIS,
        REPLACE(ISNULL(Calacoto,0),',', '.') as stockCALA,
        REPLACE(ISNULL(SanMiguel,0),',', '.') as stockSanM,
        REPLACE(ISNULL(SantaCruz,0),',', '.') as stockSCZ,   
        REPLACE(ISNULL(AlmResGeneral,0),',', '.') as stockARGen,
        REPLACE(ISNULL(AlmMay1,0),',', '.') as stockAlmMay1,
		REPLACE(ISNULL(AlmMay2,0),',', '.') as stockAlmMay2,
		REPLACE(ISNULL(AlmMay3,0),',', '.') as stockAlmMay3,
		REPLACE(ISNULL(AlmMay4,0),',', '.') as stockAlmMay4,
		REPLACE(ISNULL(AlmMay5,0),',', '.') as stockAlmMay5,

        REPLACE(ISNULL(AlmSucre,0),',', '.') as stockAlmSucre,
        REPLACE(ISNULL(AlmPotosi,0),',', '.') as stockAlmPotosi,
        REPLACE(ISNULL(AlmTarija,0),',', '.') as stockAlmTarija,
        REPLACE(ISNULL(AlmOruro,0),',', '.') as stockAlmOruro,
        REPLACE(ISNULL(AlmCochaba,0),',', '.') as stockAlmCochaba,
        REPLACE(ISNULL(AlmIns1,0),',', '.') as stockAlmIns1,
        REPLACE(ISNULL(AlmIns2,0),',', '.') as stockAlmIns2,
        REPLACE(ISNULL(AlmIns3,0),',', '.') as stockAlmIns3,
        REPLACE(ISNULL(AlmIns4,0),',', '.') as stockAlmIns4,
        REPLACE(ISNULL(InsBallian,0),',', '.') as stockInsBallian,
        REPLACE(ISNULL(InsHandal,0),',', '.') as stockInsHandal,
        REPLACE(ISNULL(InsCalacoto,0),',', '.') as stockInsCalacoto,
        REPLACE(ISNULL(InsMariscal,0),',', '.') as stockInsMariscal,
        REPLACE(ISNULL(AlmKetal,0),',', '.') as stockAlmKetal,
        REPLACE(ISNULL(AlmReserContratos,0),',', '.') as stockAlmReserContratos,
        REPLACE(ISNULL(AlmSicoes,0),',', '.') as stockAlmSicoes,

		REPLACE(ISNULL(AlmDistribuidor1,0),',', '.') as stockAlmDistri1,       
        CONVERT(varchar, ultv.intraFtra,103) as fechaultventa
        
        FROM intra as cym  
        --DETALLE DE MOV
        JOIN intrd ON intraNtra = intrdNtra AND intrdMdel = 0
        --Costo Ult Importacion/Compra
        JOIN 
        (
        SELECT  
            numT, cmOcdNtra,cmOcd.cmOcdCpro, cmOcdMtra,  cmOcdCanC, admonAbrv, cmOcmCimp,
            REPLACE(cmOcdCosO/cmOcdCanC,',', '.') as 'cos', cmOcdCumc, inumeAbre, crentNomb
            from cmOcd 
            JOIN cmOcm as cm ON cmOcdNtra = cmOcmNtra AND cmOcmMdel=0  
            RIGHT JOIN
            (
                select cmOcdCpro, MAX(cmOcdNtra) as Ntrans, MAX(numT) as numT	
                FROM 
                (
                    select ISNULL(cmRe.cmrecNtra, cmOcd.cmOcdNtra) as NumT, cmOcd.*, cmOcm.*, ISNULL(cmRe.cmrecFtra, cmocmFocm ) as Fmov, crEnt.crentNomb
                        FROM cmOcm
                        JOIN cmOcd ON cmOcmNtra = cmOcdNtra
						LEFT JOIN 
						(
						SELECT *
							FROM cmRec 
							JOIN cmRed ON cmrecNtra = cmredNtra
						) as cmRe
                        ON cmOcdNtra = cmRe.cmrecNocm AND cmOcdCpro = cmRedCpro
						LEFT JOIN crEnt ON crentCent =  cmOcmCprv
					WHERE (cmocmTcmp = 1 OR cmrecNtra IS NOT NULL ) AND cmocmMdel = 0
					--AND crEnt.crentNomb	LIKE '%Milcar%'
                ) as comp
                WHERE comp.Fmov >= @fini
                AND comp.Fmov <= @ffin
                --AND comp.cmOcmCimp = 0 -- ES COMPRA LOCAL
                --AND comp.cmocmCprv <> 2657
                GROUP BY cmOcdCpro 	
            ) as compr
            ON compr.cmOcdCpro = cmOcd.cmOcdCpro AND Ntrans = cmOcdNtra
            --Moneda
            LEFT JOIN bd_admOlimpia.dbo.admon ON admonCmon =cmOcd.cmOcdMtra
            --Unidades Medida
            LEFT JOIN inume ON inume.inumeCume = cmOcd.cmOcdCumc
            --Proveedores
			LEFT JOIN crEnt ON crentCent =  cmOcmCprv
        ) as compr
        ON compr.cmOcdCpro = intrd.intrdCpro AND compr.numT = cym.intraNtrI
        
        --Productos
        
        RIGHT JOIN 
        (
            SELECT * FROM inpro where inproMdel = 0 AND inproStat = 0
        ) as inpro        
        ON intrd.intrdCpro = inproCpro
        
        LEFT JOIN inume as umpro ON umpro.inumeCume = inpro.inproCumb
        --
        LEFT JOIN 
        (
            SELECT 
            convert(varchar,maconCcon)+'|'+convert(varchar,maconItem) as maconMarc, 
            maconNomb 
            FROM macon 
            WHERE maconCcon = 113
        ) as marc
        ON inpro.inproMarc = marc.maconMarc
        --TIPO DE MOV 
        LEFT JOIN matmo on maTmoCmod=3 and maTmoMdel=0 and maTmoItem= cym.intraTmov  
        --Moneda
        LEFT JOIN bd_admOlimpia.dbo.admon as Minv ON intrd.intrdMinv = admonCmon 
        --Unidades Medida
        LEFT JOIN inume ON inume.inumeCume = intrd.intrdUmtr      
        
        --Costo Promedio
        LEFT JOIN
        (
        SELECT 
            intrdCpro, intrdMinv,
            CASE
            WHEN SUM(intrdCanb) = 0 THEN 0
            ELSE SUM(intrdCTmi)/SUM(intrdCanb)
            END as 'promcos'
            FROM intra  
            JOIN intrd ON intraNtra = intrdNtra AND intrdMDel = 0
            WHERE intraMdel = 0
            GROUP BY intrdCpro, intrdMinv
        ) as cosprom
        ON cosprom.intrdCpro = inpro.inproCpro
        --Modena
        LEFT JOIN bd_admOlimpia.dbo.admon as Mpromcos ON cosprom.intrdMinv = Mpromcos.admonCmon
        
        --fecha ult venta
        LEFT JOIN
        (
        SELECT 
        intrdCpro,
        MAX(intraFtra) as intraFtra
        FROM intra
        JOIN intrd ON intraNtra = intrdNtra AND intrdMdel=0  
        WHERE intraTmov = 90
        GROUP BY intrdCpro	
        ) as ultv
        ON ultv.intrdCpro = inpro.inproCpro
        
        --Costo Origen
        LEFT JOIN
        (
        SELECT  
            cmOcd.cmOcdCpro, cmOcdMtra,  cmOcdCanC,
            REPLACE(cmOcdCosO/cmOcdCanC,',', '.') as 'cosO'
            from cmOcd 
            JOIN cmOcm as cm ON cmOcdNtra = cmOcmNtra AND cmOcmMdel=0  
            RIGHT JOIN
            (
                select cmOcdCpro, MAX(cmOcdNtra) as Ntrans		
                from cmOcd as prodo		
                JOIN cmOcm as cm ON cmOcdNtra = cmOcmNtra AND cmOcmMdel=0
                WHERE cmOcdCosO <> 0
                AND cm.cmOcmFocm >= @fini
                AND cm.cmOcmFocm <= @ffin
                GROUP BY cmOcdCpro 		
            ) as prodo
            ON prodo.cmOcdCpro = cmOcd.cmOcdCpro AND Ntrans = cmOcdNtra
            WHERE cmOcdCosO <> 0            
        ) as cosO
        ON cosO.cmOcdCpro = inpro.inproCpro --AND cosO.cmOcdNtra = intraNtra
        --Moneda
        LEFT JOIN bd_admOlimpia.dbo.admon as McosO  ON McosO.admonCmon = cosO.cmOcdMtra
        
        
        --Stock
        LEFT JOIN
        (
            SELECT
            intrdCpro,
            ISNULL([47],0)+ISNULL([40],0) as 'AC2',
            ISNULL([39],0)+ISNULL([46],0) as 'AC1',
            ISNULL([43],0) as 'Planta',
            ISNULL([4],0)+ISNULL([13],0) as 'Handal',
            ISNULL([7],0)+ISNULL([10],0) as 'Ballivian',
            ISNULL([6],0)+ISNULL([30],0)  as 'Mariscal',
            ISNULL([5],0)+ISNULL([29],0) as 'Calacoto',
            ISNULL([67],0)+ISNULL([68],0) as 'SanMiguel',
            
            ISNULL([45],0) as 'SantaCruz',
            ISNULL([9],0) as 'AlmMay1',	
			ISNULL([48],0) as 'AlmMay2',
			ISNULL([49],0) as 'AlmMay3',
			ISNULL([50],0) as 'AlmMay4',
			ISNULL([53],0) as 'AlmMay5',

            ISNULL([57],0) as 'AlmSucre',
            ISNULL([58],0) as 'AlmPotosi',	
            ISNULL([59],0) as 'AlmTarija',
            ISNULL([60],0) as 'AlmOruro',
            ISNULL([61],0) as 'AlmCochaba',
            ISNULL([8],0) as 'AlmIns1',
            ISNULL([20],0) as 'AlmIns2',
            ISNULL([21],0) as 'AlmIns3',
            ISNULL([22],0) as 'AlmIns4',
            ISNULL([31],0) as 'InsBallian',
            ISNULL([32],0) as 'InsHandal',
            ISNULL([33],0) as 'InsCalacoto',
            ISNULL([34],0) as 'InsMariscal',
            ISNULL([23],0) as 'AlmKetal',
            ISNULL([62],0) as 'AlmReserContratos',
            ISNULL([24],0) as 'AlmSicoes',

			ISNULL([27],0) as 'AlmDistribuidor1',
            ISNULL([73],0) as 'AlmResGeneral',	


            
            ISNULL([47],0)+ISNULL([40],0)+ISNULL([39],0)+ISNULL([46],0)+
			ISNULL([43],0)+ISNULL([4],0)+ISNULL([13],0)+ISNULL([7],0)+
			ISNULL([10],0)+ISNULL([6],0)+ISNULL([30],0)+ISNULL([5],0)+
            ISNULL([67],0)+ISNULL([68],0) +
            ISNULL([5],0)+ISNULL([29],0)+
            ISNULL([45],0)+ISNULL([9],0)+ISNULL([48],0)+
            ISNULL([49],0)+ISNULL([50],0)+ISNULL([53],0)+
            ISNULL([27],0)+ISNULL([73],0)+ISNULL([57],0)+
            ISNULL([58],0)+ISNULL([59],0)+ISNULL([60],0)+
            ISNULL([61],0)+ISNULL([8],0)+ISNULL([20],0)+
            ISNULL([21],0)+ISNULL([22],0)+ISNULL([31],0)+
            ISNULL([32],0)+ISNULL([33],0)+ISNULL([34],0)+
            ISNULL([23],0)+ISNULL([62],0)+ISNULL([24],0)
             as 'Total'
            FROM
            (
                SELECT 
                intrdCpro, intraCalm, SUM(intrdCanb) as cant
                FROM intra
                JOIN intrd ON intraNtra = intrdNtra
                WHERE intraMdel = 0 AND intrdMdel = 0
                GROUP BY intrdCpro, intraCalm
            ) as sotck
            pivot
            (
                SUM(cant)
                for intraCalm IN ([4],[5],[6],[7],[10],[13],
                [29],[30],[39],[40],[43],[45],[46],[47],[67],[68],[9],[48],[49],[50],[53],[27],[73],
                [57],[58],[59],[60],[61],[8],[20],[21],[22],[31],[32],[33],[34],[23],[62],[24])
            ) as ptv
        ) as stocks
        ON stocks.intrdCpro = inpro.inproCpro
        --PVP
        LEFT JOIN 
        (
          SELECT vtLidPrco, vtLidCpro  FROM vtLis JOIN vtLid ON vtLidClis = vtLisClis
          WHERE vtLisDesc = 'RETAIL BALLIVIAN'
        ) as pvp
        ON pvp.vtLidCpro = inpro.inproCpro
        ".$filtro."
        ORDER BY inpro.inproCpro";
        $test = DB::connection('sqlsrv')->select(DB::raw($filter.$query));
        if($request->gen =="export")
        {
            $export = new ComprasMovExport($test);    
            return Excel::download($export, 'Reporte de Compras y Movimientos.xlsx');
        }
        else
        {
            return view('reports.vista.compras_movimientos', compact('test'));
        }
        //return Excel::download(new ComprasMovExport, 'users.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = new ComprasMovExport;
        $test = $test->Collection();
        return dd($test);
        return view('reports.compras_movimientos', compact('test'));
        //return Excel::download(new ComprasMovExport, 'users.xlsx');
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
