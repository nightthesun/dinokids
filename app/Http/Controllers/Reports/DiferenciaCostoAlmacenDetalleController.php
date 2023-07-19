<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;

class DiferenciaCostoAlmacenDetalleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function create()
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
    $fini = date("d/m/Y", strtotime($request->fini));
    $ffin = date("d/m/Y", strtotime($request->ffin));
    // dd($query_prodList);
    $sql_query = "
      DECLARE @Cpro nvarchar(9)
      SELECT @Cpro = '" . $request->id . "';
      WITH cte as
      (
      SELECT
      intrdCpro,
      inproNomb,
      inumeAbre,
      intraCalm,
      intraFtra,
      Case
          When intrdCanb = 0 Then 0
          Else intrdCTmi/intrdCanb
          End as _CostUnit
      FROM intra
      JOIN intrd On (intraNtra = intrdNtra And intrdMdel = 0)
      JOIN inpro On (intrdCpro = inproCpro)
      JOIN inalm On (intraCalm = inalmCalm)
      LEFT JOIN inume as umpro ON umpro.inumeCume = inpro.inproCumb
      WHERE intraMdel = 0 And intrdCanb <> 0 And inproCpro = @Cpro
      AND intraCalm IN (46,47,43,7,4,6,5,67)
      AND intraFtra BETWEEN '" . $fini . "' AND '" . $ffin . "'
      )
      SELECT 
      intrdCpro,
      inproNomb,
      inumeAbre,
      CONVERT(varchar,intraFtra,103) AS fecha,
      CONVERT(varchar, CAST(ISNULL([46],0) AS decimal(10,4)),1) AS 'AC1',
      CONVERT(varchar, CAST(ISNULL([47],0) AS decimal(10,4)),1) AS 'AC2',
      CONVERT(varchar, CAST(ISNULL([43],0) AS decimal(10,4)),1) AS 'AlmProd',
      CONVERT(varchar, CAST(ISNULL([7],0) AS decimal(10,4)),1) AS 'Ballivian',
      CONVERT(varchar, CAST(ISNULL([4],0) AS decimal(10,4)),1) AS 'Handal',
      CONVERT(varchar, CAST(ISNULL([6],0) AS decimal(10,4)),1) AS 'Mariscal',
      CONVERT(varchar, CAST(ISNULL([5],0) AS decimal(10,4)),1) AS 'Calacoto',
      CONVERT(varchar, CAST(ISNULL([67],0) AS decimal(10,4)),1) AS 'SanMiguel',
      CONVERT(varchar, CAST(ISNULL((ISNULL([46],0)+ISNULL([47],0)+ISNULL([43],0)+ISNULL([7],0)+ISNULL([4],0)+ISNULL([6],0)+ISNULL([5],0)+ISNULL([67],0))/8,0) AS decimal(10,4)),1) AS Promedio
      FROM (
      SELECT *
      FROM cte
      --WHERE RN = 1
      ) AS Mov_Prod
      PIVOT (
          SUM(_CostUnit)
          FOR  intraCalm IN ([46],[47],[43],[7],[4],[6],[5],[67])
      ) AS pivotable
      ORDER BY intraFtra
      ";
    $query = DB::connection('sqlsrv')->select(DB::raw($sql_query));
    // dd($request->marc);
    return response()->json(['detalle' => $query]);
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
