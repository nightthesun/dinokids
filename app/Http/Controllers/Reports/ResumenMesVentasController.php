<?php

namespace App\Http\Controllers\Reports;

use App\Exports\ResumenMexVentasExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PhpParser\Node\Stmt\Foreach_;
use App\Exports\ResumenVentasExport;

class ResumenMesVentasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('reports.resumenxmes');
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
      ['name' => 'BALLIVIAN', 'abrv' => 'BALLIVIAN', 'users' => [22, 41, 49, 46,61, 68, 9, 65,80]],
      ['name' => 'HANDAL', 'abrv' => 'HANDAL', 'users' => [26, 42, 50, 28,69]],
      ['name' => 'MARISCAL', 'abrv' => 'MARISCAL', 'users' => [38, 44, 51, 37, 67]],
      ['name' => 'CALACOTO', 'abrv' => 'CALACOTO', 'users' => [29,57,74,32,43,52]],
      ['name' => 'SAN MIGUEL', 'abrv' => 'SAN MIGUEL', 'users' => [76,77,78]],
      ['name' => 'INSTITUCIONALES', 'abrv' => 'INSTITUCIONALES', 'users' => [16, 17, 62, 56, 3, 58, 4]],
      ['name' => 'MAYORISTAS', 'abrv' => 'MAYORISTAS', 'users' => [18, 19, 55, 21, 20]],
      ['name' => 'SANTA CRUZ', 'abrv' => 'SANTA CRUZ', 'users' => [40, 39]],
    ];
    $retail = [
      ['name'  => 'BALLIVIAN', 'abrv' => 'BALLIVIAN', 'users' => [22, 49, 68]],
      ['name' => 'HANDAL', 'abrv' => 'HANDAL', 'users' => [26, 50, 69]],
      ['name' => 'MARISCAL', 'abrv' => 'MARISCAL', 'users' => [38, 51, 67]],
      ['name' => 'CALACOTO', 'abrv' => 'CALACOTO', 'users' => [32, 52]],
      ['name' => 'SAN MIGUEL', 'abrv' => 'SAN MIGUEL', 'users' => [76,77]],
      ['name' => 'INS CALACOTO', 'abrv' => 'INS CALACOTO', 'users' => [29,57,74]],
      ['name' => 'CAJERO LIBRO CALACOTO', 'abrv' => 'CAJERO LIBRO CALACOTO', 'users' => [43]],

    ];
     
    $regional = [
      ['name' => 'REGIONAL1', 'abrv' => 'REGIONAL1', 'usr' => [63]],
      ['name' => 'REGIONAL2', 'abrv' => 'REGIONAL2', 'usr' => [64]],
    ];
    $almacen_reg = [
      ['name' => 'REGIONAL1', 'abrv' => 'REGIONAL1', 'alm' => [57, 58]],
      ['name' => 'REGIONAL2', 'abrv' => 'REGIONAL2', 'alm' => [59, 60, 61]],
    ];
    $general = [22, 41, 49, 46,61, 68, 9, 65, 26, 42, 50, 28,69, 38, 44, 51, 37, 67, 29,57,74,32,43,52,76,77,78,16, 17, 62, 56, 3, 58, 4,18, 19, 55, 21, 20,40, 39,63,64,80];

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
        $group_mes_sum[] = "CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "1]),0) AS MONEY),1) AS [" . $value . "1],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "2]),0) AS MONEY),1) AS [" . $value . "2],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "3]),0) AS MONEY),1) AS [" . $value . "3],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "4]),0) AS MONEY),1) AS [" . $value . "4],
        CONVERT(varchar, CAST(ISNULL(SUM([" . $value . "5]),0) AS MONEY),1) AS [" . $value . "5],";
        $group_mes[] = "CONVERT(varchar, CAST(ISNULL([" . $value . "1],0) AS MONEY),1) AS [" . $value . "1],
        CONVERT(varchar, CAST(ISNULL([" . $value . "2],0) AS MONEY),1) AS [" . $value . "2],
        CONVERT(varchar, CAST(ISNULL([" . $value . "3],0) AS MONEY),1) AS [" . $value . "3],
        CONVERT(varchar, CAST(ISNULL([" . $value . "4],0) AS MONEY),1) AS [" . $value . "4],
        CONVERT(varchar, CAST(ISNULL([" . $value . "5],0) AS MONEY),1) AS [" . $value . "5],";
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
    $query_general = "
    SELECT 
      " . implode($group_mes_sum) . "
      --CONVERT(varchar, CAST(ISNULL(SUM([Tot1]),0) AS MONEY),1) AS [Tot1],
      --CONVERT(varchar, CAST(ISNULL(SUM([Tot2]),0) AS MONEY),1) AS [Tot2]
      ISNULL(SUM([Tot1]),0) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot2]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot3]),0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot4]),0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot5]),0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
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
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCusr = usr.adusrCusr
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
		    left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
		    and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCusr = usr.adusrCusr
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        LEFT JOIN imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        AND imLvtNrfc is NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCusr = usr.adusrCusr
      WHERE " . $usr_general . "
    ";
    // dd($query_general);
    $total_general = DB::connection('sqlsrv')->select(DB::raw($query_general));
    $total = [];
    foreach ($segmento as $key) {
      $usr_total = "adusrCusr IN (" . implode(",", $key['users']) . ")";
      $usr = "adusrCusr IN (" . implode(",", $key['users']) . ") AND adusrCusr NOT IN (22,49,68,26,50,69,38,51,67,32,52,76,77)";
      $sql_total = "
      SELECT 
      " . implode($group_mes_sum) . "
      ISNULL(SUM([Tot1]),0) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot2]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot3]),0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot4]),0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot5]),0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
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
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCusr = usr.adusrCusr
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
		    left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
		    and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCusr = usr.adusrCusr
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCusr = usr.adusrCusr
      WHERE " . $usr_total . "";
      $total[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_total))];
      $sql_usr = "
      SELECT 
      adusrCusr, adusrNomb,
      " . implode($group_mes) . "
      ISNULL([Tot1],0) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL([Tot2],0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL([Tot3],0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL([Tot4],0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL([Tot5],0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
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
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCusr = usr.adusrCusr
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCusr = usr.adusrCusr
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCusr = usr.adusrCusr
      WHERE " . $usr . "
      AND adusrCusr NOT IN (29,57,74)
      ORDER BY adusrNomb;
      ";
      $total_seg[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_usr))];
    }
    // dd($sql_usr);
    // dd($total_seg);
    foreach ($almacen_reg as $key) {
      $alm = "inalmCalm IN (" . implode(",", $key['alm']) . ")";
      $sql_total_regional = "
      SELECT 
      " . implode($group_mes_sum) . "
      CONVERT(varchar, CAST(ISNULL(SUM([Tot1]),0) AS MONEY),1) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot2]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot3]),0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot4]),0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot5]),0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM inalm
      ) AS almacen
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCalm = almacen.inalmCalm
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
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
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
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCalm = almacen.inalmCalm
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCalm = almacen.inalmCalm
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NULL
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCalm = almacen.inalmCalm
      WHERE " . $alm . "";
      $total_regional[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_total_regional))];
      $sql_regional = "
      SELECT 
      inalmCalm, inalmNomb,
      " . implode($group_mes) . "
      CONVERT(varchar, CAST(ISNULL([Tot1],0) AS MONEY),1) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL([Tot2],0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL([Tot3],0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL([Tot4],0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL([Tot5],0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM inalm
      ) AS almacen
      LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCalm = almacen.inalmCalm
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
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
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
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCalm = almacen.inalmCalm
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCalm = almacen.inalmCalm
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCalm,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCalm, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NULL
        GROUP BY vtvtaCalm, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCalm = almacen.inalmCalm
      WHERE " . $alm . "
      ORDER BY inalmNomb;
      ";
      $total_seg_regional[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_regional))];
    }
    foreach ($retail as $key) {
      $usr_retail = "adusrCusr IN (" . implode(",", $key['users']) . ")";
      $sql_total_retail = "
      SELECT 
      " . implode($group_mes_sum) . "
      ISNULL(SUM([Tot1]),0) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot2]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot3]),0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot4]),0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot5]),0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
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
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCusr = usr.adusrCusr
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4] 
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCusr = usr.adusrCusr
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCusr = usr.adusrCusr
      WHERE " . $usr_retail . "";
      //dd($sql_total_retail);
      $total_retail[] = [$key['name'] => DB::connection('sqlsrv')->select(DB::raw($sql_total_retail))];
    }

    $sql_total_retail_calacoto = "
      SELECT
      " . implode($group_mes_sum) . "
      ISNULL(SUM([Tot1]),0) AS [Tot1],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot2]),0) AS MONEY),1) AS [Tot2],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot3]),0) AS MONEY),1) AS [Tot3],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot4]),0) AS MONEY),1) AS [Tot4],
      CONVERT(varchar, CAST(ISNULL(SUM([Tot5]),0) AS MONEY),1) AS [Tot5]
      FROM
      (
        SELECT *
        FROM bd_admOlimpia.dbo.adusr
      ) AS usr
      LEFT JOIN
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero1],
      ISNULL([2],0) AS [Febrero1],
      ISNULL([3],0) AS [Marzo1],
      ISNULL([4],0) AS [Abril1],
      ISNULL([5],0) AS [Mayo1],
      ISNULL([6],0) AS [Junio1],
      ISNULL([7],0) AS [Julio1],
      ISNULL([8],0) AS [Agosto1],
      ISNULL([9],0) AS [Septiembre1],
      ISNULL([10],0) AS [Octubre1],
      ISNULL([11],0) AS [Noviembre1],
      ISNULL([12],0) AS [Diciembre1],
      " . implode($group_sum_tot) . " AS [tot1]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2021
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa1 ON totalventa1.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
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
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2022
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa2 ON totalventa2.vtvtaCusr = usr.adusrCusr
      LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero3],
      ISNULL([2],0) AS [Febrero3],
      ISNULL([3],0) AS [Marzo3],
      ISNULL([4],0) AS [Abril3],
      ISNULL([5],0) AS [Mayo3],
      ISNULL([6],0) AS [Junio3],
      ISNULL([7],0) AS [Julio3],
      ISNULL([8],0) AS [Agosto3],
      ISNULL([9],0) AS [Septiembre3],
      ISNULL([10],0) AS [Octubre3],
      ISNULL([11],0) AS [Noviembre3],
      ISNULL([12],0) AS [Diciembre3],
      " . implode($group_sum_tot) . " AS [Tot3]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) totalventa3 ON totalventa3.vtvtaCusr = usr.adusrCusr
      --------- con factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero4],
      ISNULL([2],0) AS [Febrero4],
      ISNULL([3],0) AS [Marzo4],
      ISNULL([4],0) AS [Abril4],
      ISNULL([5],0) AS [Mayo4],
      ISNULL([6],0) AS [Junio4],
      ISNULL([7],0) AS [Julio4],
      ISNULL([8],0) AS [Agosto4],
      ISNULL([9],0) AS [Septiembre4],
      ISNULL([10],0) AS [Octubre4],
      ISNULL([11],0) AS [Noviembre4],
      ISNULL([12],0) AS [Diciembre4],
      " . implode($group_sum_tot) . " AS [Tot4]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NOT NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) conFactura ON conFactura.vtvtaCusr = usr.adusrCusr
	  --------- SIN factura---
	  LEFT JOIN 
      (
      SELECT vtvtaCusr,
      ISNULL([1],0) AS [Enero5],
      ISNULL([2],0) AS [Febrero5],
      ISNULL([3],0) AS [Marzo5],
      ISNULL([4],0) AS [Abril5],
      ISNULL([5],0) AS [Mayo5],
      ISNULL([6],0) AS [Junio5],
      ISNULL([7],0) AS [Julio5],
      ISNULL([8],0) AS [Agosto5],
      ISNULL([9],0) AS [Septiembre5],
      ISNULL([10],0) AS [Octubre5],
      ISNULL([11],0) AS [Noviembre5],
      ISNULL([12],0) AS [Diciembre5],
      " . implode($group_sum_tot) . " AS [Tot5]
      FROM
        (
        SELECT vtvtaCusr, MONTH(vtvtaFtra) [mes], SUM(vtvtdImpT - vtvtdDesT) AS total
        FROM vtVta
        JOIN vtVtd on vtvtdNtra = vtvtaNtra
        left join imLvt on imlvtNvta = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND vtvtaFtra IS NOT NULL
        AND YEAR(vtvtaFtra) = 2023
        and imLvtNrfc is NULL
        GROUP BY vtvtaCusr, MONTH(vtvtaFtra)
        ) AS venta
        PIVOT
        (
          SUM(total)
          FOR [mes] IN([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])
        ) AS PivoTable
      ) sinFactura ON sinFactura.vtvtaCusr = usr.adusrCusr
      WHERE adusrCusr IN (29,57,74)";
      //dd($sql_total_retail);
      $total_retail_calacoto = DB::connection('sqlsrv')->select(DB::raw($sql_total_retail_calacoto));

      // dd($total_retail_calacoto[0]);

    //! BALLIVIAN

    $ballExcel = [
      'retail' => [
        '2019' => ['Enero' => 186044.81, 'Febrero' => 268987.64, 'Marzo' => 118553.95, 'Abril' => 127472.30, 'Mayo' => 101707.24, 'Junio' => 105679.51, 'Julio' => 122298.99, 'Agosto' => 103953.14, 'Septiembre' => 122265.63, 'Octubre' => 110176.42, 'Noviembre' => 101186.86, 'Diciembre' => 143692.43],
        '2020' => ['Enero' => 155402.37, 'Febrero' => 219199.19, 'Marzo' => 59161.67, 'Abril' => 0, 'Mayo' => 111.72, 'Junio' => 95990.49, 'Julio' => 49237.09, 'Agosto' => 57718.75, 'Septiembre' => 92762.62, 'Octubre' => 80767.23, 'Noviembre' => 181953.82, 'Diciembre' => 116644.91],
        '2021' => ['Enero' => 110191.12, 'Febrero' => 161395.70, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'libros' => [
        '2019' => ['Enero' => 34681.10, 'Febrero' => 226669.10, 'Marzo' => 53699.00, 'Abril' => 20797.80, 'Mayo' => 18148.70, 'Junio' => 9921.65, 'Julio' => 13390.90, 'Agosto' => 9987.60, 'Septiembre' => 29328.05, 'Octubre' => 13426.50, 'Noviembre' => 3546.10, 'Diciembre' => 11672.55],
        '2020' => ['Enero' => 51279.30, 'Febrero' => 244799.70, 'Marzo' => 37423.20, 'Abril' => 0, 'Mayo' => 611.30, 'Junio' => 13355.80, 'Julio' => 6754.60, 'Agosto' => 6584.40, 'Septiembre' => 9148.90, 'Octubre' => 14298.98, 'Noviembre' => 12334.70, 'Diciembre' => 8234.82],
        '2021' => ['Enero' => 11546.90, 'Febrero' => 136346.80, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'instit' => [
        '2019' => ['Enero' => 10541.11, 'Febrero' => 4982.37, 'Marzo' => 5025.15, 'Abril' => 7765.69, 'Mayo' => 10391.18, 'Junio' => 34635.60, 'Julio' => 5667.62, 'Agosto' => 6171.23, 'Septiembre' => 51452.55, 'Octubre' => 9205.80, 'Noviembre' => 23525.70, 'Diciembre' => 14567.71],
        '2020' => ['Enero' => 11060.06, 'Febrero' => 14108.67, 'Marzo' => 31481.55, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 4043.40, 'Julio' => 36627.93, 'Agosto' => 12191.53, 'Septiembre' => 14319.95, 'Octubre' => 0, 'Noviembre' => 770.06, 'Diciembre' => 12965.31],
        '2021' => ['Enero' => 20685.00, 'Febrero' => 4530.41, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'feria' => [
        '2019' => ['Enero' => 176193.96, 'Febrero' => 87893.05, 'Marzo' => 13517.70, 'Abril' => 5163.70, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 39651.95, 'Septiembre' => 6011.16, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
        '2020' => ['Enero' => 14004.66, 'Febrero' => 29623.95, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
        '2021' => ['Enero' => 0, 'Febrero' => 4201.00, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arrayball19 = [];
    $arrayball20 = [];
    $arrayball21 = [];
    $count19 = 0;
    $count20 = 0;
    $count21 = 0;
    foreach ($ballExcel as $key => $value) {
      // dd($key);
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arrayball19 [$key] = $count19;
      $arrayball20 [$key] = $count20;
      $arrayball21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    //! HANDAL
    
    $handalExcel = [
      'retail' => [
        '2019' => ['Enero' => 274144.45, 'Febrero' => 419893.24, 'Marzo' => 167023.05, 'Abril' => 179004.95, 'Mayo' => 136155.37, 'Junio' => 123860.85, 'Julio' => 176196.99, 'Agosto' => 163614.60, 'Septiembre' => 157165.02, 'Octubre' => 115504.47, 'Noviembre' => 156444.62, 'Diciembre' => 186676.54],
        '2020' => ['Enero' => 267218.90, 'Febrero' => 306195.73, 'Marzo' => 91813.56, 'Abril' => 91052.94, 'Mayo' => 86063.26, 'Junio' => 94748.40, 'Julio' => 91624.98, 'Agosto' => 81704.04, 'Septiembre' => 150834.58, 'Octubre' => 128420.92, 'Noviembre' => 176059.77, 'Diciembre' => 177705.89],
        '2021' => ['Enero' => 157651.54, 'Febrero' => 232684.22, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'libros' => [
        '2019' => ['Enero' => 18352.20, 'Febrero' => 60403.77, 'Marzo' => 7239.30, 'Abril' => 3360.31, 'Mayo' => 3440.80, 'Junio' => 901.60, 'Julio' => 1668.10, 'Agosto' => 4047.00, 'Septiembre' => 4327.40, 'Octubre' => 2957.05, 'Noviembre' => 2860.50, 'Diciembre' => 4111.47],
        '2020' => ['Enero' => 19246.50, 'Febrero' => 97490.70, 'Marzo' => 5770.00, 'Abril' => 0, 'Mayo' => 90.00, 'Junio' => 3616.65, 'Julio' => 10415.88, 'Agosto' => 4053.50, 'Septiembre' => 4324.60, 'Octubre' => 4062.69, 'Noviembre' => 3023.73, 'Diciembre' => 8234.82],
        '2021' => ['Enero' => 3183.52, 'Febrero' => 3038.60, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'instit' => [
        '2019' => ['Enero' => 73374.55, 'Febrero' => 270253.50, 'Marzo' => 216752.61, 'Abril' => 129993.47, 'Mayo' => 91146.81, 'Junio' => 136632.02, 'Julio' => 159797.08, 'Agosto' => 124563.32, 'Septiembre' => 299600.39, 'Octubre' => 144152.54, 'Noviembre' => 164127.86, 'Diciembre' => 143224.22],
        '2020' => ['Enero' => 160477.72, 'Febrero' => 136762.07, 'Marzo' => 65483.02, 'Abril' => 0, 'Mayo' => 5100.10, 'Junio' => 106952.12, 'Julio' => 90941.95, 'Agosto' => 150566.17, 'Septiembre' => 171282.83, 'Octubre' => 97242.09, 'Noviembre' => 174335.79, 'Diciembre' => 160743.31],
        '2021' => ['Enero' => 90191.79, 'Febrero' => 239354.23, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arrayHandal19 = [];
    $arrayHandal20 = [];
    $arrayHandal21 = [];
    foreach ($handalExcel as $key => $value) {
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arrayHandal19 [$key] = $count19;
      $arrayHandal20 [$key] = $count20;
      $arrayHandal21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    //! MARISCAL

    $mariscalExcel = [
      'retail' => [
        '2019' => ['Enero' => 139257.18, 'Febrero' => 255637.72, 'Marzo' => 127112.42, 'Abril' => 128845.72, 'Mayo' => 146267.67, 'Junio' => 108023.21, 'Julio' => 136960.99, 'Agosto' => 132660.19, 'Septiembre' => 145945.74, 'Octubre' => 117045.45, 'Noviembre' => 136512.41, 'Diciembre' => 173699.74],
        '2020' => ['Enero' => 204444.73, 'Febrero' => 270185.50, 'Marzo' => 113780.45, 'Abril' => 0, 'Mayo' => 13974.22, 'Junio' => 121955.90, 'Julio' => 98813.50, 'Agosto' => 110981.46, 'Septiembre' => 141665.40, 'Octubre' => 140215.57, 'Noviembre' => 172578.03, 'Diciembre' => 195237.06],
        '2021' => ['Enero' => 138752.06, 'Febrero' => 250795.79, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'libros' => [
        '2019' => ['Enero' => 415.80, 'Febrero' => 4106.75, 'Marzo' => 390.00, 'Abril' => 431.00, 'Mayo' => 224.00, 'Junio' => 0, 'Julio' => 50.00, 'Agosto' => 103.50, 'Septiembre' => 132.00, 'Octubre' => 151.00, 'Noviembre' => 176.76, 'Diciembre' => 174.24],
        '2020' => ['Enero' => 589.90, 'Febrero' => 3765.70, 'Marzo' => 273.80, 'Abril' => 0, 'Mayo' => 18.80, 'Junio' => 570.00, 'Julio' => 154.30, 'Agosto' => 201.70, 'Septiembre' => 545.30, 'Octubre' => 358.30, 'Noviembre' => 66.15, 'Diciembre' => 174.80],
        '2021' => ['Enero' => 187.20, 'Febrero' => 1088.10, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'instit' => [
        '2019' => ['Enero' => 34817.38, 'Febrero' => 187834.00, 'Marzo' => 142814.11, 'Abril' => 145192.65, 'Mayo' => 289214.41, 'Junio' => 272603.11, 'Julio' => 120757.42, 'Agosto' => 155312.17, 'Septiembre' => 159496.19, 'Octubre' => 166601.43, 'Noviembre' => 145672.90, 'Diciembre' => 261670.65],
        '2020' => ['Enero' => 57344.91, 'Febrero' => 156969.00, 'Marzo' => 107689.41, 'Abril' => 19580.20, 'Mayo' => 18782.01, 'Junio' => 119480.03, 'Julio' => 172539.19, 'Agosto' => 121706.24, 'Septiembre' => 121652.88, 'Octubre' => 162944.47, 'Noviembre' => 225398.67, 'Diciembre' => 145605.58],
        '2021' => ['Enero' => 94396.88, 'Febrero' => 93447.16, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arrayMariscal19 = [];
    $arrayMariscal20 = [];
    $arrayMariscal21 = [];
    foreach ($mariscalExcel as $key => $value) {
      // dd($key);
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arrayMariscal19 [$key] = $count19;
      $arrayMariscal20 [$key] = $count20;
      $arrayMariscal21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    //! CALACOTO

    $calacotoExcel = [
      'retail' => [
        '2019' => ['Enero' => 322633.68, 'Febrero' => 250973.59, 'Marzo' => 100386.14, 'Abril' => 110301.08, 'Mayo' => 96695.56, 'Junio' => 80235.27, 'Julio' => 109747.11, 'Agosto' => 119887.80, 'Septiembre' => 109141.26, 'Octubre' => 111221.38, 'Noviembre' => 108726.54, 'Diciembre' => 142288.64],
        '2020' => ['Enero' => 303527.40, 'Febrero' => 196544.81, 'Marzo' => 77526.19, 'Abril' => 0, 'Mayo' => 10704.97, 'Junio' => 73498.19, 'Julio' => 76525.02, 'Agosto' => 65777.11, 'Septiembre' => 92312.48, 'Octubre' => 115002.42, 'Noviembre' => 130162.52, 'Diciembre' => 157280.18],
        '2021' => ['Enero' => 239079.09, 'Febrero' => 173843.24, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'libros' => [
        '2019' => ['Enero' => 49711.20, 'Febrero' => 33861.30, 'Marzo' => 2289.25, 'Abril' => 2398.98, 'Mayo' => 2322.10, 'Junio' => 2719.30, 'Julio' => 2316.40, 'Agosto' => 4454.60, 'Septiembre' => 4347.50, 'Octubre' => 3448.80, 'Noviembre' => 2425.60, 'Diciembre' => 4893.07],
        '2020' => ['Enero' => 5368.45, 'Febrero' => 5002.50, 'Marzo' => 2860.40, 'Abril' => 0, 'Mayo' => 388.34, 'Junio' => 3084.50, 'Julio' => 2842.30, 'Agosto' => 2346.40, 'Septiembre' => 2806.10, 'Octubre' => 4499.08, 'Noviembre' => 4263.41, 'Diciembre' => 4401.70],
        '2021' => ['Enero' => 3167.52, 'Febrero' => 2191.83, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'instit' => [
        '2019' => ['Enero' => 58658.03, 'Febrero' => 36515.78, 'Marzo' => 50105.12, 'Abril' => 58344.25, 'Mayo' => 45640.09, 'Junio' => 72011.68, 'Julio' => 48594.34, 'Agosto' => 54947.39, 'Septiembre' => 68784.07, 'Octubre' => 50196.26, 'Noviembre' => 58692.88, 'Diciembre' => 66394.85],
        '2020' => ['Enero' => 59036.27, 'Febrero' => 50183.76, 'Marzo' => 40103.23, 'Abril' => 0, 'Mayo' => 11217.54, 'Junio' => 114254.97, 'Julio' => 35625.82, 'Agosto' => 25847.90, 'Septiembre' => 79222.62, 'Octubre' => 50408.32, 'Noviembre' => 369001.97, 'Diciembre' => 64804.62],
        '2021' => ['Enero' => 34969.61, 'Febrero' => 34207.79, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arrayCalacoto19 = [];
    $arrayCalacoto20 = [];
    $arrayCalacoto21 = [];
    foreach ($calacotoExcel as $key => $value) {
      // dd($key);
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arrayCalacoto19 [$key] = $count19;
      $arrayCalacoto20 [$key] = $count20;
      $arrayCalacoto21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    //! INSTITUCIONALES

    $institucionalExcel = [
      'velasquez' => [
        '2019' => ['Enero' => 19343.59, 'Febrero' => 46078.97, 'Marzo' => 34589.33, 'Abril' => 141123.06, 'Mayo' => 296923.93, 'Junio' => 39356.60, 'Julio' => 37778.35, 'Agosto' => 43298.50, 'Septiembre' => 123230.75, 'Octubre' => 5357.20, 'Noviembre' => 17623.95, 'Diciembre' => 22077.25],
        '2020' => ['Enero' => 11031.27, 'Febrero' => 72659.20, 'Marzo' => 44866.42, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 51718.26, 'Julio' => 91642.54, 'Agosto' => 17553.17, 'Septiembre' => 83476.25, 'Octubre' => 120691.84, 'Noviembre' => 72648.80, 'Diciembre' => 45986.13],
        '2021' => ['Enero' => 7966.40, 'Febrero' => 28087.33, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'gamba' => [
        '2019' => ['Enero' => 35646.87, 'Febrero' => 152593.01, 'Marzo' => 149090.63, 'Abril' => 77952.13, 'Mayo' => 230941.47, 'Junio' => 59090.49, 'Julio' => 70894.69, 'Agosto' => 36046.11, 'Septiembre' => 131789.30, 'Octubre' => 199752.18, 'Noviembre' => 112426.35, 'Diciembre' => 30234.92],
        '2020' => ['Enero' => 558566.78, 'Febrero' => 45122.43, 'Marzo' => 246745.56, 'Abril' => 0, 'Mayo' => 9305.10, 'Junio' => 155482.44, 'Julio' => 27380.93, 'Agosto' => 100105.90, 'Septiembre' => 54232.90, 'Octubre' => 135060.62, 'Noviembre' => 281941.17, 'Diciembre' => 139206.17],
        '2021' => ['Enero' => 36014.22, 'Febrero' => 528808.22, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'contra' => [
        '2019' => ['Enero' => 51983.30, 'Febrero' => 163569.13, 'Marzo' => 242920.12, 'Abril' => 100498.15, 'Mayo' => 218356.84, 'Junio' => 101918.35, 'Julio' => 139081.04, 'Agosto' => 110767.28, 'Septiembre' => 156364.41, 'Octubre' => 168512.94, 'Noviembre' => 67193.29, 'Diciembre' => 165125.38],
        '2020' => ['Enero' => 168035.32, 'Febrero' => 43661.58, 'Marzo' => 11419.55, 'Abril' => 424.40, 'Mayo' => 133308.65, 'Junio' => 175994.54, 'Julio' => 239691.90, 'Agosto' => 49067.00, 'Septiembre' => 51939.07, 'Octubre' => 154449.40, 'Noviembre' => 127393.64, 'Diciembre' => 250303.45],
        '2021' => ['Enero' => 91924.15, 'Febrero' => 41587.36, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arrayInstitucional19 = [];
    $arrayInstitucional20 = [];
    $arrayInstitucional21 = [];
    foreach ($institucionalExcel as $key => $value) {
      // dd($key);
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arrayInstitucional19 [$key] = $count19;
      $arrayInstitucional20 [$key] = $count20;
      $arrayInstitucional21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    //! MAYORISTAS

    $mayoristasExcel = [
      'ticona' => [
        '2019' => ['Enero' => 471071.60, 'Febrero' => 895147.10, 'Marzo' => 315491.86, 'Abril' => 124334.92, 'Mayo' => 130663.28, 'Junio' => 109068.20, 'Julio' => 124515.80, 'Agosto' => 230540.20, 'Septiembre' => 229356.82, 'Octubre' => 99367.00, 'Noviembre' => 66381.80, 'Diciembre' => 237718.54],
        '2020' => ['Enero' => 695014.10, 'Febrero' => 782622.82, 'Marzo' => 217131.50, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 238801.70, 'Julio' => 25146.72, 'Agosto' => 41466.10, 'Septiembre' => 96174.00, 'Octubre' => 82459.50, 'Noviembre' => 73258.70, 'Diciembre' => 63462.40],
        '2021' => ['Enero' => 233271.20, 'Febrero' => 592159.80, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'villarroel' => [
        '2019' => ['Enero' => 167879.50, 'Febrero' => 115210.32, 'Marzo' => 96938.26, 'Abril' => 0, 'Mayo' => 2893.60, 'Junio' => 161885.18, 'Julio' => 97510.00, 'Agosto' => 0, 'Septiembre' => 42805.86, 'Octubre' => 35214.65, 'Noviembre' => 13531.92, 'Diciembre' => 59859.44],
        '2020' => ['Enero' => 131158.13, 'Febrero' => 61972.40, 'Marzo' => 12931.50, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 17493.67, 'Julio' => 16667.70, 'Agosto' => 4194.90, 'Septiembre' => 56978.16, 'Octubre' => 21349.70, 'Noviembre' => 24973.50, 'Diciembre' => 38963.50],
        '2021' => ['Enero' => 60634.90, 'Febrero' => 81860.45, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'mamani' => [
        '2019' => ['Enero' => 234000.10, 'Febrero' => 97270.11, 'Marzo' => 40934.00, 'Abril' => 169941.29, 'Mayo' => 112117.20, 'Junio' => 111963.41, 'Julio' => 164138.92, 'Agosto' => 164484.67, 'Septiembre' => 132193.47, 'Octubre' => 37255.96, 'Noviembre' => 106371.44, 'Diciembre' => 104609.00],
        '2020' => ['Enero' => 132259.06, 'Febrero' => 270771.12, 'Marzo' => 60769.78, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 68675.90, 'Julio' => 59022.65, 'Agosto' => 35017.10, 'Septiembre' => 86120.45, 'Octubre' => 126435.72, 'Noviembre' => 99285.34, 'Diciembre' => 52637.50],
        '2021' => ['Enero' => 171059.50, 'Febrero' => 136383.62, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'cutipa' => [
        '2019' => ['Enero' => 0, 'Febrero' => 0, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
        '2020' => ['Enero' => 0, 'Febrero' => 0, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
        '2021' => ['Enero' => 0, 'Febrero' => 0, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arrayMayoristas19 = [];
    $arrayMayoristas20 = [];
    $arrayMayoristas21 = [];
    foreach ($mayoristasExcel as $key => $value) {
      // dd($key);
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arrayMayoristas19 [$key] = $count19;
      $arrayMayoristas20 [$key] = $count20;
      $arrayMayoristas21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    //! SANTA CRUZ

    $SCExcel = [
      'calderon' => [
        '2019' => ['Enero' => 313899.60, 'Febrero' => 84196.20, 'Marzo' => 20269.60, 'Abril' => 16910.00, 'Mayo' => 16608.14, 'Junio' => 24041.60, 'Julio' => 23293.10, 'Agosto' => 28173.70, 'Septiembre' => 26121.70, 'Octubre' => 14323.20, 'Noviembre' => 20671.00, 'Diciembre' => 22153.30],
        '2020' => ['Enero' => 406926.08, 'Febrero' => 255675.42, 'Marzo' => 10145.98, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 45236.60, 'Julio' => 27876.60, 'Agosto' => 24338.00, 'Septiembre' => 54160.80, 'Octubre' => 18012.00, 'Noviembre' => 63728.40, 'Diciembre' => 36449.70],
        '2021' => ['Enero' => 79235.80, 'Febrero' => 103164.00, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
      'escobar' => [
        '2019' => ['Enero' => 80553.50, 'Febrero' => 28458.00, 'Marzo' => 24318.24, 'Abril' => 31478.60, 'Mayo' => 8283.20, 'Junio' => 8648.30, 'Julio' => 20896.90, 'Agosto' => 57877.20, 'Septiembre' => 25290.00, 'Octubre' => 21738.48, 'Noviembre' => 9464.04, 'Diciembre' => 8762.00],
        '2020' => ['Enero' => 89986.96, 'Febrero' => 76304.52, 'Marzo' => 31766.00, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 8814.20, 'Agosto' => 18145.60, 'Septiembre' => 28367.20, 'Octubre' => 25743.70, 'Noviembre' => 19773.50, 'Diciembre' => 16035.40],
        '2021' => ['Enero' => 77633.50, 'Febrero' => 89201.20, 'Marzo' => 0, 'Abril' => 0, 'Mayo' => 0, 'Junio' => 0, 'Julio' => 0, 'Agosto' => 0, 'Septiembre' => 0, 'Octubre' => 0, 'Noviembre' => 0, 'Diciembre' => 0],
      ],
    ];

    $arraySC19 = [];
    $arraySC20 = [];
    $arraySC21 = [];
    foreach ($SCExcel as $key => $value) {
      // dd($key);
      foreach ($options as $i => $j) {
        $count19 = $count19 + $value[2019][$j];
        $count20 = $count20 + $value[2020][$j];
        $count21 = $count21 + $value[2021][$j];
      }
      $arraySC19 [$key] = $count19;
      $arraySC20 [$key] = $count20;
      $arraySC21 [$key] = $count21;
      $count19 = 0;
      $count20 = 0;
      $count21 = 0;
    }

    $sumBall19 = array_sum($arrayball19);
    $sumBall20 = array_sum($arrayball20);
    $sumBall21 = array_sum($arrayball21);
    $sumHandal19 = array_sum($arrayHandal19);
    $sumHandal20 = array_sum($arrayHandal20);
    $sumHandal21 = array_sum($arrayHandal21);
    $sumMariscal19 = array_sum($arrayMariscal19);
    $sumMariscal20 = array_sum($arrayMariscal20);
    $sumMariscal21 = array_sum($arrayMariscal21);
    $sumCalacoto19 = array_sum($arrayCalacoto19);
    $sumCalacoto20 = array_sum($arrayCalacoto20);
    $sumCalacoto21 = array_sum($arrayCalacoto21);
    $sumInstitucional19 = array_sum($arrayInstitucional19);
    $sumInstitucional20 = array_sum($arrayInstitucional20);
    $sumInstitucional21 = array_sum($arrayInstitucional21);
    $sumMayoristas19 = array_sum($arrayMayoristas19);
    $sumMayoristas20 = array_sum($arrayMayoristas20);
    $sumMayoristas21 = array_sum($arrayMayoristas21);
    $sumSC19 = array_sum($arraySC19);
    $sumSC20 = array_sum($arraySC20);
    $sumSC21 = array_sum($arraySC21);

    $sumGeneral19 = $sumBall19 + $sumHandal19 + $sumMariscal19 + $sumCalacoto19 + $sumInstitucional19 + $sumMayoristas19 + $sumSC19;
    $sumGeneral20 = $sumBall20 + $sumHandal20 + $sumMariscal20 + $sumCalacoto20 + $sumInstitucional20 + $sumMayoristas20 + $sumSC20;
    $sumGeneral21 = $sumBall21 + $sumHandal21 + $sumMariscal21 + $sumCalacoto21 + $sumInstitucional21 + $sumMayoristas21 + $sumSC21;

    // dd($total_seg[4]);

    if ($request->gen == "export") {
      $export = new ResumenVentasExport();
      return Excel::download($export, 'Reporte de Stock Actual.xlsx');
    } else {
      //return dd($titulos);
      return view('reports.vista.resumenxmes', compact('total_general', 'total', 'total_seg', 'total_retail', 'options', 'total_regional', 'total_seg_regional', 'arrayball19', 'arrayball20', 'arrayball21' ,'arrayHandal19', 'arrayHandal20', 'arrayHandal21', 'arrayMariscal19', 'arrayMariscal20', 'arrayMariscal21', 'arrayCalacoto19', 'arrayCalacoto20', 'arrayCalacoto21', 'arrayInstitucional19', 'arrayInstitucional20', 'arrayInstitucional21', 'arrayMayoristas19', 'arrayMayoristas20', 'arrayMayoristas21', 'arraySC19', 'arraySC20', 'arraySC21', 'total_retail_calacoto', 'sumBall19', 'sumBall20', 'sumBall21', 'sumHandal19', 'sumHandal20', 'sumHandal21', 'sumMariscal19', 'sumMariscal20', 'sumMariscal21', 'sumCalacoto19','sumCalacoto20', 'sumCalacoto21', 'sumInstitucional19', 'sumInstitucional20', 'sumInstitucional21', 'sumMayoristas19', 'sumMayoristas20', 'sumMayoristas21', 'sumSC19', 'sumSC20', 'sumSC21', 'sumGeneral19', 'sumGeneral20', 'sumGeneral21'));
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
