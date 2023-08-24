<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (Auth::user()->authorizePermisos(['Administrar', 'Ver'])) {
                $user = Auth::user();
    
                $usuario=User::orderBy('id','DESC')->get();
                //$query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad,d.name as nameD 
                //from `reg_cargos` c
                //join `reg_department` d on c.id_department=d.id where d.deleted=0 
                //    ";
                //$cargo = DB::select($query_reg_cargo); 
                return view('configuracion.empleado.index',compact('usuario','user'));  
          
        } else {
          return redirect()->route('errors.permisos');
        }
           } catch (\Throwable $th) {
            dd($th);
           } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            if (Auth::user()->authorizePermisos(['Administrar', 'Crear'])) {
                
                $query_reg_people="SELECT p.id,p.first_name,p.last_name1,p.last_name2,p.ci,t.name as nameT,b.name as nameB,c.name as nameC from `reg_people` p 
                join `reg_types` t on p.id_tipo=t.id
                join `reg_branch` b on p.id_branch=b.id
                join `reg_city` c on p.city=c.id
                where p.id_tipo = 3 and p.deleted =0
                ";
                $pleople = DB::select($query_reg_people);
                $query_reg_academic_degree="SELECT * from `reg_academic_degree` where id in(1,2,3,4,5,6,7,8,9)";
                $academic_degree = DB::select($query_reg_academic_degree);
                $query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad,d.name as nameD 
                from `reg_cargos` c
                join `reg_department` d on c.id_department=d.id where d.deleted=0 
                    ";
                $cargo = DB::select($query_reg_cargo);
                   return view('configuracion.empleado.create', compact('cargo','academic_degree','pleople')); 
              } else {
            return redirect()->route('errors.permisos');
         }   
                      
        } catch (\Throwable $th) {
            dd($th);
        }
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
