<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Historia;
use Illuminate\Http\Request;
use App\Perfil;

/**
 * Class EquipoController
 * @package App\Http\Controllers
 */
class EquipoController extends Controller
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
    $equipos = Equipo::paginate();

    return view('equipo.index', compact('equipos'))
      ->with('i', (request()->input('page', 1) - 1) * $equipos->perPage());
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $equipo = new Equipo();
    $empleados = Perfil::get();
    return view('equipo.create', compact('equipo', 'empleados'));
  }

  public function creates($id_empleado)
  {
    $equipo = new Equipo();
    return view('equipo.create', compact('equipo', 'id_empleado'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate(Equipo::$rules);
    $request->validate([
      'marca' => 'required',
      'tipo' => 'required',
      'modelo' => 'required',
      'ns' => 'required',
      'caracteristicas' => 'required',
      'estado' => 'required',
    ]);
    if ($request['marca'][0] != null) {
      foreach ($request->marca as $i => $j) {
        Equipo::create(['marca' => $request['marca'][$i], 'tipo' => $request['tipo'][$i], 'modelo' => $request['modelo'][$i], 'ns' => $request['ns'][$i], 'caracteristicas' => $request['caracteristicas'][$i], 'estado' => $request['estado'][$i], 'id_empleado' => $request['id_empleado'][$i]]);

        Historia::create(['marca' => $request['marca'][$i], 'tipo' => $request['tipo'][$i], 'modelo' => $request['modelo'][$i], 'ns' => $request['ns'][$i], 'caracteristicas' => $request['caracteristicas'][$i], 'estado' => $request['estado'][$i], 'id_empleado' => $request['id_empleado'][$i]]);
      }
    }

    return redirect()->
    route('empleados.show', $request->id_empleado)
      ->with('success', 'Equipo created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $equipo = Equipo::find($id);

    return view('equipo.show', compact('equipo'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $equipos = Equipo::find($id);

    return view('equipo.edit', compact('equipos'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  Equipo $equipo
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Equipo $equipo)
  {
    request()->validate(Equipo::$rules);
    $equipo->update($request->all());

    return redirect()->route('empleados.show', $equipo->id_empleado)
      ->with('success', 'Equipo updated successfully');
  }

  /**
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $empleado = Equipo::find($id);
    Equipo::find($id)->delete();

    return redirect()->route('empleados.show', $empleado->id_empleado)
      ->with('success', 'Equipo deleted successfully');
  }

  public function traspaso(Request $request, $id)
  {
    $empleado = Equipo::find($id);
    Equipo::create($request->all());
    Equipo::find($id)->delete();
    return redirect()->route('empleados.show', $empleado->id_empleado)
      ->with('success', 'Equipo deleted successfully');
  }
}
