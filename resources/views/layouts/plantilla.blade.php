<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{asset('icons/48.png')}}" />
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
      
      <style type="text/css"> 
      
      </style>
      @yield('estilo')
      @yield('mis_scripts') 
      <script type="text/javascript">

      </script>
  </head>

  <body>
    <header>
      @include('layouts.navbar')
    </header>
    <main>
        @yield('content')
    </main>       
    <script src="{{asset('js/app.js')}}"></script>
    @yield('mis_scripts')  
    <script type="text/javascript">
    </script>   
  </body>   
</html>