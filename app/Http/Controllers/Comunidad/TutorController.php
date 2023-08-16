<?php

namespace App\Http\Controllers\Comunidad;
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
use Illuminate\Support\Facades\DB;
use Session;
use App\VacacionForm;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use Illuminate\Support\Facades\Hash;


class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
          $parentescoArray =array("1"=>"Padre","2"=>"Madre","3"=>"Tio","4"=>"Tia","5"=>"Abuelo","6"=>"Abuela","7"=>"Hemano","8"=>"Hermana","9"=>"Otros");
        if (Auth::user()->authorizePermisos(['Listar Comunidad', 'Ver'])) {
            $exito=99;
            $jsonDatos = json_encode($exito);
        
            $query_reg_types = 'SELECT * FROM `reg_types` ORDER BY id';
            $reg_types = DB::select($query_reg_types);
            $query_reg_branch = 'SELECT * FROM `reg_branch` where deleted=0 ORDER BY id' ;
            $reg_branch = DB::select($query_reg_branch);
        
            $query_reg_country = "SELECT * FROM `reg_country` ORDER BY id";
            $query_reg_city = "SELECT * FROM `reg_city` ORDER BY id";
            $reg_country = DB::select($query_reg_country);
            $reg_city = DB::select($query_reg_city);
           
            $idA=Auth::user()->id;
            
            $query_sucursal="SELECT u.id as idU, p.id as idP,id_branch  FROM `users` u JOIN `reg_people` p on u.id_people = p.id where u.id=$idA limit 1
            ";
            $sucursal = DB::select($query_sucursal);
        return view('configuracion.comunidad.createT',compact('reg_types','reg_branch','reg_country','reg_city','jsonDatos','sucursal','parentescoArray')); 
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

     
        if($request->zone == null || $request->street== null || $request->number == null|| $request->numberCell== null ){
            $mensajeError = 'Ocurrió un error al procesar la solicitud, revice los telefono o la dirección. Por favor, inténtalo de nuevo.';
            Session::flash('error', $mensajeError);
            return redirect()->back();
            exit;
          }
        
          
          try {
            $exito=0;
            $jsonDatos = json_encode($exito);
            $user = Auth::user()->id;
          
          $fecha_actual = new DateTime();
          $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
          if ($request->file('foto')) {
            $path = $request->file('foto')->store('images');
          } else {
            $path = NULL;
          }
       
         $data = $request->validate([
            'first_name' => 'required|max:255',
            'last_name1' => 'nullable',
            'last_name2' => 'nullable',
            'ci' => 'nullable|unique:reg_people',
            'fecha_nac' => 'nullable',
            'age' =>'nullable',
            'gender' => 'nullable',
            'nationality' => 'nullable',
         
            'branch'=> 'nullable',
            'city' => 'nullable',
            
          ]);
      
         $id_gente= DB::table('reg_people')->insertGetId([
            'first_name' => $data['first_name'],
            'last_name1' => $data['last_name1'],
            'last_name2' => $data['last_name2'],
            'ci' => $data['ci'],
            'age' => $data['age'],
            'birthdate' => $data['fecha_nac'],
            'gender' => $data['gender'],
            'nationality' => $data['nationality'],
            'created_user_id' => $user,
            'created_date' => $fecha_actual,
            'deleted' => 0,
            'foto' => $path,
            'id_tipo' => 1,
            'id_branch' => $data['branch'],
            'city' => $data['city'],
          ]);
          // Obtener el ID generado en la inserción en la tabla reg_people
          
         
              
          $streetFile=$request->zone;
          $numberFile=$request->numberCell;
          for ($i=0; $i <sizeof($streetFile) ; $i++) { 
            DB::table('reg_address')->insert([
              'zone' => $request->zone[$i],
              'street' => $request->street[$i],
              'number' => $request->number[$i],
              'created_user_id' => $user,
              'created_date' => $fecha_actual,
              'deleted' => 0,
              'id_people'=>$id_gente,
              'descripcion'=>$request->decriptionAddress[$i],
              ]);
          }
          for ($i=0; $i <sizeof($numberFile) ; $i++) {
            if($request->description[$i]==null){
                $des="sin datos";
            } else{
                $des=$request->description[$i];
            }
          if($request->numberCell[$i]==1010){
              $des="persona sin celular";
          } else{
            if ($request->numberCell[$i]==1000) {
              $des="menor de edad o estudiante";
            }else{
              $des=$request->description[$i];
            }
              
          }
            DB::table('reg_telephono')->insert([
              'number' => $request->numberCell[$i],
              'cod' => "+591",
              'description' => $des,
              'created_user_id' => $user,
              'created_date' => $fecha_actual,
              'deleted' => 0,
              'id_people'=>$id_gente,
              ]);
          }
          DB::table('reg_tutors')->insert([
          
          'parentesco' => $request->parentesco,
          'created_user_id' => $user,
          'created_date' => $fecha_actual,
          'deleted' => 0,
          'id_people'=>$id_gente,
          
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
     
        $user = Auth::user();
        if ($user->authorizePermisos(['Listar Comunidad', 'Ver']) && $user->authorizePermisos(['Listar Comunidad', 'Editar'])) {
          $parentescoArray =array("1"=>"Padre","2"=>"Madre","3"=>"Tio","4"=>"Tia","5"=>"Abuelo","6"=>"Abuela","7"=>"Hemano","8"=>"Hermana","9"=>"Otros");
      
          $fecha_actual = new DateTime(date('Y-m-d'));
                   
          $modulo = Modulo::get(); 
          $query_user = "SELECT p.id as idpersona, p.first_name as nombre, p.last_name1 as apeP, p.last_name2 as apeM, p.ci as CI, p.age as edad, p.birthdate as Fnacimiento,p.gender as genero, c.id as idPais, c.name as namePaid,foto,t.id as idTipo, t.name as nameT,
          b.id as idSucursal, b.name as nameSucm, cc.id as idCiudad, cc.name as nameCC  
          ,aa.id as idDir,aa.zone as zona, aa.street as calle, aa.number as numeroPuerta
                 FROM `reg_people` P 
                 
                 join `reg_types` t on t.id=p.id_tipo
           JOIN `reg_branch` b on p.id_branch=b.id
           JOIN `reg_country` c on p.nationality=c.id
           JOIN `reg_city` cc on p.city=cc.id
        
           JOIN `reg_address` aa on aa.id_people=p.id 
                 where  p.deleted=0 and p.id=$id
                 ORDER BY p.id
                 LIMIT 1
          " ;
           $userX = DB::select($query_user);
            
           $query_reg_types = 'SELECT * FROM `reg_types` ORDER BY id';
    $reg_types = DB::select($query_reg_types);
    $query_reg_branch = 'SELECT * FROM `reg_branch` where deleted=0 ORDER BY id' ;
    $reg_branch = DB::select($query_reg_branch);
    
    $query_reg_country = "SELECT * FROM `reg_country` ORDER BY id";
    $query_reg_city = "SELECT * FROM `reg_city` ORDER BY id";
    $reg_country = DB::select($query_reg_country);
    $reg_city = DB::select($query_reg_city);
    
          
    $query_telephono ="SELECT * FROM `reg_telephono` where id_people=$id";
    $query_address ="SELECT * FROM `reg_address` where id_people=$id";
    $reg_telephono = DB::select($query_telephono);
    $reg_address = DB::select($query_address);     
    $query_parentesco ="SELECT id,parentesco FROM `reg_tutors` where id_people=$id LIMIT 1
    ";       
       $reg_parentesco = DB::select($query_parentesco);  
          return view('configuracion.comunidad.editT',compact( 'reg_parentesco','modulo','reg_branch','reg_types','userX','reg_country','reg_city','reg_address','reg_telephono','parentescoArray'));
    
          //return view('configuracion.perfiles.edit', compact('reg_branch','reg_types','exito','userX'));
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
        if($request->zone == null || $request->street== null || $request->number == null || $request->numberCell== null ){
          $mensajeError = 'Ocurrió un error al procesar la solicitud, revice los telefono o la dirección. Por favor, inténtalo de nuevo.';
          Session::flash('error', $mensajeError);
          return redirect()->back();
          exit;
        }
      
        try {
          $exito=0;
          $jsonDatos = json_encode($exito);
          $user = Auth::user()->id;
        
        $fecha_actual = new DateTime();
        $fecha_actual=$fecha_actual->Format('Y-m-d H:m:s');
        if ($request->file('foto')) {
          $path = $request->file('foto')->store('images');
        } else {
          $path = NULL;
        }
        
       $data = $request->validate([
          'first_name' => 'required|max:255',
          'last_name1' => 'nullable',
          'last_name2' => 'nullable',
          
          'ci' => 'required|unique:reg_people,ci,' . $id,
          'fecha_nac' => 'nullable',
          'age' =>'nullable',
          'gender' => 'nullable',
          'nationality' => 'nullable',
          
          'branch'=> 'nullable',
          'city' => 'nullable',
          
        ]);
    
       $id_gente= 
       DB::table('reg_people')
       ->where('id',$id) 
       ->update([
        'first_name' => $data['first_name'],
          'last_name1' => $data['last_name1'],
          'last_name2' => $data['last_name2'],
          'ci' => $data['ci'],
          'age' => $data['age'],
          'birthdate' => $data['fecha_nac'],
          'gender' => $data['gender'],
          'nationality' => $data['nationality'],
          'modified_user' => $user,
          'modified_date' => $fecha_actual,
          'foto' => $path,
          'id_branch' => $data['branch'],
          'city' => $data['city'],
        ]);
            
        $streetFile=$request->zone;
       
        $numberFile=$request->numberCell;
        $ss="SELECT * FROM reg_address where id_people = $id";
        $ss2 = DB::select($ss);
      
        $iDarray=[];
        foreach ($ss2 as $key => $value) {
         array_push($iDarray,$value->id);
          
        }
        for ($i=0; $i <sizeof($iDarray) ; $i++) {
          if($request->description[$i]==null){
              $des="sin datos";
          } else{
              $des=$request->description[$i];
          }
        if($request->numberCell[$i]==1010){
            $des="persona sin celular";
        } else{
          if ($request->numberCell[$i]==1000) {
            $des="menor de edad o estudiante";
          }else{
            $des=$request->description[$i];
          }
            
        }
        
    
          DB::table('reg_telephono')
          ->where('id',$iDarray[$i]) 
          ->update([
            'number' => $request->numberCell[$i],
            'cod' => "+591",
            'description' => $des,
            'modified_user' => $user,
            'modified_date' => $fecha_actual,
            'id_people'=>$id,
            ]);
        }
        for ($i=0; $i <sizeof($iDarray) ; $i++) { 
          
        $RR = DB::table('reg_address')
          ->where('id',$iDarray[$i]) 
          ->update([
            'zone' => $request->zone[$i],
            'street' => $request->street[$i],
            'number' => $request->number[$i],
            'modified_user' => $user,
            'modified_date' => $fecha_actual,
            'id_people'=>$id,
            'descripcion'=>$request->decriptionAddress[$i],
            ]);
        }
        $ss="SELECT * FROM reg_telephono where id_people = $id";
        $ss2 = DB::select($ss);
      
        $iDarray=[];
        foreach ($ss2 as $key => $value) {
         array_push($iDarray,$value->id);
          
        }
        DB::table('reg_tutors')
          ->where('id_people',$id) 
          ->update([
            'parentesco' =>$request->parentesco,            
            'modified_user' => $user,
            'modified_date' => $fecha_actual,
        
            ]);
        
      
        $uu2=Auth::user()->id;
        $uu3=Auth::user()->number_modif;
      
        $usuario3 = User::find($uu2);
        $usuario3->number_modif=$uu3-1;
        $usuario3->save();
       
        return redirect()->back()->with('status', 'success');
      
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
        //
    }
}
