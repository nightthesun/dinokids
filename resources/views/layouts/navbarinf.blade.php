<nav class="navbar navbar-expand-lg navbar-light  static-top" style="background-color: #dadde0;">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{asset('imagenes/logo.png')}}" height="40" class="d-inline-block align-top" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
          <!--configuraciones-->
          @foreach(App\Modulo::orderBy('nombre')->get() as $mod)
          @if(Auth::user()->tieneModulo($mod->id))
        
          @if ($mod->nombre=="Configuracion")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
            
          </li>
          @endif
          @if ($mod->nombre=="Contabilidad")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endif
          @if ($mod->nombre=="RRHH")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endif
          @if ($mod->nombre=="Sistemas")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endif
          @if ($mod->nombre=="Ventas")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endif
          @if ($mod->nombre=="Reportes Dualbiz")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}} </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
          </ul>
          
  
          </li>
          @endif
          @if ($mod->nombre=="Inventarios")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endif
          @if ($mod->nombre=="Cobranzas")
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="{{$mod->icon}}"></i>
              <span>{{$mod->nombre}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              @foreach($mod->programs as $prog)
              @if(Auth::user()->authorizePermisos([$prog->nombre, 'Ver']) && !$prog->sub_modulo_id)
              <li class="route @if(Route::currentRouteName() == $prog->route) texto-luz @endif">
                <a class="dropdown-item" href="{{route($prog->route)}}">{{$prog->nombre}}
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endif
          
  
  
          @endif
          @endforeach
       
          
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="user-name">{{ Auth::user()->perfiles->nombre}} </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Cerrar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- ventana modal de mensajes -->
  <!-- Modal -->
  <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(36, 34, 34); ">CUENTAS POR COBRAR POR VENCER</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row justify-content-center mt-4">
              <div class="col-md-12">
                <table id="example" class="cell-border compact hover" style="width:100%; color: rgb(36, 34, 34); "></table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  