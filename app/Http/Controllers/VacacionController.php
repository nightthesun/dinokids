<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\VacacionForm;
use App\FirmaVacacion;
use App\Perfil;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use DB;
use Illuminate\Foundation\Auth\User;

class VacacionController extends Controller
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
  public function index(Request $request)
  {
    $user = Auth::user();
    $estado = $request->get('estado');
    $buscar = $request->get('buscar');
    $dato = $request->get('dato');
    if (Auth::user()->tienePermiso(18, 4)) {
      $forms = VacacionForm::orderBy('id', 'DESC')
        ->estado($estado)
        ->user($buscar, $dato)
        ->paginate(8);
      return view('vacaciones_forms', compact('forms'));
    } else {
      $forms = VacacionForm::orderby('id', 'DESC')
        ->where('user_id', '=', Auth::user()->id)
        ->estado($estado)
        ->paginate(8);
      return view('vacaciones_forms', compact('forms'));
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $fecha_ingreso = new DateTime(Auth::user()->perfiles->fecha_ingreso);
    $fecha_actual = new DateTime(date('Y-m-d'));
    $diff = $fecha_ingreso->diff($fecha_actual)->days;
    $dias_vacaciones = intval($diff / 366) * 15;
    $query_tomados = 'SELECT ((SELECT CASE WHEN SUM(dias) IS null THEN 0 ELSE SUM(dias) END FROM vacacion_forms WHERE user_id = ' . Auth::user()->id . ' AND estado = "Aceptada") +
    (SELECT CASE WHEN SUM(dias) IS null THEN 0 ELSE SUM(dias) END FROM licencia_forms WHERE user_id = ' . Auth::user()->id . ' AND estado = "Aceptada")) as suma';
    $dias_tomados = DB::select($query_tomados);
    return view("forms.vacaciones", compact('dias_vacaciones', 'dias_tomados'));
  }

  public function estadoForm(Request $request,$id)
  {
    $VacacionForm = VacacionForm::find($id);
    // dd($VacacionForm->user->perfiles->nombre);
    $fecha_ingreso = new DateTime($VacacionForm->user->perfiles->fecha_ingreso);
    $fecha_actual = new DateTime(date('Y-m-d'));
    $diff = $fecha_ingreso->diff($fecha_actual)->days;
    $dias_vacaciones = intval($diff / 366) * 15;
    $query_tomados = 'SELECT ((SELECT CASE WHEN SUM(dias) IS null THEN 0 ELSE SUM(dias) END FROM vacacion_forms WHERE user_id = ' . $VacacionForm->user_id . ' AND estado = "Aceptada") +
    (SELECT CASE WHEN SUM(dias) IS null THEN 0 ELSE SUM(dias) END FROM licencia_forms WHERE user_id = ' .   $VacacionForm->user_id . ' AND estado = "Aceptada")) as suma';
    $dias_tomados = DB::select($query_tomados);

    $validador=$request->get('estado');
    if ($validador=="Aceptada") {
      $var1=$request->get('saldo_dias11');
      $var4=$request->get('ci');
      DB::table('perfils')
      ->where('ci', $var4)
      ->update(['dias_vacacion' => $var1]);
    } 

    return view('forms.vacaciones_detalle', compact('dias_vacaciones', 'dias_tomados'))->with('VacacionForm', $VacacionForm);
  }

  public function estado(Request $request, $id)
  {
    $vacacion = VacacionForm::find($id);
    $vacacion->fecha_ini_aut = $request->get('fecha_ini_aut');
    $vacacion->fecha_fin_aut = $request->get('fecha_fin_aut');
    $vacacion->fecha_ret_aut = $request->get('fecha_ret_aut');
    $vacacion->dias_v = $request->get('dias_v');
    $vacacion->dias_v_l = $request->get('dias_v_l');
    if ($vacacion->dias = $request->get('dias') != 'NaN') {
      $vacacion->dias = $request->get('dias');
      $vacacion->dias_l = $request->get('dias_l');
    } else {
      $vacacion->dias = 0;
      $vacacion->dias_l = 'CERO';
    }
    if ($request->get('saldo_dias') != 'NaN') {
      $vacacion->saldo_dias = $request->get('saldo_dias');
      $vacacion->saldo_dias_l = $request->get('saldo_dias_l');
    } else {
      $vacacion->saldo_dias = '0';
      $vacacion->saldo_dias_l = 'CERO';
    }
    $vacacion->estado = $request->get('estado');
    $vacacion->detalle_estado = $request->get('detalle_estado');
    $vacacion->admin_id = Auth::user()->id;
    $vacacion->save();

    return redirect()->route('vacacion.index');
  }

  public function listado()
  {
    $user = Auth::user();
    $forms = VacacionForm::orderBy('id', 'DESC')
    ->paginate(8);
    // if (Auth::user()->tienePermiso(18, 4)) {
    //   return view('vacaciones_forms', compact('forms'));
    // }
    return view('forms.listadoVacacion', compact('forms'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $vaca = VacacionForm::create([
      'detalle_vacacion' => $request->detalle_vacacion,
      'fecha_ini' => $request->fecha_ini,
      'fecha_fin' => $request->fecha_fin,
      'fecha_ret' => $request->fecha_ret,
      'dias_v' => $request->dias_v,
      'dias_v_l' => $request->dias_v_l,
      'dias' => $request->dias,
      'dias_l' => $request->dias_l,
      'saldo_dias' => $request->saldo_dias,
      'saldo_dias_l' => $request->saldo_dias_l,
      'jefe_id' => $request->jefe,

      'user_id' => Auth::user()->id,
    ]);
    return redirect()->route('vacaciones.index')->with('success', 'El formulario se envio correctamente');
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
    $form = VacacionForm::find($id);
    $firma = $form->firmas->where('tipo', 'Superior')->last();
    $firma_rrhh = $form->firmas->where('tipo', 'RRHH')->last();
    return view('detalle.vacaciones', compact('form', 'firma', 'firma_rrhh'));
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
    $form = VacacionForm::find($id);
    $user = Auth::user();
    if ($user->authorizepermisos(['auth_rrhh_vacacion_form'])) {
      if ($request->aceptadorrhh) {
        $firma = FirmaVacacion::create([
          'user_id' => $user->id,
          'tipo' => 'RRHH',
          'estado' => 'ACEPTADO',
          'obs' => $request->obs_a_rrhh,
        ]);
        $form->firmas()->save($firma);
      }
      if ($request->rechazadorrhh) {
        /*$error=$request->validate([
                    'obs' => 'required|max:255',
                ]);*/
        $firma = FirmaVacacion::create([
          'user_id' => $user->id,
          'tipo' => 'RRHH',
          'estado' => 'RECHAZADO',
          'obs' => $request->obs_r_rrhh,
        ]);
        $form->firmas()->save($firma);
      }
    }
    if ($user->authorizepermisos(['auth_vacacion_form'])) {
      if ($request->aceptado) {
        $firma = FirmaVacacion::create([
          'user_id' => $user->id,
          'tipo' => 'Superior',
          'estado' => 'ACEPTADO',
          'obs' => $request->obs_a,
        ]);
        $form->firmas()->save($firma);
      }
      if ($request->rechazado) {
        /*$error=$request->validate([
                    'obs' => 'required|max:255',
                ]);*/
        $firma = FirmaVacacion::create([
          'user_id' => $user->id,
          'tipo' => 'Superior',
          'estado' => 'RECHAZADO',
          'obs' => $request->obs_r,
        ]);
        $form->firmas()->save($firma);
      }
    }

    return redirect()->route('vacacion.index')->with('success', 'El formulario se envio correctamente');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $formulario = VacacionForm::find($id);
    $formulario->delete();
    return redirect()->route('vacacion.index');
  }

  public function generatePDF($id)
  {
    $VacacionForm = VacacionForm::find($id);
    // dd($VacacionForm->admin->perfiles->nombre);
    $pdf = PDF::loadView('vacacion_pdf', compact('VacacionForm'));
    return $pdf->stream('prueba.pdf');
  }
}
