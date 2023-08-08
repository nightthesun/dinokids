@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('estilo')
<style>
.container {
    width: 100%;
    height: 100%;
    height: 100vh;
    overflow: hidden !important;
  }
  
  h1 {
    font-family: "Source Sans Pro", sans-serif;
    font-weight: bold;
    font-size: 40px;
    letter-spacing: 15px;
    text-transform: uppercase;
    text-align: center;
    color: rgb(241,241,241);
    margin: 0px;
    padding: 0px;
  }
  
  p {
    font-family: "Source Sans Pro", sans-serif;
    position: fixed;
    top: -250px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 7.5px;
    text-transform: uppercase;
    text-align: center;
    color: rgb(241,241,241);
    padding-left: 50px;
    margin: 0px;
  }
  
  p a {
    color: rgb(241,241,241);
    text-decoration: none;
    margin: 0;
    padding: 0;
  }
  
  p a:hover {
    color: #808080;
    text-decoration: underline;
  
  }
  
  .text {
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%) !important;
    -ms-transform: translateY(-50%) !important;
    transform: translateY(-50%) !important;
    z-index: 3;
    display: block;
  }
  
  /* ---- reset ---- */
  
  body {
    margin: 0;
  }
  
  canvas {
    display: block;
    vertical-align: bottom;
  }
  
  /* ---- particles.js container ---- */
  
  #particles-js {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: rgb(14,14,14);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 50% 50%;
  }
  
</style>

@endsection

<div id="particles-js">
    <canvas class="particles-js-canvas-el"  style="width: 100%; height: 100%;">
    </canvas>
  </div>
  
  <div class="container">
    <div class="text">
      <h1 style="text-shadow: -2px 0 0 rgba(255,0,0,.7),
          2px 0 0 rgba(0,255,255,.7);"> ERROR 404 </h1>
      <p> <a href="#">go back</a></p>
    </div>
  </div>





@section('mis_scripts')
@endsection