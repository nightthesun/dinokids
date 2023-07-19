<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class ReporteVentasDetalleController extends Controller
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
        //
        $detalle = "
        SELECT
        vtvtdNtra,
        inproCpro,
        inproNomb,
        CONVERT(varchar, CAST((vtvtdImpT/vtvtdCant) as money), 1) AS ImpU,
        vtvtdCant,
        CONVERT(varchar, CAST(vtvtdImpT as money), 1) AS ImpT,
        CONVERT(varchar, CAST(vtvtdDesT as money), 1) AS DesT,
        CONVERT(VARCHAR, cast((vtvtdDesT * 100 / vtvtdImpT) as money),1) AS DesPor,
        CONVERT(varchar, CAST((vtvtdImpT - vtvtdDesT) as money), 1) AS total
        FROM vtVtd
        LEFT JOIN inpro ON inproCpro = vtvtdCpro
        WHERE vtvtdMdel = 0
        AND vtvtdNtra = ".$request->id."
        ";       
        $venta_detalle = DB::connection('sqlsrv')->select(DB::raw($detalle));

        return response()->json(['detalle' => $venta_detalle]);
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
