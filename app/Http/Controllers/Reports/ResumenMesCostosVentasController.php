<?php

namespace App\Http\Controllers\Reports;

use App\Exports\ResumenMexVentasExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PhpParser\Node\Stmt\Foreach_;
use App\Exports\ResumenVentasExport;

class ResumenMesCostosVentasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('reports.resumenxmescosto');
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
    $segmento = [
      ['name' => 'BALLIVIAN', 'abrv' => 'BALLIVIAN', 'users' => [5,22, 41, 49, 46,61, 68,65,9,7,80,75,60]],
      ['name' => 'HANDAL', 'abrv' => 'HANDAL', 'users' => [26, 42, 50, 28, 69]],
      ['name' => 'MARISCAL', 'abrv' => 'MARISCAL', 'users' => [38, 44, 51, 37, 67]],
      ['name' => 'CALACOTO', 'abrv' => 'CALACOTO', 'users' => [29,57,74,32,43,52]],
      ['name' => 'SAN MIGUEL', 'abrv' => 'SAN MIGUEL', 'users' => [76,77,78]],
      ['name' => 'INSTITUCIONALES', 'abrv' => 'INSTITUCIONALES', 'users' => [16, 17, 62, 56, 3, 58, 4]],
      ['name' => 'MAYORISTAS', 'abrv' => 'MAYORISTAS', 'users' => [18, 19, 55, 21, 20,63]],
      ['name' => 'SANTA CRUZ', 'abrv' => 'SANTA CRUZ', 'users' => [40, 39]],
    ];
    $retail = [
      ['name' => 'BALLIVIAN', 'abrv' => 'BALLIVIAN', 'users' => [22, 49, 68]],
      ['name' => 'HANDAL', 'abrv' => 'HANDAL', 'users' => [26, 50, 69]],
      ['name' => 'MARISCAL', 'abrv' => 'MARISCAL', 'users' => [38, 51, 67]],
      ['name' => 'CALACOTO', 'abrv' => 'CALACOTO', 'users' => [32, 52]],
      ['name' => 'SAN MIGUEL', 'abrv' => 'SAN MIGUEL', 'users' => [76,77]],
      ['name' => 'INS CALACOTO', 'abrv' => 'INS CALACOTO', 'users' => [29,57,74]],
    ];
     
    $regional = [
      ['name' => 'REGIONAL1', 'abrv' => 'REGIONAL1', 'usr' => [63]],
      ['name' => 'REGIONAL2', 'abrv' => 'REGIONAL2', 'usr' => [64]],
    ];
    $almacen_reg = [
      ['name' => 'REGIONAL1', 'abrv' => 'REGIONAL1', 'alm' => [57, 58]],
      ['name' => 'REGIONAL2', 'abrv' => 'REGIONAL2', 'alm' => [59, 60, 61]],
    ];

    $mMayorista=[
      ['name' => 'MAYORISTAS', 'abrv' => 'MAYORISTAS', 'users' => [18, 19, 55, 21, 20,63]],

    ];
    $general = [5,22, 41, 49, 46,61, 68,65,9,26, 42, 50, 28, 69,38, 44, 51, 37, 67,29,57,74,32,43,52,76,77,78,16, 17, 62, 56, 3, 58, 4,18, 19, 55, 21, 20,40, 39,63,64,7,80,75,60];

    // $fini = date("d/m/Y", strtotime($request->fini));
    // $ffin = date("d/m/Y", strtotime($request->ffin));
    // $ff1 = $ffin;
    // // $fdia=date("d", strtotime($request->fhoy));
    // $fmes = date("d/m/Y", strtotime($request->fhoy));
    $group_mes_sum = [];
    $group_mes = [];
    $group_sum_tot = [];
    $options = $request->options;
    if (isset($request->options)) {
      foreach ($request->options as $key => $value) {
        $group_mes_sum[] = "CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "C2]),0) AS MONEY),1) AS [" . $value . "C2],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "2]),0) + ISNULL(SUM([" . $value . "VTrans]),0) AS MONEY),1) AS [" . $value . "2],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "VDesc]),0) AS MONEY),1) AS [" . $value . "VDesc],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "Imp]),0) AS MONEY),1) AS [" . $value . "Imp],";
        $group_mes[] = "CONVERT(varchar, CAST(ISNULL([" . $value . "C2],0) AS MONEY),1) AS [" . $value . "C2],
        CONVERT(varchar, CAST(ISNULL([" . $value . "2],0) + ISNULL([" . $value . "VTrans],0) AS MONEY),1) AS [" . $value . "2],
        CONVERT(varchar, CAST(ISNULL([" . $value . "VDesc],0) AS MONEY),1) AS [" . $value . "VDesc],
        CONVERT(varchar, CAST(ISNULL([" . $value . "Imp],0) AS MONEY),1) AS [" . $value . "Imp],";
        if ($key == 0) {
          if ($value == 'Enero') {
            $group_sum_tot[] = "ISNULL([1],0)";
          } elseif ($value == 'Febrero') {
            $group_sum_tot[] = "ISNULL([2],0)";
          } elseif ($value == 'Marzo') {
            $group_sum_tot[] = "ISNULL([3],0)";
          } elseif ($value == 'Abril') {
            $group_sum_tot[] = "ISNULL([4],0)";
          } elseif ($value == 'Mayo') {
            $group_sum_tot[] = "ISNULL([5],0)";
          } elseif ($value == 'Junio') {
            $group_sum_tot[] = "ISNULL([6],0)";
          } elseif ($value == 'Julio') {
            $group_sum_tot[] = "ISNULL([7],0)";
          } elseif ($value == 'Agosto') {
            $group_sum_tot[] = "ISNULL([8],0)";
          } elseif ($value == 'Septiembre') {
            $group_sum_tot[] = "ISNULL([9],0)";
          } elseif ($value == 'Octubre') {
            $group_sum_tot[] = "ISNULL([10],0)";
          } elseif ($value == 'Noviembre') {
            $group_sum_tot[] = "ISNULL([11],0)";
          } elseif ($value == 'Diciembre') {
            $group_sum_tot[] = "ISNULL([12],0)";
          }
        } else {
          if ($value == 'Enero') {
            $group_sum_tot[] = " + ISNULL([1],0)";
          } elseif ($value == 'Febrero') {
            $group_sum_tot[] = " + ISNULL([2],0)";
          } elseif ($value == 'Marzo') {
            $group_sum_tot[] = " + ISNULL([3],0)";
          } elseif ($value == 'Abril') {
            $group_sum_tot[] = " + ISNULL([4],0)";
          } elseif ($value == 'Mayo') {
            $group_sum_tot[] = " + ISNULL([5],0)";
          } elseif ($value == 'Junio') {
            $group_sum_tot[] = " + ISNULL([6],0)";
          } elseif ($value == 'Julio') {
            $group_sum_tot[] = " + ISNULL([7],0)";
          } elseif ($value == 'Agosto') {
            $group_sum_tot[] = " + ISNULL([8],0)";
          } elseif ($value == 'Septiembre') {
            $group_sum_tot[] = " + ISNULL([9],0)";
          } elseif ($value == 'Octubre') {
            $group_sum_tot[] = " + ISNULL([10],0)";
          } elseif ($value == 'Noviembre') {
            $group_sum_tot[] = " + ISNULL([11],0)";
          } elseif ($value == 'Diciembre') {
            $group_sum_tot[] = " + ISNULL([12],0)";
          }
        }
      }
    } else {
      dd('No Selecciono Ningun Mes');
    }
    // dd(implode($group_sum_tot));

    foreach ($general as $key) {
      $usr_general = "adusrCusr IN (" . implode(",", $general) . ")";
    }

   // dd ($usr_general );
    $query_general = "
    SELECT 
      " . implode($group_mes_sum) . "
      CONVERT(varchar, CAST(ISNULL(SUM([TotC2]),0) AS MONEY),1) AS [TotC2],
    -- CONVERT(varchar, CAST(ISNULL(SUM([Tot2]) + SUM([TotVTrans]),0) AS MONEY),1) AS [Tot2],
     CONVERT(varchar, CAST(sum(ISNULL([Tot2],0) + ISNULL([TotVTrans],0)) AS MONEY),1) AS [Tot2],
     
    CONVERT(varchar, CAST(ISNULL(SUM([TotVDesc]),0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL(SUM([TotImp]),0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [tot2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '5.30.20.10.02'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
      WHERE " . $usr_general . "
    ";
    // dd($query_general);
    $total_general = DB::connection('sqlsrv')->select(DB::raw($query_general));
    // dd($total_general);
    $total = [];

    //return dd($segmento);
    foreach ($segmento as $key) {
      $usr_total = "adusrCusr IN (" . implode(",", $key['users']) . ")";
      $usr = "adusrCusr IN (" . implode(",", $key['users']) . ") AND adusrCusr NOT IN (22,49,68,26,50,69,38,51,67,32,52,76,77)";
//return dd($segmento[]);
    //  dd($segmento);
    
    
      
      $sql_total = "
      SELECT 
      " . implode($group_mes_sum) . "
      CONVERT(varchar, CAST(ISNULL(SUM([TotC2]),0) AS MONEY),1) AS [TotC2],
      -- CONVERT(varchar, CAST(ISNULL(SUM([Tot2]) + SUM([TotVTrans]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(sum(ISNULL([Tot2],0) + ISNULL([TotVTrans],0)) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([TotVDesc]),0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL(SUM([TotImp]),0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [Tot2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '5.30.20.10.02'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
      WHERE " . $usr_total . "";
      // dd($sql_total);
      $total[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_total))];
      $sql_usr = "
      SELECT 
      adusrCusr, adusrNomb,
      " . implode($group_mes) . "
      CONVERT(varchar, CAST(ISNULL([TotC2],0) AS MONEY),1) AS [TotC2],
      CONVERT(varchar, CAST(ISNULL([Tot2],0) + ISNULL([TotVTrans],0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL([TotVDesc],0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL([TotImp],0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [Tot2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        join inloc ON inlocCloc = cntraCloc
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        and inlocNomb <>('REGIONALES')
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '5.30.20.10.02'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
      WHERE " . $usr . "
      AND adusrCusr NOT IN (29,57,74)
      ORDER BY adusrNomb;
      ";
      // dd($sql_usr);
      $total_seg[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_usr))];
    }

/////////////////////////////////ADICION DE MAYORISTAS//////////////////////////////////////
    
foreach ($mMayorista as $key) {
  $usr_total = "adusrCusr IN (" . implode(",", $key['users']) . ")";
  $usr = "adusrCusr IN (" . implode(",", $key['users']) . ") AND adusrCusr NOT IN (22,49,68,26,50,69,38,51,67,32,52,76,77)";
//return dd($segmento[]);
//  dd($segmento);
  
 
  
  $query_mayorista2 = "
  SELECT 
  " . implode($group_mes_sum) . "
  CONVERT(varchar, CAST(ISNULL(SUM([TotC2]),0) AS MONEY),1) AS [TotC2],
  CONVERT(varchar, CAST(ISNULL(SUM([Tot2]) + SUM([TotVTrans]),0) AS MONEY),1) AS [Tot2],
  CONVERT(varchar, CAST(ISNULL(SUM([TotVDesc]),0) AS MONEY),1) AS [TotVDesc],
  CONVERT(varchar, CAST(ISNULL(SUM([TotImp]),0) AS MONEY),1) AS [TotImp]
  FROM
  (
    SELECT *
    FROM bd_admOlimpia.dbo.adusr
  ) AS usr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [Enero2],
  ISNULL([2],0) AS [Febrero2],
  ISNULL([3],0) AS [Marzo2],
  ISNULL([4],0) AS [Abril2],
  ISNULL([5],0) AS [Mayo2],
  ISNULL([6],0) AS [Junio2],
  ISNULL([7],0) AS [Julio2],
  ISNULL([8],0) AS [Agosto2],
  ISNULL([9],0) AS [Septiembre2],
  ISNULL([10],0) AS [Octubre2],
  ISNULL([11],0) AS [Noviembre2],
  ISNULL([12],0) AS [Diciembre2],
  " . implode($group_sum_tot) . " AS [Tot2]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '4.10.10.10.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroC2],
  ISNULL([2],0) AS [FebreroC2],
  ISNULL([3],0) AS [MarzoC2],
  ISNULL([4],0) AS [AbrilC2],
  ISNULL([5],0) AS [MayoC2],
  ISNULL([6],0) AS [JunioC2],
  ISNULL([7],0) AS [JulioC2],
  ISNULL([8],0) AS [AgostoC2],
  ISNULL([9],0) AS [SeptiembreC2],
  ISNULL([10],0) AS [OctubreC2],
  ISNULL([11],0) AS [NoviembreC2],
  ISNULL([12],0) AS [DiciembreC2],
  " . implode($group_sum_tot) . " AS [TotC2]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '5.10.10.10.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroVTrans],
  ISNULL([2],0) AS [FebreroVTrans],
  ISNULL([3],0) AS [MarzoVTrans],
  ISNULL([4],0) AS [AbrilVTrans],
  ISNULL([5],0) AS [MayoVTrans],
  ISNULL([6],0) AS [JunioVTrans],
  ISNULL([7],0) AS [JulioVTrans],
  ISNULL([8],0) AS [AgostoVTrans],
  ISNULL([9],0) AS [SeptiembreVTrans],
  ISNULL([10],0) AS [OctubreVTrans],
  ISNULL([11],0) AS [NoviembreVTrans],
  ISNULL([12],0) AS [DiciembreVTrans],
  " . implode($group_sum_tot) . " AS [TotVTrans]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '4.10.10.20.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroVDesc],
  ISNULL([2],0) AS [FebreroVDesc],
  ISNULL([3],0) AS [MarzoVDesc],
  ISNULL([4],0) AS [AbrilVDesc],
  ISNULL([5],0) AS [MayoVDesc],
  ISNULL([6],0) AS [JunioVDesc],
  ISNULL([7],0) AS [JulioVDesc],
  ISNULL([8],0) AS [AgostoVDesc],
  ISNULL([9],0) AS [SeptiembreVDesc],
  ISNULL([10],0) AS [OctubreVDesc],
  ISNULL([11],0) AS [NoviembreVDesc],
  ISNULL([12],0) AS [DiciembreVDesc],
  " . implode($group_sum_tot) . " AS [TotVDesc]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '4.10.10.50.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroImp],
  ISNULL([2],0) AS [FebreroImp],
  ISNULL([3],0) AS [MarzoImp],
  ISNULL([4],0) AS [AbrilImp],
  ISNULL([5],0) AS [MayoImp],
  ISNULL([6],0) AS [JunioImp],
  ISNULL([7],0) AS [JulioImp],
  ISNULL([8],0) AS [AgostoImp],
  ISNULL([9],0) AS [SeptiembreImp],
  ISNULL([10],0) AS [OctubreImp],
  ISNULL([11],0) AS [NoviembreImp],
  ISNULL([12],0) AS [DiciembreImp],
  " . implode($group_sum_tot) . " AS [TotImp]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '5.30.20.10.02'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
  WHERE " . $usr_total . "";

  $totalMayorista[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($query_mayorista2))];
 //dd($totalMayorista[0]);
  $query_usr_mayorista = "
  SELECT 
  adusrCusr, adusrNomb,
  " . implode($group_mes) . "
  CONVERT(varchar, CAST(ISNULL([TotC2],0) AS MONEY),1) AS [TotC2],
  CONVERT(varchar, CAST(ISNULL([Tot2],0) + ISNULL([TotVTrans],0) AS MONEY),1) AS [Tot2],
  CONVERT(varchar, CAST(ISNULL([TotVDesc],0) AS MONEY),1) AS [TotVDesc],
  CONVERT(varchar, CAST(ISNULL([TotImp],0) AS MONEY),1) AS [TotImp]
  FROM
  (
    SELECT *
    FROM bd_admOlimpia.dbo.adusr
  ) AS usr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [Enero2],
  ISNULL([2],0) AS [Febrero2],
  ISNULL([3],0) AS [Marzo2],
  ISNULL([4],0) AS [Abril2],
  ISNULL([5],0) AS [Mayo2],
  ISNULL([6],0) AS [Junio2],
  ISNULL([7],0) AS [Julio2],
  ISNULL([8],0) AS [Agosto2],
  ISNULL([9],0) AS [Septiembre2],
  ISNULL([10],0) AS [Octubre2],
  ISNULL([11],0) AS [Noviembre2],
  ISNULL([12],0) AS [Diciembre2],
  " . implode($group_sum_tot) . " AS [Tot2]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '4.10.10.10.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroC2],
  ISNULL([2],0) AS [FebreroC2],
  ISNULL([3],0) AS [MarzoC2],
  ISNULL([4],0) AS [AbrilC2],
  ISNULL([5],0) AS [MayoC2],
  ISNULL([6],0) AS [JunioC2],
  ISNULL([7],0) AS [JulioC2],
  ISNULL([8],0) AS [AgostoC2],
  ISNULL([9],0) AS [SeptiembreC2],
  ISNULL([10],0) AS [OctubreC2],
  ISNULL([11],0) AS [NoviembreC2],
  ISNULL([12],0) AS [DiciembreC2],
  " . implode($group_sum_tot) . " AS [TotC2]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '5.10.10.10.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroVTrans],
  ISNULL([2],0) AS [FebreroVTrans],
  ISNULL([3],0) AS [MarzoVTrans],
  ISNULL([4],0) AS [AbrilVTrans],
  ISNULL([5],0) AS [MayoVTrans],
  ISNULL([6],0) AS [JunioVTrans],
  ISNULL([7],0) AS [JulioVTrans],
  ISNULL([8],0) AS [AgostoVTrans],
  ISNULL([9],0) AS [SeptiembreVTrans],
  ISNULL([10],0) AS [OctubreVTrans],
  ISNULL([11],0) AS [NoviembreVTrans],
  ISNULL([12],0) AS [DiciembreVTrans],
  " . implode($group_sum_tot) . " AS [TotVTrans]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '4.10.10.20.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroVDesc],
  ISNULL([2],0) AS [FebreroVDesc],
  ISNULL([3],0) AS [MarzoVDesc],
  ISNULL([4],0) AS [AbrilVDesc],
  ISNULL([5],0) AS [MayoVDesc],
  ISNULL([6],0) AS [JunioVDesc],
  ISNULL([7],0) AS [JulioVDesc],
  ISNULL([8],0) AS [AgostoVDesc],
  ISNULL([9],0) AS [SeptiembreVDesc],
  ISNULL([10],0) AS [OctubreVDesc],
  ISNULL([11],0) AS [NoviembreVDesc],
  ISNULL([12],0) AS [DiciembreVDesc],
  " . implode($group_sum_tot) . " AS [TotVDesc]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '4.10.10.50.01'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
  LEFT JOIN 
  (
  SELECT cntraCusr,
  ISNULL([1],0) AS [EneroImp],
  ISNULL([2],0) AS [FebreroImp],
  ISNULL([3],0) AS [MarzoImp],
  ISNULL([4],0) AS [AbrilImp],
  ISNULL([5],0) AS [MayoImp],
  ISNULL([6],0) AS [JunioImp],
  ISNULL([7],0) AS [JulioImp],
  ISNULL([8],0) AS [AgostoImp],
  ISNULL([9],0) AS [SeptiembreImp],
  ISNULL([10],0) AS [OctubreImp],
  ISNULL([11],0) AS [NoviembreImp],
  ISNULL([12],0) AS [DiciembreImp],
  " . implode($group_sum_tot) . " AS [TotImp]
  FROM
    (
    SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
    FROM cntrd
    LEFT JOIN cntra ON cntraNtra = cntrdNtra  
    join inloc ON inlocCloc = cntraCloc
    WHERE cntraStat = 1
    AND cntrdNcta = '5.30.20.10.02'
    AND cntrdMdel = 0
    AND CAST (cntrdFtra AS DATE) IS NOT NULL
    AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
    and inlocNomb <>('REGIONALES')
    GROUP BY cntraCusr, MONTH(cntrdFtra)
    ) AS venta
    PIVOT
    (
      SUM(total)
      FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
    ) AS PivoTable
  ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
  WHERE " . $usr . "
  AND adusrCusr NOT IN (29,57,74,61)
  ORDER BY adusrNomb;
  ";
  // dd($sql_usr);
  $total_seg_mayorista[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($query_usr_mayorista))];
}


//return dd($total_seg_mayorista[0]);


/////////////////////////////////////////////////////////////////////////////////////////////
    // dd($total_seg[0]['BALLIVIAN']);
    foreach ($almacen_reg as $key) {
      $alm = "inalmCalm IN (" . implode(",", $key['alm']) . ")";
      $sql_total_regional = "
      SELECT 
      " . implode($group_mes_sum) . "
      CONVERT(varchar, CAST(ISNULL(SUM([TotC2]),0) AS MONEY),1) AS [TotC2],
      -- CONVERT(varchar, CAST(ISNULL(SUM([Tot2]) + SUM([TotVTrans]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(sum(ISNULL([Tot2],0) + ISNULL([TotVTrans],0)) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([TotVDesc]),0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL(SUM([TotImp]),0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM inalm
      ) AS almacen
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [Tot2]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '5.30.20.10.02'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.vtvtaCalm = almacen.inalmCalm
      WHERE " . $alm . "";


      $total_regional[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_total_regional))];
      $sql_regional = "
      SELECT 
      inalmCalm, inalmNomb,
      " . implode($group_mes) . "
      CONVERT(varchar, CAST(ISNULL([TotC2],0) AS MONEY),1) AS [TotC2],
      CONVERT(varchar, CAST(ISNULL([Tot2],0) + ISNULL([TotVTrans],0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL([TotVDesc],0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL([TotImp],0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM inalm
      ) AS almacen
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [Tot2]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.vtvtaCalm = almacen.inalmCalm
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT vtvtaCalm, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        JOIN vtVta ON vtvtaNtra = cntraNtrI
        WHERE cntraStat = 1
        AND cntrdNcta = '5.30.20.10.02'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY vtvtaCalm, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.vtvtaCalm = almacen.inalmCalm
      WHERE " . $alm . "
      ORDER BY inalmNomb;
      ";
      // dd($sql_regional);
      $total_seg_regional[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_regional))];
    }
    foreach ($retail as $key) {
      $usr_retail = "adusrCusr IN (" . implode(",", $key['users']) . ")";
      $sql_total_retail = "
      SELECT 
      " . implode($group_mes_sum) . "
      CONVERT(varchar, CAST(ISNULL(SUM([TotC2]),0) AS MONEY),1) AS [TotC2],
      -- CONVERT(varchar, CAST(ISNULL(SUM([Tot2]) + SUM([TotVTrans]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(sum(ISNULL([Tot2],0) + ISNULL([TotVTrans],0)) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([TotVDesc]),0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL(SUM([TotImp]),0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [Tot2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '5.30.20.10.02'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
      WHERE " . $usr_retail . "";
      // dd($sql_total_retail);
      $total_retail[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_total_retail))];
    }

    $sql_total_retail_calacoto = "
      SELECT
      " . implode($group_mes_sum) . "
      CONVERT(varchar, CAST(ISNULL(SUM([TotC2]),0) AS MONEY),1) AS [TotC2],  
         CONVERT(varchar, CAST(ISNULL(SUM([Tot2]) + SUM([TotVTrans]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([TotVDesc]),0) AS MONEY),1) AS [TotVDesc],
      CONVERT(varchar, CAST(ISNULL(SUM([TotImp]),0) AS MONEY),1) AS [TotImp]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [Enero2],
      ISNULL([2],0) AS [Febrero2],
      ISNULL([3],0) AS [Marzo2],
      ISNULL([4],0) AS [Abril2],
      ISNULL([5],0) AS [Mayo2],
      ISNULL([6],0) AS [Junio2],
      ISNULL([7],0) AS [Julio2],
      ISNULL([8],0) AS [Agosto2],
      ISNULL([9],0) AS [Septiembre2],
      ISNULL([10],0) AS [Octubre2],
      ISNULL([11],0) AS [Noviembre2],
      ISNULL([12],0) AS [Diciembre2],
      " . implode($group_sum_tot) . " AS [Tot2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroC2],
      ISNULL([2],0) AS [FebreroC2],
      ISNULL([3],0) AS [MarzoC2],
      ISNULL([4],0) AS [AbrilC2],
      ISNULL([5],0) AS [MayoC2],
      ISNULL([6],0) AS [JunioC2],
      ISNULL([7],0) AS [JulioC2],
      ISNULL([8],0) AS [AgostoC2],
      ISNULL([9],0) AS [SeptiembreC2],
      ISNULL([10],0) AS [OctubreC2],
      ISNULL([11],0) AS [NoviembreC2],
      ISNULL([12],0) AS [DiciembreC2],
      " . implode($group_sum_tot) . " AS [TotC2]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '5.10.10.10.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventacosto ON totalventacosto.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVTrans],
      ISNULL([2],0) AS [FebreroVTrans],
      ISNULL([3],0) AS [MarzoVTrans],
      ISNULL([4],0) AS [AbrilVTrans],
      ISNULL([5],0) AS [MayoVTrans],
      ISNULL([6],0) AS [JunioVTrans],
      ISNULL([7],0) AS [JulioVTrans],
      ISNULL([8],0) AS [AgostoVTrans],
      ISNULL([9],0) AS [SeptiembreVTrans],
      ISNULL([10],0) AS [OctubreVTrans],
      ISNULL([11],0) AS [NoviembreVTrans],
      ISNULL([12],0) AS [DiciembreVTrans],
      " . implode($group_sum_tot) . " AS [TotVTrans]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImCo) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.20.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventatrans ON totalventatrans.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroVDesc],
      ISNULL([2],0) AS [FebreroVDesc],
      ISNULL([3],0) AS [MarzoVDesc],
      ISNULL([4],0) AS [AbrilVDesc],
      ISNULL([5],0) AS [MayoVDesc],
      ISNULL([6],0) AS [JunioVDesc],
      ISNULL([7],0) AS [JulioVDesc],
      ISNULL([8],0) AS [AgostoVDesc],
      ISNULL([9],0) AS [SeptiembreVDesc],
      ISNULL([10],0) AS [OctubreVDesc],
      ISNULL([11],0) AS [NoviembreVDesc],
      ISNULL([12],0) AS [DiciembreVDesc],
      " . implode($group_sum_tot) . " AS [TotVDesc]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
        AND cntrdNcta = '4.10.10.50.01'
        AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventadesc ON totalventadesc.cntraCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT cntraCusr,
      ISNULL([1],0) AS [EneroImp],
      ISNULL([2],0) AS [FebreroImp],
      ISNULL([3],0) AS [MarzoImp],
      ISNULL([4],0) AS [AbrilImp],
      ISNULL([5],0) AS [MayoImp],
      ISNULL([6],0) AS [JunioImp],
      ISNULL([7],0) AS [JulioImp],
      ISNULL([8],0) AS [AgostoImp],
      ISNULL([9],0) AS [SeptiembreImp],
      ISNULL([10],0) AS [OctubreImp],
      ISNULL([11],0) AS [NoviembreImp],
      ISNULL([12],0) AS [DiciembreImp],
      " . implode($group_sum_tot) . " AS [TotImp]
      FROM
        (
        SELECT cntraCusr, MONTH(cntrdFtra) [mes], (-1)*SUM(cntrdImHc - cntrdImDc) AS total
        FROM cntrd
        LEFT JOIN cntra ON cntraNtra = cntrdNtra  
        WHERE cntraStat = 1
       AND cntrdNcta = '5.30.20.10.02'
   -- AND cntrdNcta = '5.20.20.35.02'
    AND cntrdMdel = 0
        AND CAST (cntrdFtra AS DATE) IS NOT NULL
        AND YEAR(CAST (cntrdFtra AS DATE)) = 2022
        GROUP BY cntraCusr, MONTH(cntrdFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalimpuesto ON totalimpuesto.cntraCusr = usr.adusrCusr
      WHERE adusrCusr IN (29,57,74)";
     // dd($sql_total_retail);
      $total_retail_calacoto = DB::connection('sqlsrv')->select(DB::raw($sql_total_retail_calacoto));






      // dd($total_seg[0]['BALLIVIAN']);
    
    if ($request->gen == "export") {
      $export = new ResumenVentasExport();
      return Excel::download($export, 'Reporte de Stock Actual.xlsx');
    } else {
      //return dd($titulos);
      return view('reports.vista.resumenxmescosto', compact('totalMayorista','total_seg_mayorista','total_general', 'total', 'total_seg', 'total_retail', 'options', 'total_regional', 'total_seg_regional', 'total_retail_calacoto'));
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
