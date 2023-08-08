@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
@section('estilo')
<style>
    body {
  display: inline-block;
  background: #00AFF9 url(https://cbwconline.com/IMG/Codepen/Unplugged.png) center/cover no-repeat;
  height: 100vh;
  margin: 0;
  color: white;
}

h1 {
  margin: .8em 3rem;
  font: 4em Roboto;
}
p {
  display: inline-block;
  margin: .2em 3rem;
  font: 2em Roboto;
}
</style>
@endsection


<h1>Whoops!</h1>
<p>
    Los errores siempre pasa 
</p>
<table>
    
</table>