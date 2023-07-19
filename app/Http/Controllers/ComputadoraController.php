<?php

namespace App\Http\Controllers;

use App\Models\Computadora;
use App\Models\Componente;
use Illuminate\Http\Request;
use App\Perfil;

/**
 * Class ComputadoraController
 * @package App\Http\Controllers
 */
class ComputadoraController extends Controller
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
    $computadoras = Computadora::paginate();

    return view('computadora.index', compact('computadoras'))
      ->with('i', (request()->input('page', 1) - 1) * $computadoras->perPage());
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $computadora = new Computadora();
    return view('computadora.create', compact('computadora'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate(Computadora::$rules);
    Computadora::create($request->all());
    $idcpu = Computadora::latest('id')->first();
    
    if ($request['marca2'][0] != null) {
      foreach ($request->marca2 as $i => $j) {
        Componente::create(['tipo' => $request['tipo2'][$i], 'marca' => $request['marca2'][$i], 'modelo' => $request['modelo2'][$i], 'caracteristicas' => $request['caracteristicas2'][$i], 'estado' => $request['estado2'][$i], 'id_compu' => $idcpu['id']]);
      }
    }

    return redirect()->route('empleados.show', $request['id_empleado'])
      ->with('success', 'Computadora created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $computadora = Computadora::find($id);

    return view('computadora.show', compact('computadora'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $computadora = Computadora::find($id);

    return view('computadora.edit', compact('computadora'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  Computadora $computadora
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Computadora $computadora)
  {
    request()->validate(Computadora::$rules);

    $computadora->update($request->all());

    return redirect()->route('computadoras.index')
      ->with('success', 'Computadora updated successfully');
  }

  /**
   * @param int $id
   * @return \Illuminate\Http\RedirectResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $computadora = Computadora::find($id)->delete();

    return redirect()->route('computadoras.index')
      ->with('success', 'Computadora deleted successfully');
  }

  public function cambio(Request  $request, $id){
    echo $request;
    return dd($request);
  }
}
