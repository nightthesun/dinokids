<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Area;
use App\Models\Empleado;
use App\Models\Equipo;
use App\Models\Computadora;
use App\Models\Componente;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;

/**
 * Class EmpleadoController
 * @package App\Http\Controllers
 */
class EmpleadoController extends Controller
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
    $buscar = $request->get('buscar');
    $dato = $request->get('dato');
    $empleados = Perfil::orderBy('paterno', 'ASC')
      ->user($buscar, $dato)
      ->paginate(8);


    return view('empleado.index', compact('empleados'))
      ->with('i', (request()->input('page', 1) - 1) * $empleados->perPage());
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $empleado = new Empleado();
    return view('empleado.create', compact('empleado'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate(Empleado::$rules);
    $empleado = Empleado::create($request->all());

    return redirect()->route('equipos.creates', $empleado->id)
      ->with('success', 'Empleado created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $empleado = Perfil::find($id);
    $equipos = Equipo::orderBy('id', 'ASC')
      ->where('id_empleado', '=', $id)
      ->paginate(8);
    $count = $equipos->count();
    $todos = Perfil::paginate(50);
    $cpus = Computadora::orderBy('id', 'ASC')
      ->where('id_empleado', '=', $id)
      ->paginate(8);
    $cpucount = $cpus->count();
    if ($cpucount > 0) {
      $qr="Nombre: ". $empleado->nombre."\nTipo: ".$cpus[0]->tipo."\nIP: ".$cpus[0]->ip;
    } else {
      $qr = 'Null';
    }

    return view('empleado.show', compact('empleado', 'equipos', 'count', 'todos', 'cpus', 'cpucount', 'qr'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $empleado = Empleado::find($id);

    return view('empleado.edit', compact('empleado'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  Empleado $empleado
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Empleado $empleado)
  {
    $empleado->update($request->all());

    return redirect()->route('empleados.show', $empleado->id)
      ->with('success', 'Empleado updated successfully');
  }

  /**
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $empleado = Empleado::find($id)->delete();

    return redirect()->route('empleados.index')
      ->with('success', 'Empleado deleted successfully');
  }
}
