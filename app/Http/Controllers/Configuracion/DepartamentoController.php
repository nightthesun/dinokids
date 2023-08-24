<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Session;
class DepartamentoController extends Controller
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
            if (Auth::user()->authorizePermisos(['Departamento', 'Ver'])) {
                $user = Auth::user();    
                $usuario=User::orderBy('id','DESC')->get();
                $query_reg_department="SELECT d.id,d.name,d.description from `reg_department` d where d.deleted=0 
                ";
                $department = DB::select($query_reg_department);    
                return view('configuracion.departamento.index',compact('usuario','user','department'));  
          
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
            if (Auth::user()->authorizePermisos(['Departamento', 'Crear'])) {
                $var="Existo";
                   return view('configuracion.departamento.create', compact('var')); 
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
        $user = Auth::user()->id;
        $fecha_actual = new DateTime();
        $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
         
          
         $data = $request->validate([
            'name' => 'required|max:255',
            'descripcion' => 'nullable',
            
          ]);
      
         DB::table('reg_department')->insertGetId([
            'name' => $data['name'],
            'description' => $data['descripcion'],
            'created_user_id' => $user,
            'created_date' => $fecha_actual,
            'deleted' => 0,
          ]);
          $cadena="Nombre:".$data['name']." Descripción:".$data['descripcion'];
                  
          DB::table('sis_log_created')->insert([
            'description' => $cadena,
            'modulo' => "departamento",
            'user_id' => $user,
            'datetime' => $fecha_actual,
            ]);
          // Obtener el ID generado en la inserción en la tabla reg_people
          
          
       
      
      
          return redirect()->back()->with('status', 'success');
        
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
        if (Auth::user()->authorizePermisos(['Departamento', 'Editar'])) {
                      
            $query_reg_department = "SELECT d.id,d.name,d.description 
            FROM `reg_department` d
            where d.id = '$id'
            ORDER BY d.id limit 1";
                $department = DB::select($query_reg_department);
                $user = Auth::user(); 
                    
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.departamento.edit',compact('usuario','user','department'));  
          
        } else {
          return redirect()->route('errors.permisos');
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
                'name' => 'required|max:255',
                'descripcion' => 'nullable',
                
              ]);
              
          DB::table('reg_department')
           ->where('id',$id) 
           ->update([
            'name' => $data['name'],
            'description' => $data['descripcion'],
            'modified_user' => $user,
            'modified_date' => $fecha_actual,
          ]);
          $cadena="Nombre:".$data['name']." Descripción:".$data['descripcion'];
                  
          DB::table('sis_log_modified')->insert([
            'description' => $cadena,
            'modulo' => "departamento",
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
           try {
                $query_valido1="SELECT * from `reg_department` d
                join `reg_cargos`c on c.id_department=d.id
                 where d.id=$id";
                $valido1 = DB::select($query_valido1);
                
               
                if (count($valido1)>0) {
                  return redirect()->route('errors.eliminacion');
                } else {
                  $query_valido2="SELECT * from `reg_department` d
                  join `reg_cargos`c on c.id_department=d.id
                  join `reg_employees`e on e.id_reg_cargos=c.id_department
                  where d.id=$id";
                  
                  $valido2 = DB::select($query_valido2);
              
                  if (count($valido2)>0) {
                    
                    return redirect()->route('errors.eliminacion');
                  } else {
                    $query_valido3="SELECT * from `reg_department` d
                    where d.id=$id";
                     $valido3 = DB::select($query_valido3);
                     $cadena="Nombre:".$valido3[0]->name." Descripción:".$valido3[0]->description;
                  
                     $user = Auth::user()->id;
                    $fecha_actual = new DateTime();
                    $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
                    DB::table('sis_log_deleted')->insert([
                      'description' => $cadena,
                      'modulo' => "departamento",
                      'user_id' => $user,
                      'datetime' => $fecha_actual,
                      ]);
                    DB::table('reg_department')->where('id', $id)->delete();
                    return redirect()->back()->with('status', 'delete');
                  }
                  
                }
             
         } catch (\Throwable $th) {
            dd ($th);
            return redirect()->back()->with('status', 'error');
            
        } 
    }
}
