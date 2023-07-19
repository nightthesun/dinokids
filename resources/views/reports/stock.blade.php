@extends('layouts.app')
@section('static', 'statick-side')
@section('estilo')

<style>
  .grid-container {

    grid-template-rows: 100px 100px 100px 100px;
    grid-template-columns: 100px 100px 100px 100px;
    grid-gap: 5px;
  }

  .divAlma {
    width: 100%;

  }
</style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'0'])

<div class="container">
  <form method="POST" action="{{ route('stock.store') }}">
    @csrf
    <div class="row mt-4 justify-content-center">
      <div class="col-md-4">



        <div class="container border rounded">
          <div class="row text-center my-3">
            <h5 class="text-primary">REPORTE DE STOCK ACTUAL</h5>
          </div>
          <div class="mb-2 row d-flex justify-content-center">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Al:</label>
            <div class="col-sm-7">
              <input id="fecha_fin" type="date" class="form-control form-control-sm" @if(!Auth::user()->tienePermiso(5,6))
              disabled
              @endif
              name="fecha_fin" value ="{{date('Y-m-d')}}">
            </div>
          </div>
          <div class="mb-2 row d-flex justify-content-center">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Categoria:</label>
            <div class="col-sm-7">
              <input id="categoria" type="text" class="form-control form-control-sm" name="categoria">
            </div>
          </div>
          <div class="mb-2 row d-flex justify-content-center">
            <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm text-right">Producto:</label>
            <div class="col-sm-7">
              <input id="producto" type="text" class="form-control form-control-sm" name="producto">
            </div>
          </div>
          <div class="px-3 mb-2 row">
            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="stock02" name="stock0" checked>
                <label class="form-check-label" for="stock02">Mostrar productos con stock 0</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="codBarras" name="codBarras">

                <label class="form-check-label" for="codBarras">Mostrar Codigos de Barra</label>
              </div>
            </div>
          </div>

          <!--
                <div class="row text-start my-3">
                        <h6 class="text-primary">DATOS ADICIONALES</h6>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                            type="checkbox" id="flexSwitchCheckChecked" name="almacen_check">
                            <label class="form-check-label" for="flexSwitchCheckChecked">
                                ALMACENES
                            </label>     
                        </div>
                    </div>
                    <br>
                -->


          <div class="mb-3 row">
            <div class="col-md-12 text-center d-block gap-2">
              <button type="submit" class="btn btn-primary" name="gen" value="ver">
                {{ __('Ver') }}
              </button>
              <button type="submit" class="btn btn-primary" name="gen" value="export">
                {{ __('Exportar') }}
              </button>

            </div>

          </div>

        </div>

        <!---->
        <div class="controles-form-esq-der  @if(!Auth::user()->tienePermiso(5,9,)) d-none @endif">
          <!-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fas fa-tools"></i>
                    </button-->

          <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <i class="fa fa-cog" aria-hidden="true"></i>
          </button>

        </div>


        <!--datos de almacenes-->

        <div class="col-8
@if(!Auth::user()->tienePermiso(5,9))
    d-none
@endif">



          <!--boton inferior-->
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
              <h5 id="offcanvasRightLabel">Configuracion</h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <div class="row">
                <div class="col-4">
                  <div class="modal-body">

                    <div class="list-group" style="height:450px;overflow:auto; width: 125px;overflow:auto;   font-size:0.8rem">
                      @foreach (App\User::get() as $u)
                      <a href="#" class="list-group-item list-group-item-action usuarios_param" id="{{$u->id}}">
                        {{$u->perfiles->nombre}}
                        {{$u->perfiles->paterno}}
                      </a>

                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="col-8">
                  <div class="container p-4 mt-4" style="height:450px;overflow:auto; font-size:0.8rem">
                    @foreach($almacen_grupo as $k => $alm)
                    <h6 class="mb-1">{{$k}}</h6>
                    <ul id="almxg" class="list-group list-group-flush">
                      @foreach($alm as $l => $a)
                      <li class="list-group-item" id="{{$k}}">
                        <div class="form-check form-switch">
                          <input class="form-check-input almxu" type="checkbox" id="palm_{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almxu[]">
                          <label class="form-check-label" for="flexSwitchCheckChecked">
                            {{$a->inalmNomb}}
                          </label>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                    @endforeach

                  </div>
                </div>
              </div>
              <br>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="liveToastBtn">Guardar</button>

              </div>
            </div>
          </div>
          <!--------------------->


          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="row">
                  <div class="col-4">
                    <div class="modal-body">
                      <div class="list-group" style="height:400px;overflow:auto; font-size:0.8rem">
                        @foreach (App\User::get() as $u)
                        <a href="#" class="list-group-item list-group-item-action usuarios_param" id="{{$u->id}}">
                          {{$u->perfiles->nombre}}
                        </a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="container p-4 mt-4" style="height:400px;overflow:auto; font-size:0.8rem">
                      @foreach($almacen_grupo as $k => $alm)
                      <h6 class="mb-1">{{$k}}</h6>
                      <ul id="almxg" class="list-group list-group-flush">
                        @foreach($alm as $l => $a)
                        <li class="list-group-item" id="{{$k}}">
                          <div class="form-check form-switch">
                            <input class="form-check-input almxu" type="checkbox" id="palm_{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almxu[]">
                            <label class="form-check-label" for="flexSwitchCheckChecked">
                              {{$a->inalmNomb}}
                            </label>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-primary">Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--------------------------------->
      <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">
        <div class="col">
          <div class="p-3 border bg-light">
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    SUCURSALES

                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse " aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="row p-2" style="height:35vh;overflow:auto; font-size:0.8rem">
                      <!-- boton para activar todo -->
                      <div class="form-check form-switch">
                        <input class="form-check-input selectallS" type="checkbox" id="flexSwitchCheckChecked" checked>
                        <label class="form-check-label select-textS">DESACTIVAR</label>
                        <hr style="align-items: center" />
                      </div>


                      @foreach($almacen_grupo as $k => $alm)
                      @if ($k=="SanMiguel" || $k=="AC1" || $k=="AC1"
                      || $k=="AC2"|| $k=="Ballivian"|| $k=="Calacoto" || $k=="Feria"|| $k=="Handal"
                      || $k=="Mariscal" || $k=="Planta" || $k=="SantaCruz" || $k=="VMovil1")
                      <div class="col-8 px-100 py-6 ">

                        <h6 class="mb-1">{{$k}}</h6>
                        <ul id="seg" class="list-group list-group-flush">
                          @foreach($alm as $l => $a)

                          <li class="list-group-item" id="{{$k}}">
                            <div class="form-check form-switch">
                              <input class="optionS justone form-check-input " type="checkbox" id="{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almacen[]" @if($a->estado == 1)
                              checked @endif>
                              <label class="form-check-label">
                                {{$a->inalmNomb}}
                              </label>
                            </div>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                      @endif

                      @endforeach
                    </div>
                  </div>
                </div>
              </div>

              <!--flash-->


            </div>
          </div>
        </div>

        <div class="col">
          <div class="p-3 border bg-light">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo22">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo22" aria-expanded="false" aria-controls="flush-collapseTwo22">
                  MAYORISTAS
                </button>
              </h2>
              <div id="flush-collapseTwo22" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo22" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">

                  <div class="row p-2" style="height:35vh;overflow:auto; font-size:0.8rem">

                    <!-- boton para activar todo -->
                    <div class="form-check form-switch">
                      <input class="form-check-input selectallM" type="checkbox" id="flexSwitchCheckChecked">
                      <label class="form-check-label select-textM">ACTIVAR</label>
                      <hr style="align-items: center" />
                    </div>


                    @foreach($almacen_grupo as $k => $alm)
                    @if ($k=="AlmMay1" || $k=="AlmMay2" || $k=="AlmMay3"
                    || $k=="AlmMay4"|| $k=="AlmMay5"||$k=="AlmDistribuidor1"||$k=="AlmResGeneral")
                    <div class="col-8 px-100 py-6 ">

                      <h6 class="mb-1">{{$k}}</h6>
                      <ul id="seg" class="list-group list-group-flush">




                        @foreach($alm as $l => $a)

                        <li class="list-group-item" id="{{$k}}">
                          <div class="form-check form-switch">
                            <input class="optionM form-check-input" type="checkbox" id="{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almacen[]" @if($a->estado == 1)
                            checked @endif>
                            <label class="form-check-label">
                              {{$a->inalmNomb}}
                            </label>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                    @endif

                    @endforeach
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="p-3 border bg-light">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  REGIONALES
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <div class="row p-2" style="height:35vh;overflow:auto; font-size:0.8rem">

                    <!-- boton para activar todo -->
                    <div class="form-check form-switch">
                      <input class="form-check-input selectallR" type="checkbox" id="flexSwitchCheckChecked">
                      <label class="form-check-label select-textR">DESACTIVAR</label>
                      <hr style="align-items: center" />
                    </div>

                    @foreach($almacen_grupo as $k => $alm )

                    @foreach($alm as $l => $a)
                    @if ($a->inalmNomb=="ALMACEN COCHABAMBA" || $a->inalmNomb=="ALMACEN ORURO"|| $a->inalmNomb=="ALMACEN POTOSI" || $a->inalmNomb=="ALMACEN SUCRE"|| $a->inalmNomb=="ALMACEN TARIJA")

                    <div class="form-check form-switch">
                      <input class="optionR form-check-input" type="checkbox" id="{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almacen[]" @if($a->estado == 1)
                      checked @endif>
                      <label class="form-check-label" for="flexSwitchCheckChecked">
                        {{$a->inalmNomb}}
                      </label>
                    </div>

                    @endif

                    @endforeach




                    @endforeach
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col">
          <div class="p-3 border bg-light">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo2" aria-expanded="false" aria-controls="flush-collapseTwo2">
                  INSTITUCIONALES
                </button>
              </h2>
              <div id="flush-collapseTwo2" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo2" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <div class="row p-2" style="height:35vh;overflow:auto; font-size:0.8rem">

                    <!-- boton para activar todo -->
                    <div class="form-check form-switch">
                      <input class="form-check-input selectallI" type="checkbox" id="flexSwitchCheckChecked">
                      <label class="form-check-label select-textI">ACTIVAR</label>
                      <hr style="align-items: center" />
                    </div>

                    @foreach($almacen_grupo as $k => $alm )

                    @foreach($alm as $l => $a)
                    @if ($a->inalmNomb=="ALMACEN KETAL"||$a->inalmNomb=="ALMACEN SICOES"||$a->inalmNomb=="ALMACEN CONTRATOS" ||$a->inalmNomb=="ALMACEN RESERVA CONTRATOS"||$a->inalmNomb=="ALMACEN INSTITUCIONAL 1" ||$a->inalmNomb=="ALMACEN INSTITUCIONAL 2"||$a->inalmNomb=="ALMACEN INSTITUCIONAL 3"||$a->inalmNomb=="ALMACEN INSTITUCIONAL 4"||$a->inalmNomb=="INSTITUCIONAL BLL"||$a->inalmNomb=="INSTITUCIONAL CAL"||$a->inalmCalm==32||$a->inalmNomb=="INSTITUCIONAL MSC")
                    <div class="form-check form-switch">
                      <input class="optionI form-check-input" type="checkbox" id="{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almacen[]" @if($a->estado == 1)
                      checked @endif>
                      <label class="form-check-label" for="flexSwitchCheckChecked">
                        {{$a->inalmNomb}}
                      </label>
                    </div>

                    @endif

                    @endforeach




                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col">
          <div class="p-3 border bg-light">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo23">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo23" aria-expanded="false" aria-controls="flush-collapseTwo23">
                  PLANTA
                </button>
              </h2>
              <div id="flush-collapseTwo23" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo23" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <div class="row p-2" style="height:35vh;overflow:auto; font-size:0.8rem">

                    <!-- boton para activar todo -->
                    <div class="form-check form-switch">
                      <input class="form-check-input selectallSG" type="checkbox" id="flexSwitchCheckChecked">
                      <label class="form-check-label select-textSG">ACTIVAR</label>
                      <hr style="align-items: center" />
                    </div>
                    @foreach($almacen_grupo as $k => $alm )

                    @foreach($alm as $l => $a)
                    @if ($a->inalmNomb=="INSUMOS"||$a->inalmNomb=="MATERIA PRIMA"||$a->inalmNomb=="PRODUCCION EN PROCESO"||$a->inalmNomb=="PRODUCTO TERMINADO"||$a->inalmNomb=="ALMACEN CONSIGNACION")
                    <div class="form-check form-switch">
                      <input class="optionSG  form-check-input" type="checkbox" id="{{$a->inalmCalm}}" value="{{$a->inalmCalm}}" name="almacen[]" @if($a->estado == 1)
                      checked @endif>
                      <label class="form-check-label" for="flexSwitchCheckChecked">
                        {{$a->inalmNomb}}
                      </label>
                    </div>

                    @endif

                    @endforeach




                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>





    </div>


    <input type='hidden' name='grupos' value="{{(serialize($almacen_grupo))}}" />
  </form>


</div>


</div>
@endsection
@section('mis_scripts')
<script>
  ///////sucursales 
  $('.selectallS').click(function() {


    if ($(this).is(':checked')) {
      $('.optionS').prop('checked', true);
      var total = $('input[name="options[]"]:checked').length;
      $(".dropdown-text").html('(' + total + ') Selected');
      $(".select-textS").html('DESACTIVAR');

    } else {
      $('.optionS').prop('checked', false);

      $(".dropdown-text").html('(0) Selected');
      $(".select-textS").html('ACTIVAR');

    }
  });
  ///////MAYORISTA
  $('.selectallM').click(function() {


    if ($(this).is(':checked')) {
      $('.optionM').prop('checked', true);
      var total = $('input[name="options[]"]:checked').length;
      $(".dropdown-text").html('(' + total + ') Selected');
      $(".select-textM").html('DESACTIVAR');

    } else {
      $('.optionM').prop('checked', false);

      $(".dropdown-text").html('(0) Selected');
      $(".select-textM").html('ACTIVAR');

    }
  });
  ///////REGIONALES
  $('.selectallR').click(function() {


    if ($(this).is(':checked')) {
      $('.optionR').prop('checked', true);
      var total = $('input[name="options[]"]:checked').length;
      $(".dropdown-text").html('(' + total + ') Selected');
      $(".select-textR").html('DESACTIVAR');

    } else {
      $('.optionR').prop('checked', false);

      $(".dropdown-text").html('(0) Selected');
      $(".select-textR").html('ACTIVAR');

    }
  });
  ///////INSTiITUCIONAL 
  $('.selectallI').click(function() {


    if ($(this).is(':checked')) {
      $('.optionI').prop('checked', true);
      var total = $('input[name="options[]"]:checked').length;
      $(".dropdown-text").html('(' + total + ') Selected');
      $(".select-textI").html('DESACTIVAR');

    } else {
      $('.optionI').prop('checked', false);

      $(".dropdown-text").html('(0) Selected');
      $(".select-textI").html('ACTIVAR');

    }
  });
  ///////SIN GRUPO 
  $('.selectallSG').click(function() {


    if ($(this).is(':checked')) {
      $('.optionSG').prop('checked', true);
      var total = $('input[name="options[]"]:checked').length;
      $(".dropdown-text").html('(' + total + ') Selected');
      $(".select-textSG").html('DESACTIVAR');

    } else {
      $('.optionSG').prop('checked', false);

      $(".dropdown-text").html('(0) Selected');
      $(".select-textSG").html('ACTIVAR');

    }
  });
</script>
<script>
  $(document).ready(function() {
    $(".usuarios_param").click(function() {
      $(".usuarios_param").removeClass("active");
      $(this).toggleClass("active");
      var user = $(this).attr("id");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{route('stock.store_almxu')}}",
        type: 'POST',
        data: {
          user,
          show: true
        },
        dataType: 'json',
        success: function(data) {

          $(".almxu").each(function() {
            $(this).prop('checked', false);
          });
          for (var i = 0; i < data.length; i++) {
            $("#palm_" + data[i].alm_id).prop("checked", true);
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr);
        }
      });
    });
  });
  $('.almxu').change(function() {
    $()
    var user = $(".usuarios_param.active").attr("id");
    var alm = $(this).val();
    var state = $(this).is(':checked');
    if (user != undefined) {

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{route('stock.store_almxu')}}",
        type: 'POST',
        data: {
          user,
          alm,
          state
        },
        dataType: 'json',
        success: function(data) {
          console.log(data);
        },
        error: function(xhr, status, error) {
          console.log(xhr);
        }
      });
    }
  });
</script>
@endsection