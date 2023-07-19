<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParetoXMesExport;

use function Complex\add;

class ParetoXMesController extends Controller
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
    if (Auth::user()->tienePermiso(42, 1)) {
      return view('reports.paretoxmes');
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
    $option_tamaño = sizeof($request->options);
    $categ = "WHERE maconNomb = '" . $request->categoria . "'";
    $usr = [42, 50, 26, 52, 32, 43, 51, 44, 38, 49, 22, 41, 67, 76, 77, 78, 61, 68, 9, 65, 69, 80, 16, 17, 28, 29, 57, 37, 46, 74, 62, 3, 4, 18, 19, 55, 21, 20, 39, 40, 58, 56, 63, 64];
    // dd(implode(",",$usr));
    $mes_num = $request->options;
    $titulo_mes_venta = [];
    $sql_mes_select = "";
    $sql_mes_select_pareto = "";
    $sql_mes = "";
    // dd(implode(",",$mes_num));
    foreach ($mes_num as $key => $value) {
      // dd($value);
      $titulo_mes_venta[] = ['name' => 'retCan2021' . $key . '', 'data' => 'retCan2021' . $key . '', 'title' => 'Cant', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'retImp2021' . $key . '', 'data' => 'retImp2021' . $key . '', 'title' => 'Total', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'retCan2022' . $key . '', 'data' => 'retCan2022' . $key . '', 'title' => 'Cant', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'retImp2022' . $key . '', 'data' => 'retImp2022' . $key . '', 'title' => 'Total', 'className' => 'color_mes_' . $value . ' dt-right'];

      $titulo_mes_venta[] = ['name' => 'insCan2021' . $key . '', 'data' => 'insCan2021' . $key . '', 'title' => 'Cant', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'insImp2021' . $key . '', 'data' => 'insImp2021' . $key . '', 'title' => 'Total', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'insCan2022' . $key . '', 'data' => 'insCan2022' . $key . '', 'title' => 'Cant', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'insImp2022' . $key . '', 'data' => 'insImp2022' . $key . '', 'title' => 'Total', 'className' => 'color_mes_' . $value . ' dt-right'];

      $titulo_mes_venta[] = ['name' => 'mayCan2021' . $key . '', 'data' => 'mayCan2021' . $key . '', 'title' => 'Cant', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'mayImp2021' . $key . '', 'data' => 'mayImp2021' . $key . '', 'title' => 'Total', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'mayCan2022' . $key . '', 'data' => 'mayCan2022' . $key . '', 'title' => 'Cant', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'mayImp2022' . $key . '', 'data' => 'mayImp2022' . $key . '', 'title' => 'Total', 'className' => 'color_mes_' . $value . ' dt-right'];

      if (Auth::user()->tienePermiso(42, 10)) {
        $titulo_mes_venta[] = ['name' => 'PCant2021' . $key . '', 'data' => 'PCant2021' . $key . '', 'title' => 'Cantidad', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'PTotal2021' . $key . '', 'data' => 'PTotal2021' . $key . '', 'title' => 'Total', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'PTotalNeto2021' . $key . '', 'data' => 'PTotalNeto2021' . $key . '', 'title' => 'TotalNeto', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'costoTotal2021' . $key . '', 'data' => 'costoTotal2021' . $key . '', 'title' => 'CostoTotal', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'MU2021' . $key . '', 'data' => 'MU2021' . $key . '', 'title' => 'MU', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'PorcMU2021' . $key . '', 'data' => 'PorcMU2021' . $key . '', 'title' => '%MU', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'ParTotal2021' . $key . '', 'data' => 'ParTotal2021' . $key . '', 'title' => 'Pareto', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'ParetoAcum2021' . $key . '', 'data' => 'ParetoAcum2021' . $key . '', 'title' => 'ParetoAcum', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'clas2021' . $key . '', 'data' => 'clas2021' . $key . '', 'title' => 'Clase', 'className' => 'dt-right'];
  
        $titulo_mes_venta[] = ['name' => 'PCant2022' . $key . '', 'data' => 'PCant2022' . $key . '', 'title' => 'Cantidad', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'PTotal2022' . $key . '', 'data' => 'PTotal2022' . $key . '', 'title' => 'Total', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'PTotalNeto2022' . $key . '', 'data' => 'PTotalNeto2022' . $key . '', 'title' => 'TotalNeto', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'costoTotal2022' . $key . '', 'data' => 'costoTotal2022' . $key . '', 'title' => 'CostoTotal', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'MU2022' . $key . '', 'data' => 'MU2022' . $key . '', 'title' => 'MU', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'PorcMU2022' . $key . '', 'data' => 'PorcMU2022' . $key . '', 'title' => '%MU', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'ParTotal2022' . $key . '', 'data' => 'ParTotal2022' . $key . '', 'title' => 'Pareto', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'ParetoAcum2022' . $key . '', 'data' => 'ParetoAcum2022' . $key . '', 'title' => 'ParetoAcum', 'className' => 'dt-right'];
        $titulo_mes_venta[] = ['name' => 'clas2022' . $key . '', 'data' => 'clas2022' . $key . '', 'title' => 'Clase', 'className' => 'dt-right'];
      }

      $sql_mes_select = $sql_mes_select . "
      ISNULL(retCan2021" . $key . ",0) AS retCan2021" . $key . ",
      CONVERT(varchar, CAST(ISNULL(retImp2021" . $key . ",0) AS MONEY),1) AS retImp2021" . $key . ",
      ISNULL(retCan2022" . $key . ",0) AS retCan2022" . $key . ",
      CONVERT(varchar, CAST(ISNULL(retImp2022" . $key . ",0) AS MONEY),1) AS retImp2022" . $key . ",
      ISNULL(insCan2021" . $key . ",0) AS insCan2021" . $key . ",
      CONVERT(varchar, CAST(ISNULL(insImp2021" . $key . ",0) AS MONEY),1) AS insImp2021" . $key . ",
      ISNULL(insCan2022" . $key . ",0) AS insCan2022" . $key . ",
      CONVERT(varchar, CAST(ISNULL(insImp2022" . $key . ",0) AS MONEY),1) AS insImp2022" . $key . ",
      ISNULL(mayCan2021" . $key . ",0) AS mayCan2021" . $key . ",
      CONVERT(varchar, CAST(ISNULL(mayImp2021" . $key . ",0) AS MONEY),1) AS mayImp2021" . $key . ",
      ISNULL(mayCan2022" . $key . ",0) AS mayCan2022" . $key . ",
      CONVERT(varchar, CAST(ISNULL(mayImp2022" . $key . ",0) AS MONEY),1) AS mayImp2022" . $key . ",
      ------------- PARETO 2021 -------------
        ISNULL(ventas_imp_2021" . $key . ".venta_cant_total_2021,0) AS PCant2021" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2021" . $key . ".venta_total_2021,0),0) AS MONEY),1) AS PTotal2021" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2021" . $key . ".venta_total_2021,0) * 0.87,0) AS MONEY),1) AS PTotalNeto2021" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ventas_imp_2021" . $key . ".venta_total_costo_2021,0) AS MONEY),1) AS costoTotal2021" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2021" . $key . ".venta_total_2021*0.87,0) - ISNULL(ventas_imp_2021" . $key . ".venta_total_costo_2021,0),0) AS MONEY),1) AS MU2021" . $key . ",
        CONVERT(varchar, CAST(
        CASE 
        WHEN ISNULL(ventas_imp_2021" . $key . ".venta_total_2021*0.87,0) = 0 THEN 0
        ELSE ISNULL((ISNULL(ventas_imp_2021" . $key . ".venta_total_2021*0.87,0) - ISNULL(ventas_imp_2021" . $key . ".venta_total_costo_2021,0))/ISNULL(ventas_imp_2021" . $key . ".venta_total_2021*0.87,0) * 100,0)
        END  AS MONEY),1) AS PorcMU2021" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2021" . $key . ".venta_total_2021*0.87,0)/(SELECT SUM(vtvtdImpT - vtvtdDesT) FROM vtVta JOIN vtVtd ON vtvtdNtra = vtvtaNtra WHERE vtvtaMdel = 0 AND YEAR(vtvtaFtra) = 2021
            AND MONTH(vtvtaFtra) = " . $value . " AND vtvtaCusr IN (" . implode(",", $usr) . ")) * 100,0) AS MONEY),1) AS ParTotal2021" . $key . ",
        CONVERT(varchar, CAST(ISNULL(pareto_acum_2021" . $key . ".paretoAcum_2021,0) AS MONEY),1) AS ParetoAcum2021" . $key . ",
        CASE 
            WHEN pareto_acum_2021" . $key . ".paretoAcum_2021 <=80 THEN 'A' 
            WHEN pareto_acum_2021" . $key . ".paretoAcum_2021 > 80 AND pareto_acum_2021" . $key . ".paretoAcum_2021 <=95 THEN 'B' 
            WHEN pareto_acum_2021" . $key . ".paretoAcum_2021 > 95 THEN 'C' 
        END as clas2021" . $key . ",
        ------------- END PARETO 2021 -------------
        ------------- PARETO 2022 -------------
        ISNULL(ventas_imp_2022" . $key . ".venta_cant_total_2022,0) AS PCant2022" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2022" . $key . ".venta_total_2022,0),0) AS MONEY),1) AS PTotal2022" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2022" . $key . ".venta_total_2022,0) * 0.87,0) AS MONEY),1) AS PTotalNeto2022" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ventas_imp_2022" . $key . ".venta_total_costo_2022,0) AS MONEY),1) AS costoTotal2022" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2022" . $key . ".venta_total_2022*0.87,0) - ISNULL(ventas_imp_2022" . $key . ".venta_total_costo_2022,0),0) AS MONEY),1) AS MU2022" . $key . ",
        CONVERT(varchar, CAST(
        CASE 
        WHEN ISNULL(ventas_imp_2022" . $key . ".venta_total_2022*0.87,0) = 0 THEN 0
        ELSE ISNULL((ISNULL(ventas_imp_2022" . $key . ".venta_total_2022*0.87,0) - ISNULL(ventas_imp_2022" . $key . ".venta_total_costo_2022,0))/ISNULL(ventas_imp_2022" . $key . ".venta_total_2022*0.87,0) * 100,0)
        END  AS MONEY),1) AS PorcMU2022" . $key . ",
        CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp_2022" . $key . ".venta_total_2022*0.87,0)/(SELECT SUM(vtvtdImpT - vtvtdDesT) FROM vtVta JOIN vtVtd ON vtvtdNtra = vtvtaNtra WHERE vtvtaMdel = 0 AND YEAR(vtvtaFtra) = 2022
            AND MONTH(vtvtaFtra) = " . $value . " AND vtvtaCusr IN (" . implode(",", $usr) . ")) * 100,0) AS MONEY),1) AS ParTotal2022" . $key . ",
        CONVERT(varchar, CAST(ISNULL(pareto_acum_2022" . $key . ".paretoAcum_2022,0) AS MONEY),1) AS ParetoAcum2022" . $key . ",
        CASE 
            WHEN pareto_acum_2022" . $key . ".paretoAcum_2022 <=80 THEN 'A' 
            WHEN pareto_acum_2022" . $key . ".paretoAcum_2022 > 80 AND pareto_acum_2022" . $key . ".paretoAcum_2022 <=95 THEN 'B' 
            WHEN pareto_acum_2022" . $key . ".paretoAcum_2022 > 95 THEN 'C' 
        END as clas2022" . $key . ",
      ";
      $sql_mes = $sql_mes . "
      ------------- VENTA TOTAL 2021 -------------
      LEFT JOIN (
        SELECT
        vtvtdCpro, SUM(vtvtdImpT - vtvtdDesT) AS venta_total_2021, SUM(vtvtdCosT) AS venta_total_costo_2021, SUM(vtvtdCant) AS venta_cant_total_2021
        FROM vtVta
        JOIN vtVtd ON vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND YEAR(vtvtaFtra) = 2021
        AND MONTH(vtvtaFtra) = " . $value . "
        AND vtvtaCusr IN (" . implode(",", $usr) . ")
        GROUP BY vtvtdCpro
      ) AS ventas_imp_2021" . $key . " ON ventas_imp_2021" . $key . ".vtvtdCpro = inpro.inproCpro
      ------------- FIN VENTA TOTAL 2021 -------------
      ------------- VENTA TOTAL 2022 -------------
      LEFT JOIN (
        SELECT
        vtvtdCpro, SUM(vtvtdImpT - vtvtdDesT) AS venta_total_2022, SUM(vtvtdCosT) AS venta_total_costo_2022, SUM(vtvtdCant) AS venta_cant_total_2022
        FROM vtVta
        JOIN vtVtd ON vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND YEAR(vtvtaFtra) = 2022
        AND MONTH(vtvtaFtra) = " . $value . "
        AND vtvtaCusr IN (" . implode(",", $usr) . ")
        GROUP BY vtvtdCpro
      ) AS ventas_imp_2022" . $key . " ON ventas_imp_2022" . $key . ".vtvtdCpro = inpro.inproCpro
      ------------- FIN VENTA TOTAL 2022 -------------
      ------------- PARETO TOTAL 2021 -------------
      LEFT JOIN 
        (
          SELECT vtvtdCpro, SUM(SUM(vtvtdImpT - vtvtdDesT)) OVER (ORDER BY SUM(vtvtdImpT - vtvtdDesT) DESC)/(
            SELECT SUM(vtvtdImpT - vtvtdDesT)
            FROM vtVta
            JOIN vtVtd ON vtvtdNtra = vtvtaNtra
            WHERE vtvtaMdel = 0
            AND YEAR(vtvtaFtra) = 2021
            AND MONTH(vtvtaFtra) = " . $value . "
            AND vtvtaCusr IN (" . implode(",", $usr) . ")
          )*100 AS paretoAcum_2021 FROM vtVta JOIN vtVtd ON vtvtdNtra = vtvtaNtra WHERE vtvtaMdel = 0
          AND YEAR(vtvtaFtra) = 2021
          AND MONTH(vtvtaFtra) = " . $value . "
          GROUP BY vtvtdCpro
        ) AS pareto_acum_2021" . $key . " ON pareto_acum_2021" . $key . ".vtvtdCpro = inpro.inproCpro
      ------------- FIN PARETO TOTAL 2021 -------------
      ------------- PARETO TOTAL 2022 -------------
      LEFT JOIN 
      (
        SELECT vtvtdCpro, SUM(SUM(vtvtdImpT - vtvtdDesT)) OVER (ORDER BY SUM(vtvtdImpT - vtvtdDesT) DESC)/(
          SELECT SUM(vtvtdImpT - vtvtdDesT)
          FROM vtVta
          JOIN vtVtd ON vtvtdNtra = vtvtaNtra
          WHERE vtvtaMdel = 0
          AND YEAR(vtvtaFtra) = 2022
          AND MONTH(vtvtaFtra) = " . $value . "
          AND vtvtaCusr IN (" . implode(",", $usr) . ")
        )*100 AS paretoAcum_2022 FROM vtVta JOIN vtVtd ON vtvtdNtra = vtvtaNtra WHERE vtvtaMdel = 0
        AND YEAR(vtvtaFtra) = 2022
        AND MONTH(vtvtaFtra) = " . $value . "
        GROUP BY vtvtdCpro
      ) AS pareto_acum_2022" . $key . " ON pareto_acum_2022" . $key . ".vtvtdCpro = inpro.inproCpro
      ------------- FIN PARETO TOTAL 2022 -------------
      LEFT JOIN (
        SELECT
          vtvtdCpro,
          ISNULL([42],0)+ISNULL([50],0)+ISNULL([26],0)+ISNULL([52],0)+ISNULL([32],0)+ISNULL([43],0)+ISNULL([51],0)+ISNULL([44],0)+ISNULL([38],0)+ISNULL([49],0)+ISNULL([22],0)+ISNULL([41],0)+ISNULL([67],0)+ISNULL([76],0)+ISNULL([77],0)+ISNULL([78],0)+ISNULL([61],0)+ISNULL([68],0)+ISNULL([9],0)+ISNULL([65],0)+ISNULL([69],0)+ISNULL([80],0) AS retCan2021" . $key . ",
          ISNULL([16],0)+ISNULL([17],0)+ISNULL([28],0)+ISNULL([29],0)+ISNULL([57],0)+ISNULL([37],0)+ISNULL([46],0)+ISNULL([74],0)+ISNULL([62],0)+ISNULL([3],0)+ISNULL([4],0) AS insCan2021" . $key . ",
          ISNULL([18],0)+ISNULL([19],0)+ISNULL([55],0)+ISNULL([21],0)+ISNULL([20],0)+ISNULL([39],0)+ISNULL([40],0)+ISNULL([58],0)+ISNULL([56],0) + ISNULL([63],0)+ISNULL([64],0) AS mayCan2021" . $key . "
              FROM (
                SELECT 
                vtvtaCusr, vtvtdCpro, SUM(vtvtdCant) AS cantidad_2021
                FROM vtVta
                JOIN vtVtd ON vtvtaNtra = vtvtdNtra
                WHERE vtvtdMdel = 0
                AND YEAR(vtvtaFtra) = 2021
                AND MONTH(vtvtaFtra) = " . $value . "
                GROUP BY vtvtaCusr, vtvtdCpro
              ) AS venta_cant_2021
              PIVOT 
              (
              SUM(cantidad_2021)
              FOR vtvtaCusr IN ([42],[50],[26],[52],[32],[43],[51],[44],[38],[49],[22],[41],[67],[76],[77],[78],[61],[68],[9],[65],[69],[80], [16],[17],[28],[29],[57],[37],[46],[74],[62],[3],[4], [18],[19],[55],[21],[20],[39],[40],[58],[56],[63],[64])
              ) AS venta_cant_pivot_2021
      ) AS ventaCant2021" . $key . " ON ventaCant2021" . $key . ".vtvtdCpro = inpro.inproCpro
      LEFT JOIN (
        SELECT
          vtvtdCpro,
          ISNULL([42],0)+ISNULL([50],0)+ISNULL([26],0)+ISNULL([52],0)+ISNULL([32],0)+ISNULL([43],0)+ISNULL([51],0)+ISNULL([44],0)+ISNULL([38],0)+ISNULL([49],0)+ISNULL([22],0)+ISNULL([41],0)+ISNULL([67],0)+ISNULL([76],0)+ISNULL([77],0)+ISNULL([78],0)+ISNULL([61],0)+ISNULL([68],0)+ISNULL([9],0)+ISNULL([65],0)+ISNULL([69],0)+ISNULL([80],0) AS retImp2021" . $key . ",
          ISNULL([16],0)+ISNULL([17],0)+ISNULL([28],0)+ISNULL([29],0)+ISNULL([57],0)+ISNULL([37],0)+ISNULL([46],0)+ISNULL([74],0)+ISNULL([62],0)+ISNULL([3],0)+ISNULL([4],0) AS insImp2021" . $key . ",
          ISNULL([18],0)+ISNULL([19],0)+ISNULL([55],0)+ISNULL([21],0)+ISNULL([20],0)+ISNULL([39],0)+ISNULL([40],0)+ISNULL([58],0)+ISNULL([56],0) + ISNULL([63],0)+ISNULL([64],0) AS mayImp2021" . $key . "
              FROM (
                SELECT 
                vtvtaCusr, vtvtdCpro, SUM(vtvtdImpT - vtvtdDesT) AS impTotal_2021
                FROM vtVta
                JOIN vtVtd ON vtvtaNtra = vtvtdNtra
                WHERE vtvtdMdel = 0
                AND YEAR(vtvtaFtra) = 2021
                AND MONTH(vtvtaFtra) = " . $value . "
                GROUP BY vtvtaCusr, vtvtdCpro
              ) AS venta_imp_2021
              PIVOT 
              (
              SUM(impTotal_2021)
              FOR vtvtaCusr IN ([42],[50],[26],[52],[32],[43],[51],[44],[38],[49],[22],[41],[67],[76],[77],[78],[61],[68],[9],[65],[69],[80], [16],[17],[28],[29],[57],[37],[46],[74],[62],[3],[4], [18],[19],[55],[21],[20],[39],[40],[58],[56],[63],[64])
              ) AS venta_imp_pivot_2021
      ) AS ventaImp2021" . $key . " ON ventaImp2021" . $key . ".vtvtdCpro = inpro.inproCpro
      ------------- 2022 -------------
      LEFT JOIN (
        SELECT
          vtvtdCpro,
          ISNULL([42],0)+ISNULL([50],0)+ISNULL([26],0)+ISNULL([52],0)+ISNULL([32],0)+ISNULL([43],0)+ISNULL([51],0)+ISNULL([44],0)+ISNULL([38],0)+ISNULL([49],0)+ISNULL([22],0)+ISNULL([41],0)+ISNULL([67],0)+ISNULL([76],0)+ISNULL([77],0)+ISNULL([78],0)+ISNULL([61],0)+ISNULL([68],0)+ISNULL([9],0)+ISNULL([65],0)+ISNULL([69],0)+ISNULL([80],0) AS retCan2022" . $key . ",
          ISNULL([16],0)+ISNULL([17],0)+ISNULL([28],0)+ISNULL([29],0)+ISNULL([57],0)+ISNULL([37],0)+ISNULL([46],0)+ISNULL([74],0)+ISNULL([62],0)+ISNULL([3],0)+ISNULL([4],0) AS insCan2022" . $key . ",
          ISNULL([18],0)+ISNULL([19],0)+ISNULL([55],0)+ISNULL([21],0)+ISNULL([20],0)+ISNULL([39],0)+ISNULL([40],0)+ISNULL([58],0)+ISNULL([56],0) + ISNULL([63],0)+ISNULL([64],0) AS mayCan2022" . $key . "
              FROM (
                SELECT 
                vtvtaCusr, vtvtdCpro, SUM(vtvtdCant) AS cantidad_2022
                FROM vtVta
                JOIN vtVtd ON vtvtaNtra = vtvtdNtra
                WHERE vtvtdMdel = 0
                AND YEAR(vtvtaFtra) = 2022
                AND MONTH(vtvtaFtra) = " . $value . "
                GROUP BY vtvtaCusr, vtvtdCpro
              ) AS venta_cant_2022
              PIVOT 
              (
              SUM(cantidad_2022)
              FOR vtvtaCusr IN ([42],[50],[26],[52],[32],[43],[51],[44],[38],[49],[22],[41],[67],[76],[77],[78],[61],[68],[9],[65],[69],[80], [16],[17],[28],[29],[57],[37],[46],[74],[62],[3],[4], [18],[19],[55],[21],[20],[39],[40],[58],[56],[63],[64])
              ) AS venta_cant_pivot_2022
      ) AS ventaCant2022" . $key . " ON ventaCant2022" . $key . ".vtvtdCpro = inpro.inproCpro
      LEFT JOIN (
        SELECT
          vtvtdCpro,
          ISNULL([42],0)+ISNULL([50],0)+ISNULL([26],0)+ISNULL([52],0)+ISNULL([32],0)+ISNULL([43],0)+ISNULL([51],0)+ISNULL([44],0)+ISNULL([38],0)+ISNULL([49],0)+ISNULL([22],0)+ISNULL([41],0)+ISNULL([67],0)+ISNULL([76],0)+ISNULL([77],0)+ISNULL([78],0)+ISNULL([61],0)+ISNULL([68],0)+ISNULL([9],0)+ISNULL([65],0)+ISNULL([69],0)+ISNULL([80],0) AS retImp2022" . $key . ",
          ISNULL([16],0)+ISNULL([17],0)+ISNULL([28],0)+ISNULL([29],0)+ISNULL([57],0)+ISNULL([37],0)+ISNULL([46],0)+ISNULL([74],0)+ISNULL([62],0)+ISNULL([3],0)+ISNULL([4],0) AS insImp2022" . $key . ",
          ISNULL([18],0)+ISNULL([19],0)+ISNULL([55],0)+ISNULL([21],0)+ISNULL([20],0)+ISNULL([39],0)+ISNULL([40],0)+ISNULL([58],0)+ISNULL([56],0) + ISNULL([63],0)+ISNULL([64],0) AS mayImp2022" . $key . "
              FROM (
                SELECT 
                vtvtaCusr, vtvtdCpro, SUM(vtvtdImpT - vtvtdDesT) AS impTotal_2022
                FROM vtVta
                JOIN vtVtd ON vtvtaNtra = vtvtdNtra
                WHERE vtvtdMdel = 0
                AND YEAR(vtvtaFtra) = 2022
                AND MONTH(vtvtaFtra) = " . $value . "
                GROUP BY vtvtaCusr, vtvtdCpro
              ) AS venta_imp_2022
              PIVOT 
              (
              SUM(impTotal_2022)
              FOR vtvtaCusr IN ([42],[50],[26],[52],[32],[43],[51],[44],[38],[49],[22],[41],[67],[76],[77],[78],[61],[68],[9],[65],[69],[80], [16],[17],[28],[29],[57],[37],[46],[74],[62],[3],[4], [18],[19],[55],[21],[20],[39],[40],[58],[56],[63],[64])
              ) AS venta_imp_pivot_2022
      ) AS ventaImp2022" . $key . " ON ventaImp2022" . $key . ".vtvtdCpro = inpro.inproCpro
      ";
    }
    // dd($titulo_mes_venta, $sql_mes_select, $sql_mes);
    $query = "
      SELECT
      inproCpro AS codigo,
      inproNomb AS descripcion,
      inumeAbre AS umpro,
      maconNomb AS categoria,
      " . $sql_mes_select . "
      maconCmod
      FROM (
        SELECT *
        FROM inpro
        LEFT JOIN macon ON inproMarc = CAST(MaconCcon as varchar)+ '|' + CAST(MaconItem as varchar)
        LEFT JOIN inume ON inumeCume = inproCumb
        JOIN (
          SELECT vtvtdCpro,SUM(vtvtdImpT) AS total
          FROM vtVtd
          JOIN vtVta ON vtvtaNtra = vtvtdNtra
          WHERE vtvtaMdel = 0
          AND YEAR(vtvtaFtra) IN (2021,2022)
          AND MONTH(vtvtaFtra) IN (" . implode(",", $mes_num) . ")
          AND vtvtaCusr IN (" . implode(",", $usr) . ")
          GROUP BY vtvtdCpro
        ) AS venta ON venta.vtvtdCpro = inproCpro
        " . $categ . "
      ) AS inpro
      " . $sql_mes . "
      --ORDER BY pareto_acum_2022.paretoAcum_2022 ASC
      ";
    // dd($query);
    $test = DB::connection('sqlsrv')->select(DB::raw($query));
    $titulos =
      [
        ['name' => 'categoria', 'data' => 'categoria', 'title' => 'Categoria', 'tip' => 'filtro'],
        ['name' => 'codigo', 'data' => 'codigo', 'title' => 'Codigo', 'tip' => 'filtro'],
        ['name' => 'descripcion', 'data' => 'descripcion', 'title' => 'Descripcion', 'tip' => 'filtro'],
        ['name' => 'umpro', 'data' => 'umpro', 'title' => 'U.M.', 'tip' => 'filtro_select'],
      ];
    foreach ($titulo_mes_venta as $key => $value) {
      $titulos[] = $value;
    }
    $titulos_excel =
      [
        'Categoria',
        'Codigo',
        'Descripcion',
        'U.M,',
      ];
    foreach ($mes_num as $key => $value) {
      $titulos_excel[] = 'Cant';
      $titulos_excel[] = 'Total';
      $titulos_excel[] = 'Cant';
      $titulos_excel[] = 'Total';
      $titulos_excel[] = 'Cant';
      $titulos_excel[] = 'Total';
      $titulos_excel[] = 'Cant';
      $titulos_excel[] = 'Total';
      $titulos_excel[] = 'Cant';
      $titulos_excel[] = 'Total';
      $titulos_excel[] = 'Cant';
      $titulos_excel[] = 'Total';
      if (Auth::user()->tienePermiso(42, 10)) {
        $titulos_excel[] = 'Cantidad';
        $titulos_excel[] = 'Total';
        $titulos_excel[] = 'TotalNeto';
        $titulos_excel[] = 'CostoTotal';
        $titulos_excel[] = 'MU';
        $titulos_excel[] = '%MU';
        $titulos_excel[] = 'Pareto';
        $titulos_excel[] = '%Pareto';
        $titulos_excel[] = 'Clase';
        $titulos_excel[] = 'Cantidad';
        $titulos_excel[] = 'Total';
        $titulos_excel[] = 'TotalNeto';
        $titulos_excel[] = 'CostoTotal';
        $titulos_excel[] = 'MU';
        $titulos_excel[] = '%MU';
        $titulos_excel[] = 'Pareto';
        $titulos_excel[] = '%Pareto';
        $titulos_excel[] = 'Clase';
      }
    }

    $titulos_excel_2 =
      [
        '',
        '',
        '',
        '',
      ];
    foreach ($mes_num as $key => $value) {
      if ($value == 1) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 2) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 3) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 4) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 5) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 6) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 7) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 8) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 9) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 10) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 11) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
      if ($value == 12) {
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2021';
        $titulos_excel_2[] = '';
        $titulos_excel_2[] = '2022';
        $titulos_excel_2[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_2[] = '2021';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '2022';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
          $titulos_excel_2[] = '';
        }
      }
    }

    $titulos_excel_1 =
      [
        '',
        '',
        '',
        '',
      ];

    foreach ($mes_num as $key => $value) {
      if ($value == 1) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 2) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 3) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 4) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 5) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 6) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 7) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 8) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 9) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 10) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 11) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
      if ($value == 12) {
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'RETAIL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'INSTITUCIONAL';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        $titulos_excel_1[] = 'MAYORISTA';
        $titulos_excel_1[] = '';
        if (Auth::user()->tienePermiso(42, 10)){
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = 'PARETO';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
          $titulos_excel_1[] = '';
        }
      }
    }

    $titulos_excel_mes =
      [
        '',
        '',
        '',
        '',
      ];
    foreach ($mes_num as $key => $value) {
      if ($value == 1) {
        $titulos_excel_mes[] = 'ENERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ENERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ENERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ENERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ENERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ENERO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'ENERO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'ENERO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 2) {
        $titulos_excel_mes[] = 'FEBRERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'FEBRERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'FEBRERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'FEBRERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'FEBRERO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'FEBRERO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'FEBRERO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'FEBRERO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 3) {
        $titulos_excel_mes[] = 'MARZO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MARZO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MARZO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MARZO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MARZO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MARZO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'MARZO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'MARZO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 4) {
        $titulos_excel_mes[] = 'ABRIL';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ABRIL';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ABRIL';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ABRIL';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ABRIL';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'ABRIL';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'ABRIL';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'ABRIL';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 5) {
        $titulos_excel_mes[] = 'MAYO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MAYO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MAYO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MAYO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MAYO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'MAYO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'MAYO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'MAYO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 6) {
        $titulos_excel_mes[] = 'JUNIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JUNIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JUNIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JUNIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JUNIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JUNIO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'JUNIO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'JUNIO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 7) {
        $titulos_excel_mes[] = 'JULIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JULIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JULIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JULIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JULIO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'JULIO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'JULIO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'JULIO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 8) {
        $titulos_excel_mes[] = 'AGOSTO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'AGOSTO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'AGOSTO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'AGOSTO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'AGOSTO';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'AGOSTO';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'AGOSTO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'AGOSTO';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 9) {
        $titulos_excel_mes[] = 'SEPTIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'SEPTIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'SEPTIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'SEPTIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'SEPTIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'SEPTIEMBRE';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'SEPTIEMBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'SEPTIEMBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 10) {
        $titulos_excel_mes[] = 'OCTUBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'OCTUBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'OCTUBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'OCTUBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'OCTUBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'OCTUBRE';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'OCTUBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'OCTUBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 11) {
        $titulos_excel_mes[] = 'NOVIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'NOVIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'NOVIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'NOVIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'NOVIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'NOVIEMBRE';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'NOVIEMBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'NOVIEMBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
      if ($value == 12) {
        $titulos_excel_mes[] = 'DICIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'DICIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'DICIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'DICIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'DICIEMBRE';
        $titulos_excel_mes[] = '';
        $titulos_excel_mes[] = 'DICIEMBRE';
        $titulos_excel_mes[] = '';
        if (Auth::user()->tienePermiso(42, 10)) {
          $titulos_excel_mes[] = 'DICIEMBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = 'DICIEMBRE';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
          $titulos_excel_mes[] = '';
        }
      }
    }

    if ($request->gen == "excel") {
      if (!Auth::user()->tienePermiso(42, 10)) {
        foreach ($mes_num as $key => $value) {
          foreach ($test as $i => $j) {
            $var = "PCant2021"."$key";
            unset($j->$var);
            $var = "PTotal2021"."$key";
            unset($j->$var);
            $var = "PTotalNeto2021"."$key";
            unset($j->$var);
            $var = "costoTotal2021"."$key";
            unset($j->$var);
            $var = "MU2021"."$key";
            unset($j->$var);
            $var = "PorcMU2021"."$key";
            unset($j->$var);
            $var = "ParTotal2021"."$key";
            unset($j->$var);
            $var = "ParetoAcum2021"."$key";
            unset($j->$var);
            $var = "clas2021"."$key";
            unset($j->$var);
            $var = "PCant2022"."$key";
            unset($j->$var);
            $var = "PTotal2022"."$key";
            unset($j->$var);
            $var = "PTotalNeto2022"."$key";
            unset($j->$var);
            $var = "costoTotal2022"."$key";
            unset($j->$var);
            $var = "MU2022"."$key";
            unset($j->$var);
            $var = "PorcMU2022"."$key";
            unset($j->$var);
            $var = "ParTotal2022"."$key";
            unset($j->$var);
            $var = "ParetoAcum2022"."$key";
            unset($j->$var);
            $var = "clas2022"."$key";
            unset($j->$var);
          }
        }
      }
      $export = new ParetoXMesExport($test, $titulos_excel,  $titulos_excel_2, $titulos_excel_1, $titulos_excel_mes);
      return Excel::download($export, 'Pareto X Mes.xlsx');
    } else {
      return view('reports.vista.paretoxmes', compact('test', 'titulos', 'mes_num'));
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
