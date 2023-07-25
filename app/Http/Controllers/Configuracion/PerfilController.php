<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Perfil;
use App\Permiso;
use Illuminate\Support\Facades\Storage;
use App\Unidad;
use DateTime;
use DB;
use App\VacacionForm;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class PerfilController extends Controller
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
    if (Auth::user()->authorizePermisos(['Funcionarios', 'Ver'])) {
      $user = Auth::user();
      $perfil = Perfil::orderBy('id', 'DESC')
        ->get();
      return view('configuracion.perfiles.index', compact('perfil'));
    } else {
      return dd('largo de aqui');
    }
  }

  /**
   * Show the form for creating a new resource.
    * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $exito=99;
    $jsonDatos = json_encode($exito);

    $query_reg_types = 'SELECT * FROM `reg_types` ORDER BY id';
    $reg_types =DB::select($query_reg_types);
    //DB::connection('mysql')->select(DB::raw($query_reg_types));
    //dd($reg_types);
 
  return view('configuracion.perfiles.create', compact('reg_types','jsonDatos'));
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
      'ci' => 'nullable|unique:perfils',
      'fecha_nac' => 'nullable',
      'age' =>'nullable',
      'address' => 'nullable',
      'corp_celu' => 'nullable',
      'gender' => 'nullable',
      'nationality' => 'nullable',
      'type' => 'nullable',
      
    ]);
   $id_gente= DB::table('reg_people')->insertGetId([
      'first_name' => $data['first_name'],
      'last_name1' => $data['last_name1'],
      'last_name2' => $data['last_name2'],
      'ci' => $data['ci'],
      'age' => $data['age'],
      'birthdate' => $data['fecha_nac'],
      'address' => $data['address'],
      'gender' => $data['age'],
      'nationality' => $data['nationality'],
      'created_user_id' => $user,
      'created_date' => $fecha_actual,
      'deleted' => 0,
      'foto' => $path,
      'id_tipo' => $data['type'],
    ]);
    // Obtener el ID generado en la inserción en la tabla reg_people
    
    DB::table('reg_telephono')->insert([
      'number' => $data['corp_celu'],
      'cod' => "+591",
      'created_user_id' => $user,
      'created_date' => $fecha_actual,
      'deleted' => 0,
      'id_people'=>$id_gente,
    ]);
    
    $perfil = Perfil::create(
      $data += ['foto' => $path]
    );
    //return view('configuracion.perfiles.create', compact('jsonDatos'));
    //return redirect()->route('perfil.create')->with('jsonDatos',$jsonDatos);
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
    $exito="99";
    
    $user = Auth::user();
    if ($user->authorizePermisos(['Usuarios', 'Ver'])) {
      $fecha_ingreso = new DateTime(Perfil::find($id)->fecha_ingreso);
      $fecha_actual = new DateTime(date('Y-m-d'));
   
     
      $query_cargos = 'SELECT * FROM `cargos` ORDER BY NombreCargo';
     // $perfilesX='SELECT * FROM `perfiles` ORDER BY nombre';
      $cargos = DB::select($query_cargos);
      $perfil = Perfil::find($id);
     // $perfilesX2=DB::select($perfilesX);

      // dd($query_tomados);
      return view('configuracion.perfiles.edit', compact('perfil','cargos','exito'));
    } else {
      return dd('largo de aqui');
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
      $exito=0;
      
      $fecha_actual = new DateTime(date('Y-m-d'));
      $perfil = Perfil::find($id);
      
      $data = $request->validate([
        'nombre' => 'required|max:255',
        'paterno' => 'required',
        'materno' => 'required',
        'fecha_nac' => 'nullable',
        'ci' => 'required|unique:perfils,ci,' . $id,
        'ci_e' => 'required',
        'cargo' => 'nullable',
        'corp_telf' => 'nullable',
        'corp_int' => 'nullable',
        'corp_email' => 'nullable|unique:perfils,corp_email,' . $id,
        'area_id' => 'required',
        'corp_celu' => 'nullable',
        'fecha_ingreso' => 'nullable',
        'dias_vacacion' => 'nullable',
        'telf' => 'nullable',
        'direc' => 'nullable',
        'celu' => 'nullable',
        'unidad_id' => 'required',
        'email' => 'nullable|unique:perfils,email,' . $id,
      ]);
      
       
  
      if ($request->check_f == 'true') {
        Storage::delete($perfil->foto);
        $path = $request->file('foto')->store('images');
        $perfil->foto = $path;
        $perfil->save();
      } elseif ($request->check_f == 'false') {
        Storage::delete($perfil->foto);
        $perfil->foto = NULL;
        $perfil->save();
      }
      $perfil->update($request->except(['foto']));
      //return redirect()->back()->with('success', 'Datos actualizados correctamente.')->with($exito);
     return redirect()->route('perfil.index');
    } catch (\Throwable $th) {
      $exito=1;
      return redirect()->back()->with('error', 'Ha ocurrido un error al procesar los datos. Por favor, inténtelo nuevamente.')->withInput();
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
