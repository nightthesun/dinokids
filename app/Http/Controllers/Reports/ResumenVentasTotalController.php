<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResumenVentasTotal;


class ResumenVentasTotalController extends Controller
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
        return view('reports.resumenventastotal');
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
        $query=
        "SELECT 
        loc as 'Local', 
        tip as 'Tipo', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',  
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            
            CASE    
       
            WHEN adusrCusr IN (22,23,24,49,68) THEN 'RETAIL BALLIVIAN'
         --   WHEN adusrCusr IN (56) THEN 'MAGDY VILLARROEL'
            WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
            WHEN adusrCusr IN (28) THEN 'INS HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL'
            WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL'
            WHEN adusrCusr IN (74) THEN 'INS CALACOTO' 
            WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
            WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
            WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'
            WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
            WHEN adusrCusr IN (63) THEN 'REGIONAL 1'   
            WHEN adusrCusr IN (64) THEN 'REGIONAL 2' 
        
            WHEN adusrCusr IN (76,77) THEN 'RETAIL SAN MIGUEL'  
            WHEN adusrCusr IN (78) THEN 'LIBROS SAN MIGUEL' 
            
            --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
            ELSE adusrNomb             
            END as Tip,
          --  vtvtaTotT as 'tot', 
          imp,
			dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
            --AND adusrCusr NOT IN (9,65,63,64)--NO VENDEN
            AND adusrCusr NOT IN (9,65,63,64,80,61)--NO VENDEN
            and inlocCloc not in (1)
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, tip, mon
        ORDER BY loc, tip, mon";

        
        $resum = DB::connection('sqlsrv')->select(DB::raw($vari . $query));   
        //////////////////////////////////////CASA MATRIZ///////////////
        $casaMatrizQuery=
        "SELECT

        usu as 'usario',
		loc as 'Local', 
        tip as 'Tipo', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',  
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'


        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            
            CASE    
       
            WHEN adusrCusr IN (22,23,24,49,68) THEN 'RETAIL BALLIVIAN'
         --   WHEN adusrCusr IN (56) THEN 'MAGDY VILLARROEL'
            WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
            WHEN adusrCusr IN (28) THEN 'INS HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL'
            WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL'
            WHEN adusrCusr IN (74) THEN 'INS CALACOTO' 
            WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
            WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
            WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'
            WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
            WHEN adusrCusr IN (63) THEN 'REGIONAL 1'   
            WHEN adusrCusr IN (64) THEN 'REGIONAL 2' 
        
            WHEN adusrCusr IN (76,77) THEN 'RETAIL SAN MIGUEL'  
            WHEN adusrCusr IN (78) THEN 'LIBROS SAN MIGUEL' 
            
            --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
            ELSE adusrNomb             
            END as Tip,
          --  vtvtaTotT as 'tot', 
		  adusrCusr as 'usu',
          imp,
dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
JOIN (
SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
FROM vtVtd
where vtvtdMdel =0
GROUP BY vtvtdNtra
) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
            --AND adusrCusr NOT IN (9,65,63,64)--NO VENDEN
            AND adusrCusr NOT IN (9,65,64,80,61)--NO VENDEN
			and inlocCloc not in (2,3,4,5,6,9,11,12,13)
			and inlocNomb <>('REGIONALES')
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, tip, mon,usu
        ORDER BY loc, tip, mon,usu
        ";        
 $casaMatriz = DB::connection('sqlsrv')->select(DB::raw($vari . $casaMatrizQuery));   




$totalCasaMatrizQuery=
"SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total', 
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
           -- vtvtaTotT as 'tot', 
            imp,
			dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
               FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            WHERE 
           (cptraMdel = 0 AND cptraTtra = 21) 
                AND adusrCusr NOT IN (9,65,64,80,61)--NO VENDEN
			and inlocCloc not in (2,3,4,5,6,9,11,12,13)
			and inlocNomb <>('REGIONALES')
           
       --    AND adusrCusr NOT IN (22,23,24,49,41,25,26,27,50,42,32,33,34,52,43,35,36,38,51,67,44)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
         $totalCasaMatriz = DB::connection('sqlsrv')->select(DB::raw($vari . $totalCasaMatrizQuery));   
         
        /////////////////////////////administrativos
        $admin="SELECT 
        loc as 'Local', 
        tip as 'Tipo', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',    
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            CASE

            WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
            WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
            WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
            WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
            WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
            WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
            WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
            --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
            ELSE adusrNomb             
            END as Tip,
           -- vtvtaTotT as 'tot', 
           imp,
			dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            WHERE 
          (cptraMdel = 0 AND cptraTtra = 21) and
          adusrCusr  IN ( 9,65)
           -- adusrCusr = 65
		
		--or  adusrCusr = 9 )
    --    AND adusrCusr NOT IN (22,23,24,49)--NO VENDEN

		
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, tip, mon
        ORDER BY loc, tip, mon";
        
        $adminQ = DB::connection('sqlsrv')->select(DB::raw($vari . $admin));   
        ////////////////////////////////////////////
        
        //------------total administrativos-------------------------//
        $totalQ=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total', 
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
           -- vtvtaTotT as 'tot', 
            imp,
			dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            WHERE 
           (cptraMdel = 0 AND cptraTtra = 21) and 
           (adusrCusr=65 or adusrCusr=9)
           
       --    AND adusrCusr NOT IN (22,23,24,49,41,25,26,27,50,42,32,33,34,52,43,35,36,38,51,67,44)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
        $totalQ = DB::connection('sqlsrv')->select(DB::raw($vari . $totalQ));  

//----------CAJERO FERIA--------------
$queryFeria="SELECT 
loc as 'Local', 
tip as 'Tipo', 
CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total', 

mon as 'Moneda', 
CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
FROM
(
    SELECT 
    cptraFtra as 'Fec', 
    adusrNomb as 'Usr',
    inlocNomb as 'Loc',
    --vtvtaCalm as 'alma',
    CASE         
   
    WHEN adusrCusr IN (61) THEN 'CAJERO 1'
    WHEN adusrCusr IN (80) THEN 'CAJERO 2'   

    --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
    ELSE adusrNomb             
    END as Tip,
  --  vtvtaTotT as 'tot', 
   -- vtvtaImpT	as 'imp',
--vtvtaDesT  as 'dest',
imp,
dest,
    admonAbrv as 'mon', 
    cptraCajS as 'efe', 
    cptraBanS as 'ban', 
    cptraCxcS as 'cxc',
    cptraTarS as 'tar', 
    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
    FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
    WHERE 
 (cptraMdel = 0 AND cptraTtra = 21) AND
     
 (adusrCusr=61 or adusrCusr=80)
--	or  adusrCusr = 4

 --   or  adusrCusr = 3

) as venta
WHERE (fec BETWEEN @fini AND @ffin)
GROUP BY loc, tip, mon
ORDER BY loc, tip, mon";
            $feria  = DB::connection('sqlsrv')->select(DB::raw($vari . $queryFeria)); 

            $totalFeria=
            "SELECT 
            loc as 'Local', 
            CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',
            mon as 'Moneda', 
            CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
            CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
            CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
            CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
            CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
            CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec',
               -- vtvtaCalm as 'alma', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
             --   vtvtaTotT as 'tot', 
            --    vtvtaImpT	as 'imp',
            --    vtvtaDesT  as 'dest',
            imp,
            dest,
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
                WHERE 
               
               cptraMdel = 0 AND cptraTtra = 21  and
               (adusrCusr=61 or adusrCusr=80)
             
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, mon
            ORDER BY loc, mon";
            $totalF = DB::connection('sqlsrv')->select(DB::raw($vari . $totalFeria));
    





       
        ////////////////////////////////////
            //--------REGIONALES1-------------
            $regi1="SELECT 
            loc as 'Local', 
            tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total', 

            mon as 'Moneda', 
            CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
            CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
            CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
            CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
            CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
            CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
              --  vtvtaCalm as 'alma',
                CASE         
               
                WHEN vtvtaCalm IN (58) THEN 'POTOSI'
                WHEN vtvtaCalm IN (57) THEN 'SUCRE'   

                --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
                ELSE adusrNomb             
                END as Tip,
              --  vtvtaTotT as 'tot', 
              --  vtvtaImpT	as 'imp',
		--	vtvtaDesT  as 'dest',
        imp,
        dest,
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
			
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
			join vtVta on cptraNtrI = vtvtaNtra
			
		
    WHERE 
             (cptraMdel = 0 AND cptraTtra = 21) AND
                 
              (vtvtaCalm = 58 OR vtvtaCalm = 57 ) 
            --	or  adusrCusr = 4

			
			
           
             --   or  adusrCusr = 3
            
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, tip, mon
            ORDER BY loc, tip, mon";
            
            $regionales1  = DB::connection('sqlsrv')->select(DB::raw($vari . $regi1)); 


            $totalG=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec',
           -- vtvtaCalm as 'alma', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
           -- vtvtaTotT as 'tot', 
           -- vtvtaImpT	as 'imp',
			--vtvtaDesT  as 'dest',
            imp,
            dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            join vtVta on cptraNtrI = vtvtaNtra
    WHERE 
           
           cptraMdel = 0 AND cptraTtra = 21  and
           (vtvtaCalm = 58 OR vtvtaCalm = 57 ) 
         
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
        $totalG = DB::connection('sqlsrv')->select(DB::raw($vari . $totalG));


        ///////////////////////////////////////

////////////////////////////////////
            //--------REGIONALES 2-------------
            $regi2="SELECT 
            loc as 'Local', 
            tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total', 

            mon as 'Moneda', 
            CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
            CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
            CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
            CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
            CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
            CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
              --  vtvtaCalm as 'alma',
                CASE         
               
                WHEN vtvtaCalm IN (59) THEN 'TARIJA'
                WHEN vtvtaCalm IN (60) THEN 'ORURO' 
                WHEN vtvtaCalm IN (61) THEN 'COCHABAMBA'  

                --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
                ELSE adusrNomb             
                END as Tip,
              --  vtvtaTotT as 'tot', 
              --  vtvtaImpT	as 'imp',
		--	vtvtaDesT  as 'dest',
        imp,
        dest,
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
			
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
			join vtVta on cptraNtrI = vtvtaNtra
			
		
    WHERE 
             (cptraMdel = 0 AND cptraTtra = 21) AND
                 
             (vtvtaCalm = 59 OR vtvtaCalm = 60 OR vtvtaCalm = 61) 
            --	or  adusrCusr = 4

			
			
           
             --   or  adusrCusr = 3
            
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, tip, mon
            ORDER BY loc, tip, mon";
            
            $regionales2  = DB::connection('sqlsrv')->select(DB::raw($vari . $regi2));   


            $totalG2=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',  
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec',
           -- vtvtaCalm as 'alma', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
          imp,
          dest,
           -- vtvtaTotT as 'tot', 
           -- vtvtaImpT	as 'imp',
		--	vtvtaDesT  as 'dest',
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
            join vtVta on cptraNtrI = vtvtaNtra
    WHERE 
            (cptraMdel = 0 AND cptraTtra = 21)and 
            (vtvtaCalm = 59 OR vtvtaCalm = 60 OR vtvtaCalm = 61) 
           

        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
        $totalG2 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalG2));  

       
        ////////////////////////////////////
            //--------SUCURSAL SAN MIGUEL-------------
            $sanMi="SELECT 
            loc as 'Local', 
            tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',   
            mon as 'Moneda', 
            CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
            CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
            CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
            CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
            CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
            CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
               -- vtvtaCalm as 'alma',
                CASE         
               
                WHEN adusrCusr IN (76,77) THEN 'RETAIL SAN MIGUEL'
                
                  

                --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
                ELSE adusrNomb             
                END as Tip,
              --  vtvtaTotT as 'tot', 
              --  vtvtaImpT	as 'imp',
			--vtvtaDesT  as 'dest',
            imp,
            dest,
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
    WHERE 
             (cptraMdel = 0 AND cptraTtra = 21) AND
                 
              (adusrCusr = 67) 
       
            
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, tip, mon
            ORDER BY loc, tip, mon";
            

            
            $sanMiguel  = DB::connection('sqlsrv')->select(DB::raw($vari . $sanMi));   
              

            $totalSanMi=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',  
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec',
          --  vtvtaCalm as 'alma', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
          --  vtvtaTotT as 'tot', 
          --  vtvtdImpT	as 'imp',
		--	vtvtdDesT  as 'dest',
        imp,
        dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
    WHERE 
            (cptraMdel = 0 AND cptraTtra = 21)
            and  (adusrCusr = 67) 
           

        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
        $totalSanMi = DB::connection('sqlsrv')->select(DB::raw($vari . $totalSanMi));  






        $total=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total', 
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
           -- vtvtaTotT as 'tot', 
           -- vtvtdImpT	as 'imp',
			--vtvtdDesT  as 'dest',
            imp,
            dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
    WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65,61,80)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
        $total = DB::connection('sqlsrv')->select(DB::raw($vari . $total)); 
        $totalgen=
        "SELECT 
     CONVERT(VARCHAR, cast(SUM(imp-dest) as money),1) as 'Total',  
        mon as 'Moneda', 
        CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
        CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
        CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
        CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
        CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
        CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
          --  vtvtaTotT as 'tot', 
          --  vtvtdImpT	as 'imp',
		--	vtvtdDesT  as 'dest',
        imp,
        dest,
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
           --JOIN vtVtd ON vtvtdNtra = cptraNtrI
			JOIN (
				SELECT vtvtdNtra, SUM(vtvtdImpT) AS 'imp', SUM(vtvtdDesT) AS 'dest'
				FROM vtVtd
				where vtvtdMdel =0
				GROUP BY vtvtdNtra
			) as venta ON venta.vtvtdNtra = cptraNtrI
              JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cptraCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = cptraMtra
            join inloc ON inlocCloc = cptraCloc
    WHERE 
            cptraMdel = 0 AND cptraTtra = 21 
          --  AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            --and adusrCusr NOT IN (2, 5,6,7,8,10,11,12,13,14,15,47,54,56)
            and adusrCusr NOT IN (2, 5,6,7,8,10,11,12,13,14,15,47,54)
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY mon
        ORDER BY mon";
        $totalgen = DB::connection('sqlsrv')->select(DB::raw($vari . $totalgen)); 
        $resumen= [];  
        $resumenAdmin=[];
        $casaMatrizArray=[];
        $totalCasaMatrizArray=[];
        $region1=[];
        $region2=[];
        $feriaArray=[];
        $sanmiguelArray=[];
        foreach ($casaMatriz as $key => $value) {
            if (!array_key_exists($value->Local, $casaMatrizArray)) 
            {
                $casaMatrizArray[$value->Local] = [$casaMatriz[$key]];
            }
            else
            {
                array_push($casaMatrizArray[$value->Local], $casaMatriz[$key]);
            }
        }
         
        foreach ($totalCasaMatriz as $key => $value) {
            if (!array_key_exists($value->Local, $totalCasaMatriz)) 
            {
                $totalCasaMatriz[$value->Local] = [$totalCasaMatriz[$key]];
                unset($totalCasaMatriz[$key]);
            }
            else
            {
                array_push($totalCasaMatriz[$value->Local], $totalCasaMatriz[$key]);
                unset($totalCasaMatriz[$key]);
            }
        }

        foreach ($resum as $key => $value) {
            if (!array_key_exists($value->Local, $resumen)) 
            {
                $resumen[$value->Local] = [$resum[$key]];
            }
            else
            {
                array_push($resumen[$value->Local], $resum[$key]);
            }
        }
        foreach ($adminQ as $key => $value) {
            if (!array_key_exists($value->Local, $resumenAdmin)) 
            {
                $resumenAdmin[$value->Local] = [$adminQ[$key]];
            }
            else
            {
                array_push($resumenAdmin[$value->Local], $adminQ[$key]);
            }
        }
        foreach ($regionales1 as $key => $value) {
            if (!array_key_exists($value->Local, $region1)) 
            {
                $region1[$value->Local] = [$regionales1[$key]];
            }
            else
            {
                array_push($region1[$value->Local], $regionales1[$key]);
            }
        }
        foreach ($regionales2 as $key => $value) {
            if (!array_key_exists($value->Local, $region2)) 
            {
                $region2[$value->Local] = [$regionales2[$key]];
            }
            else
            {
                array_push($region2[$value->Local], $regionales2[$key]);
            }
        }
        
        foreach ($totalF as $key => $value) {
            if (!array_key_exists($value->Local, $totalF)) 
            {
                $totalF[$value->Local] = [$totalF[$key]];
                unset($totalF[$key]);
            }
            else
            {
                array_push($totalF[$value->Local], $totalF[$key]);
                unset($totalF[$key]);
            }
        }

       
        foreach ($total as $key => $value) {
            if (!array_key_exists($value->Local, $total)) 
            {
                $total[$value->Local] = [$total[$key]];
                unset($total[$key]);
            }
            else
            {
                array_push($total[$value->Local], $total[$key]);
                unset($total[$key]);
            }
        }
        foreach ($totalQ as $key => $value) {
            if (!array_key_exists($value->Local, $totalQ)) 
            {
                $totalQ[$value->Local] = [$totalQ[$key]];
                unset($totalQ[$key]);
            }
            else
            {
                array_push($totalQ[$value->Local], $totalQ[$key]);
                unset($totalQ[$key]);
            }
        }
        foreach ($totalG as $key => $value) {
            if (!array_key_exists($value->Local, $totalG)) 
            {
                $totalG[$value->Local] = [$totalG[$key]];
                unset($totalG[$key]);
            }
            else
            {
                array_push($totalG[$value->Local], $totalG[$key]);
                unset($totalG[$key]);
            }
        }
        
        foreach ($totalG2 as $key => $value) {
            if (!array_key_exists($value->Local, $totalG2)) 
            {
                $totalG2[$value->Local] = [$totalG2[$key]];
                unset($totalG2[$key]);
            }
            else
            {
                array_push($totalG2[$value->Local], $totalG2[$key]);
                unset($totalG2[$key]);
            }
        }
      
        foreach ($totalSanMi as $key => $value) {
            if (!array_key_exists($value->Local, $totalSanMi)) 
            {
                $totalSanMi[$value->Local] = [$totalSanMi[$key]];
                unset($totalSanMi[$key]);
            }
            else
            {
                array_push($totalSanMi[$value->Local], $totalSanMi[$key]);
                unset($totalSanMi[$key]);
            }
        }
        foreach ($feria as $key => $value) {
            if (!array_key_exists($value->Local, $feriaArray)) 
            {
                $feriaArray[$value->Local] = [$feria[$key]];
            }
            else
            {
                array_push($feriaArray[$value->Local], $feria[$key]);
            }
        }
      
        if($request->gen =="export")
        {
           // $pdf = \PDF::loadView('reports.pdf.resumenventastotal', compact('resumen', 'ffin', 'fini', 'total', 'totalgen','resumenAdmin','totalQ'))
            //->setOrientation('landscape')
            $pdf = \PDF::loadView('reports.pdf.resumenventastotal',  compact('resumen','casaMatrizArray','totalCasaMatriz', 'ffin', 'fini', 'total', 'totalgen','resumenAdmin','totalQ','region1','totalG','region2','totalG2','sanmiguelArray','totalSanMi','totalF','sanmiguelArray','feriaArray'))
            
            ->setPaper('letter')
            ->setOption('footer-right','Pag [page] de [toPage]')
            ->setOption('footer-font-size',8);
            return $pdf->inline('Resumen_de_Ventas_Del_'.$fini.'Al_'.$ffin.'.pdf');
        }
        elseif($request->gen =="excel")
        {
            $export = new ResumenVentasTotal($resum, $fini, $ffin,$adminQ, $totalQ ,$regionales1 ,$totalG ,$regionales2  ,$totalG2 , $total, $totalgen);    
            return Excel::download($export, 'Resumen de Ventas.xlsx');
        }
        else if($request->gen =="ver")
        {
            return view('reports.vista.resumenventastotal', compact('resumen', 'casaMatrizArray','totalCasaMatriz','ffin', 'fini', 'total', 'totalgen','resumenAdmin','totalQ','region1','totalG','region2','totalG2','sanmiguelArray','totalSanMi','totalF','sanmiguelArray','feriaArray'));
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
