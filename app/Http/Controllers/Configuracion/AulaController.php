<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use DateTime;
//use DB;
use Illuminate\Support\Facades\DB;


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
        
            $query_reg_classroom = 'SELECT c.id , i.interventionarea_name ,c.number,c.alias,b.name ,c.capacidad
            FROM `reg_classroom` c
            join `reg_interventionareas` i on c.classroom_name=i.id
            join `reg_branch` b on c.id_branch=b.id
             ORDER BY c.id ';
             $classroom = DB::select($query_reg_classroom);
             $user = Auth::user();
              $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.aula.index',compact('usuario','user','classroom'));  
          
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
            if (Auth::user()->authorizePermisos(['Aula', 'Crear'])) {
                $query_reg_branch = 'SELECT a.id, a.name , a.description , a.deleted 
           FROM `reg_branch` a
           ORDER BY a.id ';
              $branchs = DB::select($query_reg_branch);
             
            $query_reg_area = 'SELECT a.id, a.interventionarea_name,a.interventionarea_description 
           FROM `reg_interventionareas` a
           ORDER BY a.id ';

            $areas = DB::select($query_reg_area);
           
                   return view('configuracion.aula.create', compact('branchs','areas')); 
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
      
       try {
            if (Auth::user()->authorizePermisos(['Aula', 'Crear'])) { 
                $user = Auth::user()->id;
                $fecha_actual = new DateTime();
                $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
                $id_area=$request->input('classroom_name');
                $data = $request->validate([
                    'classroom_name' => 'nullable',
                    'alias' => 'required|max:255',
                    'branch' => 'nullable',
                    'cantidad' => 'nullable',
                  ]);
                  $query_reg_interventionareas = "SELECT id,interventionarea_name
                  FROM `reg_interventionareas` 
                  where id='$id_area'
                  ORDER BY id ";
                  $interventionareas = DB::select($query_reg_interventionareas);
                  
                  $contador = DB::table('reg_classroom')->where('classroom_name', $interventionareas[0]->id)->count();
                  
                    $sum=$contador+1;
                  
    
                 DB::table('reg_classroom')->insertGetId([
                    'classroom_name' => $data['classroom_name'],
                    'alias' => $data['alias'],
                    'created_user_id' => $user,
                    'created_date' => $fecha_actual,
                    'deleted' => 0,
                    'id_branch' => $data['branch'],
                    'number' => $sum,
                    'capacidad' => $data['cantidad'],
                  ]);
                  // Obtener el ID generado en la inserción en la tabla reg_people
                  $cadena="Nombre:".$data['alias'];
                      
                  DB::table('sis_log_created')->insert([
                    'description' => $cadena,
                    'modulo' => "aula",
                    'user_id' => $user,
                    'datetime' => $fecha_actual,
                    ]);
                  
               return redirect()->back()->with('status', 'success');
                
            } else {
                return redirect()->route('errors.permisos');
           }
            
            
            } catch (\Throwable $th) {
                throw $th;
               
                //return redirect()->route('perfil.create')->with('jsonDatos',$jsonDatos)->with('jsonDatos',$jsonDatos);
                    //return view('configuracion.perfiles.create', compact('jsonDatos'));
                    return redirect()->back()->with('status', 'error');
             
              }
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
        try {
            if (Auth::user()->authorizePermisos(['Aula', 'Editar'])) {
                $query_reg_classroom = "SELECT c.id , i.interventionarea_name ,c.number,c.alias,b.name ,c.capacidad
                FROM `reg_classroom` c
                join `reg_interventionareas` i on c.classroom_name=i.id
                join `reg_branch` b on c.id_branch=b.id
                where c.id='$id'
                limit 1
                ";
              $classroom = DB::select($query_reg_classroom);

                $query_reg_branch = 'SELECT a.id, a.name , a.description , a.deleted 
           FROM `reg_branch` a
           ORDER BY a.id ';
              $branchs = DB::select($query_reg_branch);
             
            $query_reg_area = 'SELECT a.id, a.interventionarea_name,a.interventionarea_description 
           FROM `reg_interventionareas` a
           ORDER BY a.id ';

            $areas = DB::select($query_reg_area);
           
                   return view('configuracion.aula.edit', compact('branchs','areas','id','classroom')); 
              } else {
            return redirect()->route('errors.permisos');
         }   
                      
        } catch (\Throwable $th) {
            dd($th);
        }
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
        if (Auth::user()->number_modif<=0) {
            return redirect()->back()->with('status', 'edit');
          } else {
            try {
             $user = Auth::user()->id;
             $fecha_actual = new DateTime();
             $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
             $data = $request->validate([
                'classroom_name' => 'nullable',
                'number' => 'nullable',
                'alias' => 'required|max:255',
                'branch' => 'nullable',
                'cantidad' => 'nullable',
              ]);
              
          DB::table('reg_classroom')
           ->where('id',$id) 
           ->update([
            'classroom_name' => $data['classroom_name'],
            'alias' => $data['alias'],
            'modified_user' => $user,
            'modified_date' => $fecha_actual,
            'id_branch' => $data['branch'],
            'number' => $data['number'],
            'capacidad' => $data['cantidad'],
          ]);
          $cadena="Nombre:".$data['alias'];
                  
          DB::table('sis_log_modified')->insert([
            'description' => $cadena,
            'modulo' => "aula",
            'user_id' => $user,
            'datetime' => $fecha_actual,
            ]);
            return redirect()->back()->with('status', 'success');
          } catch (\Throwable $th) {
              throw $th;
             
            return redirect()->back()->with('status', 'error');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("falta");
    }
}
