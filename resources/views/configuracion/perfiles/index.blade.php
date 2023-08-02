@extends('layouts.app')
@section('static', 'statick-side')
@section('content') 

@include('layouts.sidebar', ['hide'=>'1']) 
@section('estilo')
<style>
  .borde1 {
    border-width: 1px;
    border-style: solid;
    border-color: #6c757d;
    border-radius: 10px;
    margin-left: -20%;
    
  }
  .titulo1{
    color: #B40F7F;
    font-weight: bold;
  }
  
  
  #botonSubir {
     
      background-color: #74AB36;
      color: white;
     
      border: 2px solid #74AB36;
      border-radius: 25px;
      cursor: pointer;
      width:200px;
    height:50px;
    font-size: 20px;
  }
  #botonSubir:hover {
    background-color: #B40F7F;
      color: white;
      border: 2px solid #B40F7F;  
  }
  .contenedor {
    padding-top: 20px;
  display: flex;
  justify-content: space-between; /* Coloca el h1 y el botón en los extremos opuestos */
  align-items: center; /* Centra verticalmente los elementos */
  
}

.h11 {
  margin: 0; /* Elimina el margen predeterminado del h1 */
}
</style> 
@endsection

<div class="contenedor">
  <h3 class="titulo1 h11">Lista de usuarios sin permiso</h3>
  <button type="button" class="btn btn-primary" id="botonSubir"  >
    <i class="fa fa-user-plus" aria-hidden="true"></i> {{ __('Añadir usuario') }}
   </button>
</div>
      

        
          
        



@endsection
@section('mis_scripts')
<script>


</script>
@endsection
