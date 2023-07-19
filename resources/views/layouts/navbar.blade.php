<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('imagenes/logo.png')}}"  height="40" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                        @if(Auth::user()->perfiles->foto != NULL)      
                            <img alt="foto" class="img-fluid border mr-1 " width="40" height="40" src="{{ asset(Auth::user()->perfiles->foto) }}"/>
                        @else
                            <img alt="foto" class="img-fluid border mr-1" width="40" height="40" src="{{asset('imagenes/log.png')}}"/>
                        @endif
                        <li class="nav-item dropdown">                                
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{  Auth::user()->perfiles->nombre}}<span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <!--NOTIFICAIONES-->    
                        <div class="btn-group" id="not">
                            <li class="nav-item dropdown"  >
                                <a id="navbarDropdown1" class="nav-link @if(Auth::user()->unreadNotifications->count()==0) disabled @endif" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bell"></i>
                                    @if($count=Auth::user()->unreadNotifications->count())
                                        <span class="badge badge-pill badge-primary parpadea" id="contant">
                                            {{$count}}
                                        </span>          
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right justify-content-right" >
                                                      
                                @if($count != 0)    
                                <div class="d-flex row"> 
                                    <form  method="POST" action="{{action('NotificationsController@deleteall')}}" >
                                        @csrf
                                        <button class="btn btn-light btn-xs">
                                                Eliminar Todo                                                           
                                        </button>
                                    </form>
                                </div> 
                                @endif
                                        <div class="scroll">
                                            @if($count != 0)  
                                            @foreach($auth=Auth::user()->unreadNotifications as $unreadNotification)  
                                                <div class="d-flex row"> 
                                                    <div class="d-flex col-9">
                                                        <a class="dropdown-item" href="{{route('notifications.redirect',[ $unreadNotification->data['url'], $unreadNotification->data['cotizacion_id'] ] )}}"  >
                                                            {{$unreadNotification->data['text']}}
                                                        </a> 
                                                    </div>
                                                    <div class="col-3">
                                                        <form id="notificaciones"  method="POST" action="{{action('NotificationsController@read',$unreadNotification->id)}}" class="float-sm-right">
                                                            @csrf
                                                            <input name="_method" type="hidden" value="PATCH">
                                                                        <button class="btn btn-light btn-xs"data-toggle="tooltip"data-placement="top" title="Marcar como leido">
                                                                            <i class="fas fa-times-circle"></i>                                                           
                                                                        </button>
                                                                    </form> 
                                                                </div>
                                                            </div>
                                                           
                                                        @endforeach   
                                                            
                                                            @endif
                                                            <div id="notifireal">
                                                            </div>
                                                    <div>    
                                                    
                                            
                                               
                                    

                                           
                                        
                                        </div>
                                            <div class="dropdown-menu dropdown-menu-right " >
                                                <div class="scroll">
                                                 @foreach($auth=Auth::user()->readNotifications as $readNotification)  
                                                    <div class="d-flex flex-column "> 
                                                        <div class="d-flex align-items-center">
                                                            <a class="dropdown-item"  onclick="event.preventDefault();document.getElementById('notify_view_r').submit();" >
                                                                {{$readNotification->data['text']}}
                                                            </a> 

                                                            <form  id="notify_view_r" method="GET" action="{{$readNotification->data['url']}}" >
                                                    
                                                            {{csrf_field()}}                                                 

                                                            </form>

                                            
                                                       
                                                        </div>    
                                                    <div>      
                                                @endforeach
                                                </div>
                                                

                                            </div>
                                    
                                </li>    
                             </div>
                            <!--END NOTIFICACIONES-->
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>