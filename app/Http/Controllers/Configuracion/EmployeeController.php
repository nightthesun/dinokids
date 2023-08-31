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
    public function __construct()
     {
       $this->middleware('auth');
     }
    public function index()
    {
        try {
            if (Auth::user()->authorizePermisos(['Administrar', 'Ver'])) {
                $user = Auth::user();
              
                $usuario=User::orderBy('id','DESC')->get();
                $query_reg_employees = " SELECT e.id,p.first_name,p.last_name1,p.last_name2,b.name,ad.name as nameAD,c.name as nameC,d.name as nameD
                from `reg_employees` e        
                left join `reg_people` p on e.id_people=p.id
                left join `reg_branch` b on b.id = p.id_branch
                left join `reg_academic_degree` ad on  ad.id=e.id_academic_degree
                left join `reg_cargos` c on c.id =e.id_reg_cargos
                left join `reg_department` d on d.id=c.id_department
                where e.deleted=0 
                ";     
                $employees = DB::select($query_reg_employees);
                //$query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad,d.name as nameD 
                //from `reg_cargos` c
                //join `reg_department` d on c.id_department=d.id where d.deleted=0 
                //    ";
                //$cargo = DB::select($query_reg_cargo); 
                return view('configuracion.empleado.index',compact('usuario','user','employees'));  
          
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
                
                $query_reg_employees = "SELECT id_people from reg_employees where deleted=0 
                ";     
                $employees = DB::select($query_reg_employees);
                $idX="";
                foreach ($employees as $key => $value) {
                    $idX=$idX.$value->id_people.",";
                     
                }  
                $idX=rtrim($idX,",");
               
                if (!empty($idX)) {
                    $query_reg_people="SELECT p.id,p.first_name,p.last_name1,p.last_name2,p.ci,t.name as nameT,b.name as nameB,c.name as nameC from `reg_people` p 
                join `reg_types` t on p.id_tipo=t.id
                join `reg_branch` b on p.id_branch=b.id
                join `reg_city` c on p.city=c.id
                where p.id_tipo = 3 and p.deleted =0 and p.id NOT in  ($idX)
                ";
                } else {
                    $query_reg_people="SELECT p.id,p.first_name,p.last_name1,p.last_name2,p.ci,t.name as nameT,b.name as nameB,c.name as nameC from `reg_people` p 
                    join `reg_types` t on p.id_tipo=t.id
                    join `reg_branch` b on p.id_branch=b.id
                    join `reg_city` c on p.city=c.id
                    where p.id_tipo = 3 and p.deleted =0 
                    ";  
                }
                
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
    
       try {
            if (Auth::user()->authorizePermisos(['Administrar', 'Crear'])) {
        
        
            $user = Auth::user()->id;
            $fecha_actual = new DateTime();
            $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
            $id_people=$request->input('principal');
            $id_cargo=$request->input('cargo');
            $id_grado=$request->input('grado');
            DB::table('reg_employees')->insert([
               
                'created_user_id' => $user,
                'created_date' => $fecha_actual,
                'deleted' => 0,
                'id_people' => $id_people,
                'id_academic_degree' =>$id_grado,
                'id_reg_cargos' =>$id_cargo ,
              ]);

              $query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad 
              from `reg_cargos` c
               where c.id='$id_cargo'
                limit 1";
              $cargo = DB::select($query_reg_cargo);

                $query_reg_peole="SELECT c.id,c.first_name,c.last_name1,c.last_name2
              from `reg_people` c
               where c.id='$id_people'
                 limit 1";
              $people = DB::select($query_reg_peole);
                 
                // Obtener el ID generado en la inserción en la tabla reg_people
              $cadena="Nombre:".$people[0]->first_name." ".$people[0]->last_name1." ".$people[0]->last_name2." Descripción:".$cargo[0]->name;
                  
              DB::table('sis_log_created')->insert([
                'description' => $cadena,
                'modulo' => "empleado",
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
            if (Auth::user()->authorizePermisos(['Administrar', 'Editar'])) {
                $query_reg_employees_existente = " SELECT e.id,e.id_people,e.id_reg_cargos,e.id_academic_degree , p.first_name,p.last_name1,p.last_name2,b.name,ad.name as nameAD,c.name as nameC,d.name as nameD
                from `reg_employees` e        
                left join `reg_people` p on e.id_people=p.id
                left join `reg_branch` b on b.id = p.id_branch
                left join `reg_academic_degree` ad on  ad.id=e.id_academic_degree
                left join `reg_cargos` c on c.id =e.id_reg_cargos
                left join `reg_department` d on d.id=c.id_department
                where e.deleted=0 and e.id='$id' limit 1;
                ";                
                $employees_existente = DB::select($query_reg_employees_existente);
            
                if (count($employees_existente)==1) {
                    $query_reg_people="SELECT e.id as idPER,p.id,p.first_name,p.last_name1,p.last_name2,p.ci,t.name as nameT,b.name as nameB,c.name as nameC
                     from `reg_people` p 
                     left join `reg_employees` e on e.id_people=p.id
                    join `reg_types` t on p.id_tipo=t.id
                    join `reg_branch` b on p.id_branch=b.id
                    join `reg_city` c on p.city=c.id
                    where p.id_tipo = 3 and p.deleted =0 
                    "; 
                      $pleople = DB::select($query_reg_people);
                } else {
                    dd("Error de tamaño");
                }
                $query_reg_academic_degree="SELECT * from `reg_academic_degree` where id in(1,2,3,4,5,6,7,8,9)";
                $academic_degree = DB::select($query_reg_academic_degree);
                $query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad,d.name as nameD 
                from `reg_cargos` c
                join `reg_department` d on c.id_department=d.id where d.deleted=0 
                    ";
                $cargo = DB::select($query_reg_cargo);
                   return view('configuracion.empleado.edit', compact('id','cargo','academic_degree','pleople','employees_existente')); 
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
        try {
            if (Auth::user()->authorizePermisos(['Administrar', 'Editar'])) {
        
        
            $user = Auth::user()->id;
            $fecha_actual = new DateTime();
            $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
            $id_people=$request->input('principal');
            $id_cargo=$request->input('cargo');
            $id_grado=$request->input('grado');
            DB::table('reg_employees')
            ->where('id',$id)
            ->update([
                'modified_user' => $user,
                'modified_date' => $fecha_actual,
             
                'id_people' => $id_people,
                'id_academic_degree' =>$id_grado,
                'id_reg_cargos' =>$id_cargo ,
              ]);

              $query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad 
              from `reg_cargos` c
               where c.id='$id_cargo'
                limit 1";
              $cargo = DB::select($query_reg_cargo);

                $query_reg_peole="SELECT c.id,c.first_name,c.last_name1,c.last_name2
              from `reg_people` c
               where c.id='$id_people'
                 limit 1";
              $people = DB::select($query_reg_peole);
                 
                // Obtener el ID generado en la inserción en la tabla reg_people
              $cadena="Nombre:".$people[0]->first_name." ".$people[0]->last_name1." ".$people[0]->last_name2." Descripción:".$cargo[0]->name;
                  
              DB::table('sis_log_modified')->insert([
                'description' => $cadena,
                'modulo' => "empleado",
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
      
        try {
            if (Auth::user()->authorizePermisos(['Administrar', 'Eliminar'])) {
              $query_empleado="SELECT e.id, e.id_people
                    from `reg_employees` e
                    join `reg_people` p on e.id_people=p.id
              where p.deleted=0 and e.id='$id';
              ";
              $empleado = DB::select($query_empleado);        
              $tamaño=count($empleado);
              if ($tamaño>0) {
                return redirect()->route('errors.eliminacion');
                
              } else {
                $obs=$request->input("motivo");
                
                           $cadena=" Motivo: ".$obs;
                        
                           $user = Auth::user()->id;
                          $fecha_actual = new DateTime();
                          $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
                          DB::table('sis_log_deleted')->insert([
                            'description' => $cadena,
                            'modulo' => "cargos",
                            'user_id' => $user,
                            'datetime' => $fecha_actual,
                            ]);
                          DB::table('reg_cargos')->where('id', $id)->delete();
                          return redirect()->back()->with('status', 'delete');
              }
            }else{
              return redirect()->route('errors.permisos');
            }
          } catch (\Throwable $th) {
            dd($th);
          }
    }
}
