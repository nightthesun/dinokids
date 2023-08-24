@extends('layouts.app')

@section('estilo')

<style>
    .marco {
  width: 500px; /* Ajusta el ancho según tus necesidades */
  height: 300px; /* Ajusta la altura según tus necesidades */
  border: 2px solid black; /* Grosor y color del borde */
  border-radius: 10px;
  padding: 10px; /* Espacio entre el contenido y el borde */
  box-sizing: border-box; /* Incluye el padding en el tamaño total del cuadrado */
}


*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100vw;
    height: 100vh;
    background: #ffffff;
    
}
h1 {
    color: white;
    font-family: 'Lato', sans-serif;
    font-size: 5rem;
    margin-bottom: 2rem;
}
.container {
    width: 100%;
    height: 400px;
    min-height: 300px;
    border-top: 1rem solid #000000;
    background: #4b6f9e;
    border-bottom: 1rem solid #000000;
    position: relative;
overflow: hidden;
}
.dino {
    height: 192px;
    width: 192px;
    /* URL de creador del dinosaurio: https://arks.itch.io/dino-characters */
    background: url('https://i.postimg.cc/x8DjjKSS/dino-walk.png'); 
  
    
    animation-name:walk, moveDino;
    animation-duration: 1s, 15s;
    animation-iteration-count: infinite, infinite;
    animation-timing-function: steps(5), linear;
    /* tamaño de la imagen del dino 1148 x 192 px */
    
    position: absolute;
    bottom: 22px;
}
.sombra-dino {
  position: absolute;
  left: 60px;
  bottom: -10px;
  width: 70px;
  height: 20px;
  border-radius:50%;
  box-shadow: 0px -24px 10px rgba(0,0,0,0.5);
}
.saludo-dino{
    position: relative;

}
.saludo-dino p {
    border-radius: 10px;
    background: white;
    
    padding: 0.5rem;
    position: absolute;
    top: -3rem;
    left: 7rem;

    font-size: 1rem;
    font-family: 'Lucida Sans', Arial, sans-serif;
    font-weight: bold;
    
    border: 8px solid rgba(0,0,0, 0.7);

    animation: mensaje 15s infinite linear;
}
.piso {
    width: 100%;
    height: 22%;
    position: absolute;
    bottom: 0;
    background: darkgreen;
    border-top: 7px solid rgba(0,0,0,0.3);
}
.arbol {
    width:0;
    height: 0;
    position: absolute;
    bottom: 20%;
    border-width: 40px 60px 180px 60px;
    border-style: solid;
    border-color: transparent transparent rgb(3, 71, 3) transparent;
    display: block;
    justify-content: center;
}
.arbol::before{
    content: "";
    width:0;
    height: 0;
    border-width: 2px 55px 180px 2px;
    border-style: solid;
    border-color: transparent transparent rgb(4, 126, 4) transparent;
}
.arbol:nth-child(1) {
    left: 6%; 
    bottom: 10%;
    transform: scaleY(0.8);
}
.arbol:nth-child(2) {
    left: 40%;
}
.arbol:nth-child(3) {
    left: 80%;
}
.arbol:nth-child(4) {
    left: 90%; 
    bottom: 10%;
    transform: scaleY(0.8);
}
.arbol:nth-child(5) {
    left: 50%;
}
.arbol:nth-child(6) {
    left: 20%;
}

.piedra {
    position: absolute;
    left: 50%;
    border-radius: 20px 20px 9px 9px;
    background-color: rgb(58, 56, 56);
    width: 45px;
    height: 23px;
    display: flex;
    
}
.piedra::before {
    content: "";
    height: 0;
    border-width: 7px 16px 10px 20px;
    border-color: rgba(255,255,255,0.2);
    border-style: solid;
    border-radius: 12px 12px 5px 5px;
    margin-top: 3px;
    margin-left: 2px;
    box-shadow: 0px 4px 5px rgba(0,0,0,0.5);
}
.piedra.p1{
    left: 10%;
    bottom: 2%;
    transform: scale(1.7);
}
.piedra.p2{
    left: 50%;
    bottom: 18%;
    transform: scale(1.4);
}
.piedra.p3{
    left: 90%;
    bottom: 4%;
    transform: scale(1.2);
}
.piedra.p4{
    left: 85%;
    bottom: 4%;
    transform: scale(1.6);
}

@keyframes moveDino {
    from{
        left: -192px;
    }
    30%{
        bottom: 10%;
    }
    50%{
        bottom: -2%;
    }
    70%{
        bottom: 10%;
    }
    to{
        left: calc(100vw + 192px);
    }
}

@keyframes walk {
    from{
        background-position: left;
    }
    to{
        background-position: right;
    }
}
@keyframes mensaje {
    0%{
        opacity: 0;
    }
    20%{
        opacity: 0;
    }
    25%{
        opacity: 1;
    }
    50%{
        opacity: 1;
    }
    55%{
        opacity: 0;
    }
    100%{
        opacity: 0;
    }
}    

</style> 
@endsection

<header>
   
    <img alt="foto" class="img-fluid " width="500px" height="300px" src="{{asset('imagenes/logoDino.png')}}"/>
</header>      
<div class="container">
    <div class="arbol"></div>
    <div class="arbol"></div>
    <div class="arbol"></div>
    <div class="arbol"></div>
    <div class="arbol"></div>
    <div class="arbol"></div>
    <div class="piso"></div>
    <div class="piedra p1"></div>
    <div class="piedra p2"></div>
    <div class="piedra p3"></div>
    <div class="piedra p4"></div>
    <div class="dino">
        <div class="sombra-dino"></div>
        <div class="saludo-dino">
            <p>Solicitud rechazada.<br>Ya tiene movimiento la colicitud!</p>
        </div>
    </div>

</div>

    <body>
        <div class="">
            <div style="padding-top: 20px">
             <div class="marco">
                    <h2 style="color: #000000;font-family: 'Courier New', Courier, monospace" >Error de eliminación</h2>
                    <p style="color: #000000;font-family: 'Courier New', Courier, monospace">No puede eliminar registros, ya que esta siendo usada en otra tabla.</p>
                  </div>
            </div>
        </div>
    </body>

@section('mis_scripts')


@endsection