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
class AulaController extends Controller
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
        if (Auth::user()->authorizePermisos(['Aula', 'Ver'])) {
        
            $query_reg_branch = 'SELECT a.id, a.name as nameDres, a.description as descripS, a.deleted as elim
           FROM `reg_branch` a
           ORDER BY a.id ';
           
                
                $branch = DB::select($query_reg_branch);
         
                $user = Auth::user();
         
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.aula.index',compact('usuario','user','branch'));  
          
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
        try {
            if (Auth::user()->authorizePermisos(['Cargo', 'Crear'])) {
                $query_reg_branch = 'SELECT a.id, a.name as nameDres, a.description as descripS, a.deleted as elim
           FROM `reg_branch` a
           ORDER BY a.id ';
              $branchs = DB::select($query_reg_branch);
            $query_reg_area = 'SELECT a.id, a.interventionarea_name,a.interventionarea_description 
           FROM `reg_interventionareas` a
           ORDER BY a.id ';
              $areas = DB::select($query_reg_area);
            $array_numbers=array("1"=>1,"2"=>2,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9,"10"=>10);  
              
                   return view('configuracion.aula.create', compact('branchs','array_numbers','areas')); 
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
