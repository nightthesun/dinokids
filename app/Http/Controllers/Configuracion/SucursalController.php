<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Perfil;
use App\Permiso;
use App\Modulo;
use App\SubModulo;
use App\Program;
use Illuminate\Support\Facades\Storage;
use App\Unidad;
use DateTime;
//use DB;
use Illuminate\Support\Facades\DB;
use Session;
use App\VacacionForm;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use Illuminate\Support\Facades\Hash;
class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    if (Auth::user()->authorizePermisos(['sucursal', 'Ver'])) {
        
        $query_reg_branch = 'SELECT a.id, a.name as nameDres, a.description as descripS, a.id_address as idDress, aa.zone, aa.street,aa.number
        FROM `reg_branch` a
        left join `reg_address` aa on aa.id=a.id_address
        ORDER BY a.id desc';
         
            
            $branch = DB::select($query_reg_branch);
          
            $user = Auth::user();
     
            $usuario=User::orderBy('id','DESC')->get();
            return view('configuracion.sucursal.index',compact('usuario','user','branch'));  
      
    } else {
      return redirect()->route('errors.permisos');
    }
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
