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
use Illuminate\Support\Str;


class TutorprincipalController extends Controller
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
        if (Auth::user()->authorizePermisos(['Relacion', 'Ver'])) {
            $parentescoArray =array("1"=>"Padre","2"=>"Madre","3"=>"Tio","4"=>"Tia","5"=>"Abuelo","6"=>"Abuela","7"=>"Hemano","8"=>"Hermana","9"=>"Otros");
            $query_reg_tutor_principals = 'SELECT tp.observatio as observation,tp.id as idRe,tp.relationship,p.first_name,tp.deleted as del_relacion, p.deleted as del_pero
            FROM `reg_tutor_principals` tp
            left join `reg_people` p on p.id=tp.id_tutor
             
            where tp.deleted=0 and p.deleted=0 
            ORDER BY tp.id';
               $reg_tutor_principals = DB::select($query_reg_tutor_principals);
         
                $user = Auth::user();
         
                $usuario=User::orderBy('id','DESC')->get();
                return view('configuracion.comunidad.indexRelacion',compact('usuario','user','reg_tutor_principals'));  
          
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
        if (Auth::user()->authorizePermisos(['Relacion', 'Crear'])) {
            $parentescoArray =array("1"=>"Padre","2"=>"Madre","3"=>"Tio","4"=>"Tia","5"=>"Abuelo","6"=>"Abuela","7"=>"Hemano","8"=>"Hermana","9"=>"Otros");
            $randomString = Str::random(5);
            $query_reg_students = "SELECT s.id as id_student, s.deleted as del_student, s.id_people, s.id_academic_degree, p.first_name,p.last_name1,p.last_name2,p.ci,p.ci, p.age,p.birthdate,p.gender,p.deleted as del_person, ad.name as grado  FROM `reg_students` s
            join `reg_people` p on s.id_people=p.id 
            left join  `reg_academic_degree` ad on s.id_academic_degree=ad.id
            where s.deleted = 0 and p.deleted = 0
            ORDER BY s.id desc    
            " ;
            $query_reg_tutors = "SELECT t.id as id_tutor, t.parentesco, t.deleted as del_tutor, p.first_name,p.last_name1,p.last_name2,p.ci, p.age,p.birthdate,p.gender,p.deleted as del_person,t.id_people
            FROM `reg_tutors` t
           join `reg_people` p on t.id_people=p.id 
           where t.deleted = 0 and p.deleted = 0
           ORDER BY t.id desc 
            " ;
            $reg_students = DB::select($query_reg_students);
            $reg_tutors = DB::select($query_reg_tutors);
            return view('configuracion.comunidad.createRR', compact('randomString','reg_students','reg_tutors','parentescoArray'));
        } else {
            return redirect()->route('errors.permisos');
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
               
        if (sizeof($request->tutor)>3 || sizeof($request->tutor)<3){
            return redirect()->back()->with('status', 'error1');
         }
         if (empty($request->tutor)) {
            return redirect()->back()->with('status', 'error2');
         }
         if (empty($request->estudiante)) {
            return redirect()->back()->with('status', 'error3');
         }
         if ($request->principal==null) {
            return redirect()->back()->with('status', 'error4');
         }
         $validador="no";
        for ($i=0; $i <sizeof($request->tutor) ; $i++) { 
            if($request->principal==$request->tutor[$i]){
                $validador="si";
            }       
        }
        if ($validador=="no") {
            return redirect()->back()->with('status', 'error5');
        } 
        $user = Auth::user()->id;
          
          $fecha_actual = new DateTime();
          $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
        $randomString1 = Str::random(7);
        $randomString2 = Str::random(8);
        $cod= $randomString1.$request->principal.$randomString2;
       $codRepetido="SELECT * from reg_tutor_students where cod='$cod' 
       "; 
        $repetido = DB::select($codRepetido);
        if (empty($repetido)) {
            for ($i=0; $i < sizeof($request->estudiante); $i++) { 
                for ($j=0; $j <sizeof($request->tutor) ; $j++) { 
                 DB::table('reg_tutor_students')->insert([
                'id_tutor' => $request->tutor[$j],
                'id_student' => $request->estudiante[$i],
                'cod' => $cod,
                ]);       
                }
            
            }
            DB::table('reg_tutor_principals')->insert([
                'relationship' => $cod,
                'created_user_id' => $user,
                'created_date' => $fecha_actual,
                'deleted' => 0,
                'id_tutor' => $request->principal,
                ]);  
                
            return redirect()->back()->with('status', 'success');    
        } else {
            return redirect()->back()->with('status', 'error6');
        }
        
        } catch (\Throwable $th) {
            
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
        
        if (Auth::user()->authorizePermisos(['Relacion', 'Ver'])) {
        
            $query_reg_relacion = " SELECT tp.id,tp.relationship,tp.observatio,tp.previous_tuto,u.name as creaU,
            uu.name as editU,uuu.name as delU,tp.created_date as dateC,tp.modified_date as dateM,
            tp.created_date as dateD,t.parentesco, pp.first_name, pp.last_name1,pp.last_name2 
            FROM `reg_tutor_principals` tp 
          left join `reg_tutor_students` ts on tp.relationship = ts.cod
          left join `reg_tutors` t on ts.id_tutor = t.id_people
          left join `reg_people` pp on t.id_people = pp.id
          left join  `users` u on u.id =tp.created_user_id
            left join `users` uu on  tp.modified_user=uu.id	
          left join `users` uuu on  tp.deleted_user_id=uuu.id
          where tp.id='$id'";

           $query_reg_tutor = "SELECT  tp.relationship,pp.first_name,pp.last_name1,pp.last_name2
           FROM `reg_tutor_principals` tp
           join `reg_people` pp on tp.id_tutor = pp.id 
           where tp.id='$id'
           limit 1";
         
          $query_reg_estudiante = "SELECT DISTINCT tp.relationship, ppp.first_name, ppp.last_name1, ppp.last_name2
          FROM reg_tutor_principals tp
          LEFT JOIN reg_tutor_students ts ON tp.relationship = ts.cod
          LEFT JOIN reg_students s ON ts.id_student = s.id
          LEFT JOIN reg_people ppp ON s.id_people = ppp.id
          where tp.id='$id'";
         
           $relacion = DB::select($query_reg_relacion);
           $tutor = DB::select($query_reg_tutor);
           $estudiante = DB::select($query_reg_estudiante);
           
                $user = Auth::user();
                  
                $usuario=User::orderBy('id','DESC')->get();
          return view('configuracion.comunidad.showRR',compact('usuario','user','relacion','tutor','estudiante'));  
          
        } else {
          return redirect()->route('errors.permisos');
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
        if (Auth::user()->authorizePermisos(['Relacion', 'Editar'])) {
            $query_reg_tutor_principalsEdit="SELECT tp.observatio as observation, tp.id as idRR,tp.relationship, tp.observatio, tp.previous_tuto, tp.id_tutor as id_Principal,ts.id_tutor,ts.id_student,
            pp.first_name as nomT, pp.last_name1 as apellidoPT, pp.last_name2 as apellidoMT,pp.ci as ciT,
            t.parentesco,s.id as idE, ppp.first_name as nomE, ppp.last_name1 as apellidoPE, 
            ppp.last_name2 as apellidoME, ppp.age as edad
            
              FROM `reg_tutor_principals` tp 
            left join `reg_tutor_students` ts on tp.relationship = ts.cod
            left join `reg_tutors` t on ts.id_tutor = t.id_people
            left join `reg_people` pp on t.id_people = pp.id
            left join  `users` u on u.id =tp.created_user_id
              left join `users` uu on  tp.modified_user=uu.id	
            left join `users` uuu on  tp.deleted_user_id=uuu.id
            left join `reg_students` s on ts.id_student = s.id
            left join `reg_people` ppp on s.id_people = ppp.id
            
            where tp.id=$id    
            ";
            $query_id_student="SELECT 
            DISTINCT s.id,p.id as idP,p.first_name,p.last_name1,p.last_name2  FROM `reg_tutor_students`st  
            left join `reg_tutor_principals` tp on st.cod= tp.relationship
            left join `reg_students` s on s.id=id_student
            left join	`reg_people` p on s.id_people=p.id
            where tp.id=$id    
            "; 
            $id_students = DB::select($query_id_student);


            $query_id_tutor="SELECT 
            p.first_name ,p.last_name1,p.last_name2, pp.first_name as first_nameP,
       pp.last_name1 as last_name1P, pp.last_name2 as last_name2P
             FROM `reg_tutor_students`st  
            left join `reg_tutor_principals` tp on st.cod= tp.relationship
            left join `reg_tutors` s on s.id_people=tp.id_tutor
            left join	`reg_people` p on st.id_tutor=p.id
            left join `reg_people` pp on tp.id_tutor=pp.id
            where tp.id=$id    
            "; 
            $id_tutors = DB::select($query_id_tutor);


            $tamañoT=sizeof($id_tutors);

            $tamañoE=sizeof($id_students);
            


            $parentescoArray =array("1"=>"Padre","2"=>"Madre","3"=>"Tio","4"=>"Tia","5"=>"Abuelo","6"=>"Abuela","7"=>"Hemano","8"=>"Hermana","9"=>"Otros");
            $randomString = Str::random(5);
            $query_reg_students = "SELECT s.id as id_student, s.deleted as del_student, s.id_people, s.id_academic_degree, p.first_name,p.last_name1,p.last_name2,p.ci,p.ci, p.age,p.birthdate,p.gender,p.deleted as del_person, ad.name as grado  FROM `reg_students` s
            join `reg_people` p on s.id_people=p.id 
            left join  `reg_academic_degree` ad on s.id_academic_degree=ad.id
            where s.deleted = 0 and p.deleted = 0
            ORDER BY s.id desc    
            " ;
            $query_reg_tutors = "SELECT t.id as id_tutor, t.parentesco, t.deleted as del_tutor, p.first_name,p.last_name1,p.last_name2,p.ci, p.age,p.birthdate,p.gender,p.deleted as del_person,t.id_people
            FROM `reg_tutors` t
           join `reg_people` p on t.id_people=p.id 
           where t.deleted = 0 and p.deleted = 0
           ORDER BY t.id desc 
            " ;
            $reg_students = DB::select($query_reg_students);
            $reg_tutors = DB::select($query_reg_tutors);
            $principalsEdit = DB::select($query_reg_tutor_principalsEdit);
            return view('configuracion.comunidad.editRR', compact('randomString','reg_students','reg_tutors','parentescoArray','principalsEdit','tamañoE','id_students','id_tutors','tamañoT'));
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
        if (Auth::user()->authorizePermisos(['Relacion', 'Editar'])) {
            try {
               
                if (sizeof($request->tutor)>3 || sizeof($request->tutor)<3){
                    return redirect()->back()->with('status', 'error1');
                 }
                 if (empty($request->tutor)) {
                    return redirect()->back()->with('status', 'error2');
                 }
                 if (empty($request->estudiante)) {
                    return redirect()->back()->with('status', 'error3');
                 }
                 if ($request->principal==null) {
                    return redirect()->back()->with('status', 'error4');
                 }
                 $validador="no";
                for ($i=0; $i <sizeof($request->tutor) ; $i++) { 
                    if($request->principal==$request->tutor[$i]){
                        $validador="si";
                    }       
                }
                if ($validador=="no") {
                    return redirect()->back()->with('status', 'error5');
                } 
                $user = Auth::user()->id;
                  
                  $fecha_actual = new DateTime();
                  $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
                
                    $query="SELECT relationship,id_tutor from `reg_tutor_principals` where id=$id;
                    ";
                    $reg= DB::select($query);
                    $codi=strval($reg[0]->relationship);
                    $queryTS="SELECT id from `reg_tutor_students` where cod='$codi'
                    ";
                    $regTS= DB::select($queryTS);
                  
                                     
                    for ($i=0; $i < sizeof($request->estudiante); $i++) { 
                        for ($j=0; $j <sizeof($request->tutor) ; $j++) { 
                            DB::table('reg_tutor_students')
                            ->where('id',$regTS[$j]->id)
                            ->update([
                        'id_tutor' => $request->tutor[$j],
                        'id_student' => $request->estudiante[$i],
                      
                        ]);       
                        }
                    
                    }
                    DB::table('reg_tutor_principals')
                            ->where('id',$id)
                            ->update([
                                'observatio' => $request->observacion,
                                             
                        'modified_user' => $user,
                        'modified_date' => $fecha_actual,
                     
                        'id_tutor' => $request->principal,
                        ]);  
                        
                    return redirect()->back()->with('status', 'success');    
               
                
                } catch (\Throwable $th) {
                    dd($th);
                    return redirect()->back()->with('status', 'error');
                }
        }else{
            return redirect()->route('errors.permisos');
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
        
        if (Auth::user()->authorizePermisos(['Relacion', 'Eliminar'])) {
            try {
                dd("Procesando...");
               
             } catch (\Throwable $th) {
                dd ($th);
                return redirect()->back()->with('status', 'error');
                
            } 
        }else{
            return redirect()->route('errors.permisos');
    }
        
    }
}
