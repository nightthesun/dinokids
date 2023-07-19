<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SegmentoProductoExport;

use function Complex\add;

class SegmentoProductoController extends Controller
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
    if (Auth::user()->tienePermiso(41, 1)) {
      return view('reports.segmentoproducto');
    }
    // return redirect()->back();
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
    $fAnt = date("d/m/Y", strtotime(date($request->ffin) . "- 1 days"));
    $categ = "";
    if ($request->categoria) {
      $categ = "WHERE marc.maconNomb LIKE '%" . $request->categoria . "%'";
    }
    $usr = [42, 50, 26, 52, 32, 43, 51, 44, 38, 49, 22, 41, 67, 76, 77, 78, 61, 68, 9, 65, 69, 80, 16, 17, 28, 29, 57, 37, 46, 74, 62, 3, 4, 18, 19, 55, 21, 20, 39, 40, 58, 56, 63, 64];
    // dd(implode(",",$usr));
    $mes_num = $request->options;
    $titulo_mes_venta = [];
    $sql_mes_select = "";
    $sql_mes = "";
    // dd(implode(",",$mes_num));
    foreach ($mes_num as $key => $value) {
      // dd($key);
      $titulo_mes_venta[] = ['name' => 'compra' . $key . '', 'data' => 'compra' . $key . '', 'title' => 'TotalCompra', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'retail' . $key . '', 'data' => 'retail' . $key . '', 'title' => 'Retail', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'mayorista' . $key . '', 'data' => 'mayorista' . $key . '', 'title' => 'Mayorista', 'className' => 'color_mes_' . $value . ' dt-right'];
      $titulo_mes_venta[] = ['name' => 'institucional' . $key . '', 'data' => 'institucional' . $key . '', 'title' => 'Institucional', 'className' => 'color_mes_' . $value . ' dt-right'];

      $sql_mes_select = $sql_mes_select . "
      ISNULL(compra" . $key . ".iec,0) AS compra" . $key . ",
      ISNULL(ventas_cant" . $key . ".retail" . $key . ",0) AS retail" . $key . ",
      ISNULL(ventas_cant" . $key . ".mayorista" . $key . ",0) AS mayorista" . $key . ",
      ISNULL(ventas_cant" . $key . ".institucional" . $key . ",0) AS institucional" . $key . ",
      ";

      $sql_mes = $sql_mes . "
      LEFT JOIN 
      (
        SELECT intrdCpro, SUM(intrdCanb) AS iec
        FROM intra
        JOIN intrd ON intrdNtra = intraNtra
        WHERE intraMdel = 0 
        AND YEAR(intraFtra) = " . $request->gestion . "
        AND MONTH(intraFtra) = " . $value . "
        AND intraTmov = 107
        GROUP BY intrdCpro
      ) AS compra" . $key . " ON compra" . $key . ".intrdCpro = inpro.inproCpro
      LEFT JOIN 
      (
        SELECT
        vtvtdCpro,
        ISNULL([42],0)+ISNULL([50],0)+ISNULL([26],0)+ISNULL([52],0)+ISNULL([32],0)+ISNULL([43],0)+ISNULL([51],0)+ISNULL([44],0)+ISNULL([38],0)+ISNULL([49],0)+ISNULL([22],0)+ISNULL([41],0)+ISNULL([67],0)+ISNULL([76],0)+ISNULL([77],0)+ISNULL([78],0)+ISNULL([61],0)+ISNULL([68],0)+ISNULL([9],0)+ISNULL([65],0)+ISNULL([69],0)+ISNULL([80],0) AS retail" . $key . ",
        ISNULL([16],0)+ISNULL([17],0)+ISNULL([28],0)+ISNULL([29],0)+ISNULL([57],0)+ISNULL([37],0)+ISNULL([46],0)+ISNULL([74],0)+ISNULL([62],0)+ISNULL([3],0)+ISNULL([4],0) AS institucional" . $key . ",
        ISNULL([18],0)+ISNULL([19],0)+ISNULL([55],0)+ISNULL([21],0)+ISNULL([20],0)+ISNULL([39],0)+ISNULL([40],0)+ISNULL([58],0)+ISNULL([56],0) + ISNULL([63],0)+ISNULL([64],0) AS mayorista" . $key . "
        FROM (
          SELECT 
          vtvtaCusr, vtvtdCpro, SUM(vtvtdCant) AS cantidad
          FROM vtVta
          JOIN vtVtd ON vtvtaNtra = vtvtdNtra
          WHERE vtvtdMdel = 0
          AND YEAR(vtvtaFtra) = " . $request->gestion . "
          AND MONTH(vtvtaFtra) = " . $value . "
          GROUP BY vtvtaCusr, vtvtdCpro
        ) AS venta_cant
        PIVOT 
        (
        SUM(cantidad)
        FOR vtvtaCusr IN ([42],[50],[26],[52],[32],[43],[51],[44],[38],[49],[22],[41],[67],[76],[77],[78],[61],[68],[9],[65],[69],[80], [16],[17],[28],[29],[57],[37],[46],[74],[62],[3],[4], [18],[19],[55],[21],[20],[39],[40],[58],[56],[63],[64])
        ) AS venta_cant_pivot
      ) AS ventas_cant" . $key . " ON ventas_cant" . $key . ".vtvtdCpro = inpro.inproCpro
      ";
    }
    // dd($titulo_mes_venta, $sql_mes_select, $sql_mes);
    $query = "
      SELECt
      marc.maconNomb AS categoria,
      inpro.inproCpro AS codigo,
      inpro.inproNomb AS descripcion,
      umpro.inumeAbre AS umpro,
      ISNULL(stock_anterior.stock,0) AS stock_anterior,
      " . $sql_mes_select . "
      CONVERT(varchar, CAST(ISNULL(150 * (ISNULL(ventas_imp.venta_cant_total,0))/(".$option_tamaño."*30),0) AS MONEY),1) AS StockMin,
      CONVERT(varchar, CAST(ISNULL((150 * (ISNULL(ventas_imp.venta_cant_total,0))/(".$option_tamaño."*30))*2,0) AS MONEY),1) AS StockMax,
      (150 * (ISNULL(ventas_imp.venta_cant_total,0))/(".$option_tamaño."*30)) + ((180 - 150)*(ISNULL(ventas_imp.venta_cant_total,0))/(".$option_tamaño."*30)) AS StockCon,
      (150*(ISNULL(ventas_imp.venta_cant_total,0))/(".$option_tamaño."*30)) + ((180 - 150)*(ISNULL(ventas_imp.venta_cant_total,0))/(".$option_tamaño."*30)) AS PedidoSug,
      ISNULL(ventas_imp.venta_cant_total,0) AS PCant,
      CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp.venta_total,0),0) AS MONEY),1) AS PTotal,
      CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp.venta_total,0) * 0.87,0) AS MONEY),1) AS PTotalNeto,
      CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp.venta_total,0) - ISNULL(ventas_imp.venta_total_costo,0),0) AS MONEY),1) AS MU,
      CONVERT(varchar, CAST(
      CASE 
        WHEN ISNULL(ventas_imp.venta_total,0) = 0 THEN 0
        ELSE ISNULL((ISNULL(ventas_imp.venta_total,0) - ISNULL(ventas_imp.venta_total_costo,0))/ISNULL(ventas_imp.venta_total,0) * 100,0)
      END  AS MONEY),1) AS PorcMU,
      CONVERT(varchar, CAST(ISNULL(ISNULL(ventas_imp.venta_total,0)/(SELECT SUM(vtvtdImpT - vtvtdDesT) FROM vtVta JOIN vtVtd ON vtvtdNtra = vtvtaNtra WHERE vtvtaMdel = 0 AND YEAR(vtvtaFtra) = " . $request->gestion . "
          AND MONTH(vtvtaFtra) IN (" . implode(",", $mes_num) . ") AND vtvtaCusr IN (" . implode(",", $usr) . ")) * 100,0) AS MONEY),1) AS ParTotal,
      CONVERT(varchar, CAST(ISNULL(pareto_acum.paretoAcum,0) AS MONEY),1) AS ParetoAcum,
      CASE 
          WHEN pareto_acum.paretoAcum <=80 THEN 'A' 
          WHEN pareto_acum.paretoAcum > 80 AND pareto_acum.paretoAcum <=95 THEN 'B' 
          WHEN pareto_acum.paretoAcum > 95 THEN 'C' 
      END as clas
      FROM (
        SELECT *
        FROM inpro
        JOIN (
          SELECT vtvtdCpro,SUM(vtvtdImpT) AS total
          FROM vtVtd
          JOIN vtVta ON vtvtaNtra = vtvtdNtra
          WHERE vtvtaMdel = 0
          AND YEAR(vtvtaFtra) = " . $request->gestion . "
          AND MONTH(vtvtaFtra) IN (" . implode(",", $mes_num) . ")
          AND vtvtaCusr IN (" . implode(",", $usr) . ")
          GROUP BY vtvtdCpro
        ) AS venta ON venta.vtvtdCpro = inproCpro
      ) AS inpro
      LEFT JOIN inume AS umpro ON umpro.inumeCume = inpro.inproCumb
      LEFT JOIN 
      (
          SELECT 
          CONVERT(varchar,maconCcon)+'|'+CONVERT(varchar,maconItem) AS maconMarc, 
          maconNomb 
          FROM macon 
          WHERE maconCcon = 113
      ) AS marc ON inpro.inproMarc = marc.maconMarc
      LEFT JOIN 
      (
        SELECT intrdCpro, SUM(intrdCanb) AS stock
        FROM intra
        JOIN intrd ON intraNtra = intrdNtra
        WHERE intraMdel = 0
        AND intrdMdel = 0
        AND intraFtra <= '" . $fAnt . "'
        GROUP BY intrdCpro
      ) AS stock_anterior ON stock_anterior.intrdCpro = inpro.inproCpro
      " . $sql_mes . "
      LEFT JOIN 
      (
        SELECT
        vtvtdCpro, SUM(vtvtdImpT - vtvtdDesT) AS venta_total, SUM(vtvtdCosT) AS venta_total_costo, SUM(vtvtdCant) AS venta_cant_total
        FROM vtVta
        JOIN vtVtd ON vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND YEAR(vtvtaFtra) = " . $request->gestion . "
        AND MONTH(vtvtaFtra) IN (" . implode(",", $mes_num) . ")
        AND vtvtaCusr IN (" . implode(",", $usr) . ")
        GROUP BY vtvtdCpro
      ) AS ventas_imp ON ventas_imp.vtvtdCpro = inpro.inproCpro
      LEFT JOIN 
      (
        SELECT vtvtdCpro, SUM(SUM(vtvtdImpT - vtvtdDesT)) OVER (ORDER BY SUM(vtvtdImpT - vtvtdDesT) DESC)/(SELECT SUM(vtvtdImpT - vtvtdDesT)
        FROM vtVta
        JOIN vtVtd ON vtvtdNtra = vtvtaNtra
        WHERE vtvtaMdel = 0
        AND YEAR(vtvtaFtra) = " . $request->gestion . "
        AND MONTH(vtvtaFtra) IN (" . implode(",", $mes_num) . ")
        AND vtvtaCusr IN (" . implode(",", $usr) . "))*100 AS paretoAcum FROM vtVta JOIN vtVtd ON vtvtdNtra = vtvtaNtra WHERE vtvtaMdel = 0
        AND YEAR(vtvtaFtra) = " . $request->gestion . "
        AND MONTH(vtvtaFtra) IN (" . implode(",", $mes_num) . ")
        GROUP BY vtvtdCpro
      ) AS pareto_acum ON pareto_acum.vtvtdCpro = inpro.inproCpro
      " . $categ . "
      ORDER BY pareto_acum.paretoAcum ASC
      ";
    // dd($query);
    $test = DB::connection('sqlsrv')->select(DB::raw($query));
    $titulos =
      [
        ['name' => 'categoria', 'data' => 'categoria', 'title' => 'Categoria', 'tip' => 'filtro'],
        ['name' => 'codigo', 'data' => 'codigo', 'title' => 'Codigo', 'tip' => 'filtro'],
        ['name' => 'descripcion', 'data' => 'descripcion', 'title' => 'Descripcion', 'tip' => 'filtro'],
        ['name' => 'umpro', 'data' => 'umpro', 'title' => 'U.M.', 'tip' => 'filtro_select'],
        ['name' => 'stock_anterior', 'data' => 'stock_anterior', 'title' => 'StockDiaAnterior', "className" => "dt-right"],
      ];
    foreach ($titulo_mes_venta as $key => $value) {
      $titulos[] = $value;
    }
    $titulos[] = ['name' => 'StockMin', 'data' => 'StockMin', 'title' => 'StockMinimo', 'className' => 'dt-right'];
    $titulos[] = ['name' => 'StockMax', 'data' => 'StockMax', 'title' => 'StockMaximo', 'className' => 'dt-right'];
    $titulos[] = ['name' => 'StockCon', 'data' => 'StockCon', 'title' => 'StockSeguro', 'className' => 'dt-right'];
    $titulos[] = ['name' => 'PedidoSug', 'data' => 'PedidoSug', 'title' => 'PedidoSugerido', 'className' => 'dt-right'];
    if (Auth::user()->tienePermiso(41, 10)) {
      $titulos[] = ['name' => 'PCant', 'data' => 'PCant', 'title' => 'Cantidad', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'PTotal', 'data' => 'PTotal', 'title' => 'Total', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'PTotalNeto', 'data' => 'PTotalNeto', 'title' => 'TotalNeto', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'MU', 'data' => 'MU', 'title' => 'MU', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'PorcMU', 'data' => 'PorcMU', 'title' => '%MU', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'ParTotal', 'data' => 'ParTotal', 'title' => 'Pareto', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'ParetoAcum', 'data' => 'ParetoAcum', 'title' => '%ParetoAcum', 'className' => 'color_mes_pareto dt-right'];
      $titulos[] = ['name' => 'clas', 'data' => 'clas', 'title' => 'Clase', 'className' => 'color_mes_pareto dt-right'];
    }

    $titulos_excel =
      [
        'Categoria',
        'Codigo',
        'Descripcion',
        'U.M,',
        'StockDiaAnterior',
      ];
    foreach ($mes_num as $key => $value) {
      $titulos_excel[] = 'CompraTotal';
      $titulos_excel[] = 'Retail';
      $titulos_excel[] = 'Mayorista';
      $titulos_excel[] = 'Institucional';
    }
    $titulos_excel[] = 'StockMinimo';
    $titulos_excel[] = 'StockMaximo';
    $titulos_excel[] = 'StockSeguro';
    $titulos_excel[] = 'PedidoSugerido';
    if (Auth::user()->tienePermiso(41, 10)) {
      $titulos_excel[] = 'Cantidad';
      $titulos_excel[] = 'Total';
      $titulos_excel[] = 'TotalNeto';
      $titulos_excel[] = 'MU';
      $titulos_excel[] = '%MU';
      $titulos_excel[] = 'Pareto';
      $titulos_excel[] = '%Pareto';
      $titulos_excel[] = 'Clase';
    }

    $titulos_excel_2 =
      [
        '',
        '',
        '',
        '',
        '',
      ];
    foreach ($mes_num as $key => $value) {
      if ($value == 1) {
        $titulos_excel_2[] = 'COMPRAS ENERO';
        $titulos_excel_2[] = 'VENTAS ENERO';
        $titulos_excel_2[] = 'VENTAS ENERO';
        $titulos_excel_2[] = 'VENTAS ENERO';
      }
      if ($value == 2) {
        $titulos_excel_2[] = 'COMPRAS FEBRERO';
        $titulos_excel_2[] = 'VENTAS FEBRERO';
        $titulos_excel_2[] = 'VENTAS FEBRERO';
        $titulos_excel_2[] = 'VENTAS FEBRERO';
      }
      if ($value == 3) {
        $titulos_excel_2[] = 'COMPRAS MARZO';
        $titulos_excel_2[] = 'VENTAS MARZO';
        $titulos_excel_2[] = 'VENTAS MARZO';
        $titulos_excel_2[] = 'VENTAS MARZO';
      }
      if ($value == 4) {
        $titulos_excel_2[] = 'COMPRAS ABRIL';
        $titulos_excel_2[] = 'VENTAS ABRIL';
        $titulos_excel_2[] = 'VENTAS ABRIL';
        $titulos_excel_2[] = 'VENTAS ABRIL';
      }
      if ($value == 5) {
        $titulos_excel_2[] = 'COMPRAS MAYO';
        $titulos_excel_2[] = 'VENTAS MAYO';
        $titulos_excel_2[] = 'VENTAS MAYO';
        $titulos_excel_2[] = 'VENTAS MAYO';
      }
      if ($value == 6) {
        $titulos_excel_2[] = 'COMPRAS JUNIO';
        $titulos_excel_2[] = 'VENTAS JUNIO';
        $titulos_excel_2[] = 'VENTAS JUNIO';
        $titulos_excel_2[] = 'VENTAS JUNIO';
      }
      if ($value == 7) {
        $titulos_excel_2[] = 'COMPRAS JULIO';
        $titulos_excel_2[] = 'VENTAS JULIO';
        $titulos_excel_2[] = 'VENTAS JULIO';
        $titulos_excel_2[] = 'VENTAS JULIO';
      }
      if ($value == 8) {
        $titulos_excel_2[] = 'COMPRAS AGOSTO';
        $titulos_excel_2[] = 'VENTAS AGOSTO';
        $titulos_excel_2[] = 'VENTAS AGOSTO';
        $titulos_excel_2[] = 'VENTAS AGOSTO';
      }
      if ($value == 9) {
        $titulos_excel_2[] = 'COMPRAS SEPTIEMBRE';
        $titulos_excel_2[] = 'VENTAS SEPTIEMBRE';
        $titulos_excel_2[] = 'VENTAS SEPTIEMBRE';
        $titulos_excel_2[] = 'VENTAS SEPTIEMBRE';
      }
      if ($value == 10) {
        $titulos_excel_2[] = 'COMPRAS OCTUBRE';
        $titulos_excel_2[] = 'VENTAS OCTUBRE';
        $titulos_excel_2[] = 'VENTAS OCTUBRE';
        $titulos_excel_2[] = 'VENTAS OCTUBRE';
      }
      if ($value == 11) {
        $titulos_excel_2[] = 'COMPRAS NOVIEMBRE';
        $titulos_excel_2[] = 'VENTAS NOVIEMBRE';
        $titulos_excel_2[] = 'VENTAS NOVIEMBRE';
        $titulos_excel_2[] = 'VENTAS NOVIEMBRE';
      }
      if ($value == 12) {
        $titulos_excel_2[] = 'COMPRAS DICIEMBRE';
        $titulos_excel_2[] = 'VENTAS DICIEMBRE';
        $titulos_excel_2[] = 'VENTAS DICIEMBRE';
        $titulos_excel_2[] = 'VENTAS DICIEMBRE';
      }
    }
    $titulos_excel_2[] = '';
    $titulos_excel_2[] = '';
    $titulos_excel_2[] = '';
    $titulos_excel_2[] = '';
    if (Auth::user()->tienePermiso(41, 10)) {
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
      $titulos_excel_2[] = 'PARETO';
    }
    // dd($titulos);
    if ($request->gen == "excel") {
      if (!Auth::user()->tienePermiso(41, 10)) {
        foreach ($test as $key => $value) {
          unset($value->PCant);
          unset($value->PTotal);
          unset($value->PTotalNeto);
          unset($value->MU);
          unset($value->PorcMU);
          unset($value->ParTotal);
          unset($value->ParetoAcum);
          unset($value->clas);
        }
      }
      $export = new SegmentoProductoExport($test, $titulos_excel,  $titulos_excel_2);
      return Excel::download($export, 'Segmento X Producto.xlsx');
    } else {
      return view('reports.vista.segmentoproducto', compact('test', 'titulos', 'mes_num'));
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
