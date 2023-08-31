<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use DateTime;

use Illuminate\Support\Facades\DB;

class ClaseController extends Controller
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
        if (Auth::user()->authorizePermisos(['Clase', 'Ver'])) {
        
           $query_reg_class = "SELECT c.id,c.time_ini,c.time_fini,cc.name as nameSucursal,p.first_name,p.last_name1,p.last_name2,p.gender,ccc.alias,i.interventionarea_name,ccc.number,b.name as nameSucu 
           from `reg_class` c
 join `reg_employees` e on c.id_empleado=e.id_people
 join `reg_cargos` cc on e.id_reg_cargos=cc.id
 join `reg_people` p on p.id=e.id_people
 join `reg_classroom` ccc on ccc.id=c.id_classroom
 join `reg_branch` b on b.id=ccc.id_branch
 join `reg_interventionareas` i on i.id=c.id_interventionare
 
            ORDER BY c.id ";
             $class = DB::select($query_reg_class);
             $user = Auth::user();
              $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.clase.index',compact('usuario','user','class'));  
          
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
        //depende de la tabla departamento con los datos de id 2: pedagogia si o si si no funcionara 
        try {
            if (Auth::user()->authorizePermisos(['Clase', 'Crear'])) {
                $query_reg_employees = "SELECT e.id_people,p.first_name,p.last_name1,p.last_name2,p.gender
                FROM `reg_employees` e
                join `reg_people` p on e.id_people=p.id
                join `reg_cargos` c on e.id_reg_cargos=c.id
                join `reg_department`d on c.id_department=d.id
                WHERE d.id=2 and p.deleted=0 
                order by e.id";
              $employees = DB::select($query_reg_employees);
             
            $query_reg_classroom = "SELECT c.id,i.interventionarea_name, c.number, c.alias , b.name
            from `reg_classroom` c    
            left join `reg_interventionareas` i on c.classroom_name = i.id
            left join `reg_branch` b on c.id_branch = b.id
            where c.deleted=0 and b.deleted=0
             ORDER BY c.id ";

            $classroom = DB::select($query_reg_classroom);
           
            $query_reg_area = " SELECT id,interventionarea_name,interventionarea_description
            from `reg_interventionareas`
              where deleted=0 
             ORDER BY id ";

            $areas = DB::select($query_reg_area);
           
                   return view('configuracion.clase.create', compact('employees','classroom','areas')); 
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
            if (Auth::user()->authorizePermisos(['Clase', 'Crear'])) { 
                $user = Auth::user()->id;
                $i=$request->input('fecha_ini');
                $f=$request->input('fecha_fini');

                if ($i>$f) {
                    return redirect()->back()->with('status', 'time');
                } 
                

                $fecha_actual = new DateTime();
                $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
               
                $data = $request->validate([
                    'principal' => 'nullable',
                    'fecha_ini' => 'nullable',
                    'fecha_fini' => 'nullable',
                    'id_programa' => 'nullable',
                    'id_classroom' => 'nullable',
                  ]);
                  
                 DB::table('reg_class')->insert([
                    'time_ini' => $data['fecha_ini'],
                    'time_fini' => $data['fecha_fini'],
                    'created_user_id' => $user,
                    'created_date' => $fecha_actual,
                    'deleted' => 0,
                    'id_empleado' => $data['principal'],
                    'id_classroom' => $data['id_classroom'],
                    'id_interventionare' => $data['id_programa'],
                    
                  ]);
                  // Obtener el ID generado en la inserción en la tabla reg_people
                  $cadena="Tiempo:".$data['fecha_ini'] ." - ".$data['fecha_fini'] ;
                      
                  DB::table('sis_log_created')->insert([
                    'description' => $cadena,
                    'modulo' => "clase",
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
         //depende de la tabla departamento con los datos de id 2: pedagogia si o si si no funcionara 
         try {
            if (Auth::user()->authorizePermisos(['Clase', 'Crear'])) {

                $query_reg_class="SELECT  time_ini,time_fini,id_empleado,id_classroom,id_interventionare
                from `reg_class` where id='$id' limit 1
                ";
                $class=DB::select($query_reg_class);
            
                $query_reg_employees = "SELECT e.id_people,p.first_name,p.last_name1,p.last_name2,p.gender
                FROM `reg_employees` e
                join `reg_people` p on e.id_people=p.id
                join `reg_cargos` c on e.id_reg_cargos=c.id
                join `reg_department`d on c.id_department=d.id
                WHERE d.id=2 and p.deleted=0 
                order by e.id";
              $employees = DB::select($query_reg_employees);
             
            $query_reg_classroom = "SELECT c.id,i.interventionarea_name, c.number, c.alias , b.name
            from `reg_classroom` c    
            left join `reg_interventionareas` i on c.classroom_name = i.id
            left join `reg_branch` b on c.id_branch = b.id
            where c.deleted=0 and b.deleted=0
             ORDER BY c.id ";

            $classroom = DB::select($query_reg_classroom);
           
            $query_reg_area = " SELECT id,interventionarea_name,interventionarea_description
            from `reg_interventionareas`
              where deleted=0 
             ORDER BY id ";

            $areas = DB::select($query_reg_area);
           
                   return view('configuracion.clase.edit', compact('employees','classroom','areas','id','class')); 
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
            if (Auth::user()->authorizePermisos(['Clase', 'Crear'])) { 
                $user = Auth::user()->id;
                $i=$request->input('fecha_ini');
                $f=$request->input('fecha_fini');

                if ($i>$f) {
                    return redirect()->back()->with('status', 'time');
                } 
                

                $fecha_actual = new DateTime();
                $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
               
                $data = $request->validate([
                    'principal' => 'nullable',
                    'fecha_ini' => 'nullable',
                    'fecha_fini' => 'nullable',
                    'id_programa' => 'nullable',
                    'id_classroom' => 'nullable',
                  ]);
                  
                 DB::table('reg_class')->where('id',$id)
                 ->update([
                    'time_ini' => $data['fecha_ini'],
                    'time_fini' => $data['fecha_fini'],
                    'modified_user' => $user,
                    'modified_date' => $fecha_actual,
                 
                    'id_empleado' => $data['principal'],
                    'id_classroom' => $data['id_classroom'],
                    'id_interventionare' => $data['id_programa'],
                    
                  ]);
                  // Obtener el ID generado en la inserción en la tabla reg_people
                  $cadena="Tiempo:".$data['fecha_ini'] ." - ".$data['fecha_fini'] ;
                      
                  DB::table('sis_log_modified')->insert([
                    'description' => $cadena,
                    'modulo' => "clase",
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("encontruccion");
    }
}
