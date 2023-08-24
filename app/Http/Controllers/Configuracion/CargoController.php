<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;


class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try {
        if (Auth::user()->authorizePermisos(['Cargo', 'Ver'])) {
            $user = Auth::user();

            $usuario=User::orderBy('id','DESC')->get();
            $query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad,d.name as nameD 
            from `reg_cargos` c
            join `reg_department` d on c.id_department=d.id where d.deleted=0 
                ";
            $cargo = DB::select($query_reg_cargo); 
            return view('configuracion.cargo.index',compact('usuario','user','cargo'));  
      
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
        if (Auth::user()->authorizePermisos(['Cargo', 'Crear'])) {
            $unidad=array("1"=>"Bs.","2"=>"$.","3"=>"€","4"=>"¥");
            $query_reg_department="SELECT d.id,d.name from `reg_department` d";
            $reg_department = DB::select($query_reg_department);
          
               return view('configuracion.cargo.create', compact('unidad','reg_department')); 
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
                'salary' => 'nullable',
                'unidad' => 'nullable',
                'department' => 'nullable',
              ]);
          
             DB::table('reg_cargos')->insertGetId([
                'name' => $data['name'],
                'description' => $data['descripcion'],
                'created_user_id' => $user,
                'created_date' => $fecha_actual,
                'deleted' => 0,
                'salary' => $data['salary'],
                'id_department' => $data['department'],
                'unidad' => $data['unidad'],
              ]);
              // Obtener el ID generado en la inserción en la tabla reg_people
              $cadena="Nombre:".$data['name']." Descripción:".$data['descripcion'];
                  
              DB::table('sis_log_created')->insert([
                'description' => $cadena,
                'modulo' => "cargo",
                'user_id' => $user,
                'datetime' => $fecha_actual,
                ]);
              
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
        if (Auth::user()->authorizePermisos(['Cargo', 'Editar'])) {
                      
            $query_reg_cargo="SELECT c.id,c.name,c.description,c.salary,c.unidad,d.name as nameD 
            from `reg_cargos` c
            join `reg_department` d on c.id_department=d.id where c.id='$id' 
            limit 1";
           $query_reg_department="SELECT d.id,d.name from `reg_department` d";
           $reg_department = DB::select($query_reg_department);
            $cargo = DB::select($query_reg_cargo); 
                $user = Auth::user(); 
                $unidad=array("1"=>"Bs.","2"=>"$.","3"=>"€","4"=>"¥");   
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.cargo.edit',compact('usuario','user','cargo','unidad','reg_department'));  
          
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
                'salary' => 'nullable',
                'unidad' => 'nullable',
                'department' => 'nullable',
              ]);
              
          DB::table('reg_cargos')
           ->where('id',$id) 
           ->update([
            'name' => $data['name'],
            'description' => $data['descripcion'],
            'modified_user' => $user,
            'modified_date' => $fecha_actual,
            'salary' => $data['salary'],
            'id_department' => $data['department'],
            'unidad'=>$data['unidad'],
            
          ]);
          $cadena="Nombre:".$data['name']." Descripción:".$data['descripcion'];
                  
          DB::table('sis_log_modified')->insert([
            'description' => $cadena,
            'modulo' => "cargos",
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
        dd("encontrucción..");
    }
}
