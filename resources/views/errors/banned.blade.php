@extends('layouts.app')

@section('estilo')

<style>

body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
}

.container {
  max-width: 600px;
  margin: 100px auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 24px;
  margin-bottom: 10px;
}

p {
  font-size: 16px;
  margin-bottom: 20px;
}        
          
</style> 
@endsection

<body>
    <div class="container">
      <h1>Usuario Baneado</h1>
      <p>Lo sentimos, pero tu cuenta ha sido baneada debido a una infracción de nuestras normas.</p>
      <p>Ponte en contacto con el soporte si crees que esto es un error.</p>
    </div>
  </body>
@section('mis_scripts')


@endsection