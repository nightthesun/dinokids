<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use DateTime;

use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
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
        if (Auth::user()->authorizePermisos(['Horario', 'Ver'])) {
        
            //$query_reg_class = "SELECT c.id,c.time_ini,c.time_fini,cc.name as nameSucursal,p.first_name,p.last_name1,p.last_name2,p.gender,ccc.alias,i.interventionarea_name,ccc.number,b.name as nameSucu 
            //from `reg_class` c
            //join `reg_employees` e on c.id_empleado=e.id_people
            //join `reg_cargos` cc on e.id_reg_cargos=cc.id
            //join `reg_people` p on p.id=e.id_people
            //join `reg_classroom` ccc on ccc.id=c.id_classroom
            //join `reg_branch` b on b.id=ccc.id_branch
            //join `reg_interventionareas` i on i.id=c.id_interventionare
  
             //ORDER BY c.id ";
             // $class = DB::select($query_reg_class);
              $user = Auth::user();
               $usuario=User::orderBy('id','DESC')->get();
                 return view('configuracion.horario.index',compact('usuario','user'));  
           
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
