<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DosificacionController extends Controller
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
      $sql = "
      SELECT 
      inDxLNAut,
      CONVERT(DATE,inDxLFini) AS fechaini,
      CONVERT(DATE,inDxLFemi) AS fechafin,
      inDxLCcaj,
      ISNULL(adusrNomb,'-') AS usuario,
      inDxLCloc,
      ISNULL(inlocNomb, '-') AS local,
      inDxLDire,
      inDxLTelf,
      CASE inDxLEsta 
      WHEN 0 THEN 'Habilitado'
      ELSE 'Deshabilitado'
      END AS 'Estado'
      FROM inDxL
      LEFT JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = inDxLCcaj
      LEFT JOIN inloc ON inlocCloc = inDxLCloc
      ORDER BY inDxLFini DESC
      ";
      $query = DB::connection('sqlsrv')->select(DB::raw($sql));

      $titulos = [
        ['name' => 'inDxLNAut', 'data' => 'inDxLNAut', 'title' => 'Dosificación', 'tip' => 'filtro'],
        ['name' => 'fechaini', 'data' => 'fechaini', 'title' => 'FechaIni'],
        ['name' => 'fechafin', 'data' => 'fechafin', 'title' => 'FechaFin'],
        ['name' => 'usuario', 'data' => 'usuario', 'title' => 'Usuario', 'tip' => 'filtro'],
        ['name' => 'local', 'data' => 'local', 'title' => 'Local', 'tip' => 'filtro'],
        ['name' => 'inDxLDire', 'data' => 'inDxLDire', 'title' => 'Direccion'],
        ['name' => 'inDxLTelf', 'data' => 'inDxLTelf', 'title' => 'Telefono', 'tip' => 'filtro'],
        ['name' => 'estado', 'data' => 'Estado', 'title' => 'Estado', 'tip' => 'filtro'],
      ];

      return view('reports.dosificacion', compact('titulos','query'));
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
