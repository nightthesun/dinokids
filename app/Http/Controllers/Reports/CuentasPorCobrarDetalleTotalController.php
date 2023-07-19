<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class CuentasPorCobrarDetalleTotalController extends Controller
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
    $detalle = "
      SELECT
      fechaNR,
      vtvtaNtra,
      cxcTrCcto,
      Cliente,
      fechaFC,
      imLvtNrfc,
      Glosa,
      Rsocial,
      Nit,
      ImporteCXC,
      fechaAC,
      REPLACE(cast(ISNULL(cont,0) as decimal(10,2)),',', '.') AS cont,
      REPLACE(cast(ISNULL(cred,0) as decimal(10,2)),',', '.') AS cred,
      adusrNomb
      FROM (
        SELECT
        CONVERT(varchar,venta.vtvtaFtra,103) AS fechaNR,
        venta.vtvtaNtra,
        cxcTrCcto,
        cxcTrNcto AS 'Cliente',
        CONVERT(varchar,venta.imLvtFech,103) AS fechaFC,
        venta.imLvtNrfc,
        cobros.liqXCGlos AS 'Glosa',
        isnull(imLvtRsoc,'-') AS Rsocial,
        isnull(imLvtNNit,'-') AS Nit,
        cast(cxcTrImpt AS decimal(10,2))AS 'ImporteCXC',
        CASE
        WHEN cobros.liqXCFtra <= DATEADD(DAY,10,venta.vtvtaFtra) THEN 'cont'
        ELSE 'cred'
        END AS Estado,
        CONVERT(varchar,cobros.liqXCFtra,103) AS fechaAC,
        ISNULL(cobros.AcuentaF,0) AS 'ACuenta',
        adusrNomb
        FROM cxcTr
        LEFT JOIN cptra ON cptraNtrI = cxcTrNtrI
        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0
        LEFT JOIN
        (
          SELECT *
          FROM vtVta
          LEFT JOIN imLvt ON imlvtNvta = vtvtaNtra
          WHERe vtvtaMdel = 0
          AND vtvtaFtra <= '".$request->fecha."'
        )AS venta ON vtvtaNtra = cxcTrNtrI
        LEFT JOIN
        (
          SELECT liqdCNtcc, liqdCAcmt AS AcuentaF, liqXCFtra, liqXCGlos--,SUM(liqdCAcmt) as AcuentaF
          FROM liqdC
          JOIN liqXC ON liqdCNtra = liqXCNtra
          WHERE liqXCMdel = 0 
          --GROUP BY liqdCNtcc
        )AS cobros ON cobros.liqdCNtcc = cxcTrNtra
        WHERE cxcTrMdel = 0
        AND cxcTrNcto LIKE '%".$request->id."%'
      ) AS pivotdetalle
      PIVOT
      (
        SUM(ACuenta)
        FOR Estado IN ([cont],[cred])
      ) AS pivotable
      ORDER BY fechaNR
      ";
    $t_det = DB::connection('sqlsrv')->select(DB::raw($detalle));

    return response()->json(['detalle' => $t_det]);
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
