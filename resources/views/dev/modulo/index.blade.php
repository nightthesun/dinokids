@extends('layouts.app')
@section('title', 'Inicio')
@section('content') 
    <div class="container-fluid m-3 ancho_container"> 
          <div class="row pb-3">
            <div class="col"><h3>MODULOS <a href="{{ route('modulo.create') }}" >+</a></h3></div>
          </div>
          <div class="row col">
          <div class="table-responsive">
            <table class="cell-border compact hover" id="modulo" style="width:100%">
             <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                @if(Auth::user()->authorizepermisos(['Usuarios','Editar'])) 
                <th>Opciones</th>
                @endif
             </thead>
             <tbody>
              @if($modulo->count())
              @foreach($modulo as $mod)
              <tr>
                <td>{{$mod->id}}</td>
                <td>{{$mod->nombre}}</td>
                <td>{{$mod->desc}}</td>
                @if(Auth::user()->authorizepermisos(['Usuarios', 'Ver'])) 
                  <td>                  
                    <a class="btn btn-primary btn-sm" href="{{route('modulo.edit', $mod->id)}}" >
                      <span class="glyphicon glyphicon-pencil">Detalle</span>
                    </a>
                  </td>
                @endif
               </tr>
               @endforeach
               @else
               <tr>
                <td>No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>  
        </div>
        <div class="row mt-4 pb-3">
            <div class="col"><h3>SUBMODULOS <a href="{{ route('submodulo.create') }}" >+</a></h3></div>
        </div>
        <div class= "row col ">
        <div class="table-responsive">
            <table class="cell-border compact hover" id="submodulo" style="width:100%">
             <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Modulo</th>
                @if(Auth::user()->authorizepermisos(['Usuarios','Editar'])) 
                <th>Opciones</th>
                @endif
             </thead>
             <tbody>
              @if($submodulo->count())
              @foreach($submodulo as $smod)
              <tr>
                <td>{{$smod->id}}</td>
                <td>{{$smod->nombre}}</td>
                <td>{{$smod->desc}}</td>
                <td>{{$smod->modulo_id}}.- {{$smod->modulos->nombre}}</td>
                @if(Auth::user()->authorizepermisos(['Usuarios', 'Ver'])) 
                  <td>                  
                      <a class="btn btn-primary btn-sm" href="{{route('modulo.edit', $smod->id)}}" >
                        <span class="glyphicon glyphicon-pencil">Detalle</span>
                      </a>                      
                  </td>
                 @endif
               </tr>
               @endforeach
               @else
               <tr>
                <td>No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        </div>

        <div class="row mt-4 pb-3">
            <div class="col"><h3>PROGRAMA<a href="" >+</a></h3></div>
        </div>
        <div class= "row col ">
        <div class="table-responsive">
            <table class="cell-border compact hover" id="program" style="width:100%">
             <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Modulo</th>
                <th>Submodulo</th>
                <th>Ruta</th>
                @if(Auth::user()->authorizepermisos(['Usuarios','Editar'])) 
                <th>Opciones</th>
                @endif
             </thead>
             <tbody>
              @if($program->count())
              @foreach($program as $prog)
              <tr>
                <td>{{$prog->id}}</td>
                <td>{{$prog->nombre}}</td>
                <td>{{$prog->desc}}</td>
                <td>{{$prog->modulo_id}}.- {{$prog->modulos->nombre}}</td>
                
                <td>@if($prog->sub_modulo_id){{$prog->sub_modulo_id}}.- {{$prog->submodulos->nombre}}@endif</td>
                <td>{{$prog->route}}</td>
                @if(Auth::user()->authorizepermisos(['Usuarios', 'Ver'])) 
                  <td>                  
                      <a class="btn btn-primary btn-sm" href="{{route('modulo.edit', $prog->id)}}" >
                        <span class="glyphicon glyphicon-pencil">Detalle</span>
                      </a>                      
                  </td>
                 @endif
               </tr>
               @endforeach
               @else
               <tr>
                <td>No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        </div>

        <div class="row mt-4 pb-3">
            <div class="col"><h3>PERMISOS <a href="{{ route('permiso.create') }}" >+</a></h3></div>
          </div>
        <div class= "row col ">
        <div class="table-responsive">
            <table class="cell-border compact hover" id="permiso" style="width:100%">
             <thead>
                <th>Id</th>
                <th>Permiso</th>
                <th>Descripcion</th>
                <th>Programa</th>
                @if(Auth::user()->authorizepermisos(['Usuarios','Editar'])) 
                <th>Opciones</th>
                @endif
             </thead>
             <tbody>
              @if($permiso->count())
              @foreach($permiso as $perm)
              <tr>
                <td>{{$perm->id}}</td>
                <td>{{$perm->p}}</td>
                <td>{{$perm->desc}}</td>
                <td>@foreach($perm->programs as $per) {{$per->nombre}} |@endforeach</td>
                @if(Auth::user()->authorizepermisos(['Usuarios', 'Ver'])) 
                  <td>                  
                      <a class="btn btn-primary btn-sm" href="{{route('modulo.edit', $perm->id)}}" >
                        <span class="glyphicon glyphicon-pencil">Detalle</span>
                      </a>                      
                  </td>
                 @endif
               </tr>
               @endforeach
               @else
               <tr>
                <td>No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        </div>
    </div>          
@endsection
@section('mis_scripts')
<script>
$(document).ready(function() 
{  
    var height = screen.height-450+'px';
    $('#modulo').DataTable( 
    {
        "language":             
        {
            "emptyTable":     "Tabla Vacia",
            "info":           "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran del 0 al 0 de 0 Registros",
            "infoFiltered":   "(Filtrado de un total de _MAX_ registros)",
            "lengthMenu":     "Se muestran _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontro ningun registro",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "columnDefs": [
            { width:"15%", "targets": 2 }
        ],
        "pageLength": 25,
        "scrollX":true,
        "scrollY": height,
        "scrollCollapse": true, 
    } );

    $('#submodulo').DataTable( 
    {
        "language":             
        {
            "emptyTable":     "Tabla Vacia",
            "info":           "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran del 0 al 0 de 0 Registros",
            "infoFiltered":   "(Filtrado de un total de _MAX_ registros)",
            "lengthMenu":     "Se muestran _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontro ningun registro",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "columnDefs": [
            { width:"15%", "targets": 2 }
        ],
        "pageLength": 25,
        "scrollX":true,
        "scrollY": height,
        "scrollCollapse": true, 
    } );

    $('#permiso').DataTable( 
    {
        "language":             
        {
            "emptyTable":     "Tabla Vacia",
            "info":           "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran del 0 al 0 de 0 Registros",
            "infoFiltered":   "(Filtrado de un total de _MAX_ registros)",
            "lengthMenu":     "Se muestran _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontro ningun registro",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "columnDefs": [
            { width:"15%", "targets": 2 }
        ],
        "pageLength": 25,
        "scrollX":true,
        "scrollY": height,
        "scrollCollapse": true, 
    } );

    $('#program').DataTable( 
    {
        "language":             
        {
            "emptyTable":     "Tabla Vacia",
            "info":           "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran del 0 al 0 de 0 Registros",
            "infoFiltered":   "(Filtrado de un total de _MAX_ registros)",
            "lengthMenu":     "Se muestran _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontro ningun registro",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "columnDefs": [
            { width:"15%", "targets": 2 }
        ],
        "pageLength": 25,
        "scrollX":true,
        "scrollY": height,
        "scrollCollapse": true, 
    } );
} );

</script>
@endsection