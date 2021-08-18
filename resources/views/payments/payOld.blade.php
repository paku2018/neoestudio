<!DOCTYPE html>
<html>
   <head>
      <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- Bootstrap CSS -->


    <title>Neoestudio</title>
    <style type="text/css">
    @font-face {
      font-family: "Proxima Nova Regular";
      src: url("{{asset('neostudio/pr.otf')}}");
    }
    @font-face {
      font-family: "Proxima Nova Bold";
      src: url("{{asset('neostudio/pb.otf')}}");
    }
    @font-face {
  font-family: "Proxima Nova Soft";
  src: url("{{asset('neostudio/pss.ttf')}}");
}
b{
  font-family: Proxima Nova Soft;
}
    body{
      font-family: Proxima Nova Regular;
      background: url("{{asset('neostudio/bodyback.jpg')}}");
      background-size: 100% 100%;
    }
    #tB:focus{
    outline: 1px;
  }
    .mU {
  list-style-type: none;
}

.liU:before {
  content: '-';
  position: absolute;
  margin-left: -20px;
}
  a{
    color: #777;
  }
  a:hover{
    text-decoration: none;
    color: white;
  }
     #nav li {
  display: inline;
}


         #main-container {
    width: 100%;
   margin-top: -32px;
}
#main-video {
    object-fit: fill;
    width: 100%;
    height: 40vh;
}
.logoLeft{
    width: 30%; height: auto; position: absolute;
    left: 1px;
    top: 0px;
    z-index: 1;
  }
  .logoRight{
    display: none;
  }
  .firstLi{
    padding-right: 75px;
  }
  #sv{

  }
  .underVideoDiv{

  }
  .mainHeading{
    display: none;
    margin-left: 4%;
  }
  .underHeadingDiv{

  }
  .comienza{
    width: 60%;
  }
  .content{
    display: none;
    margin-left: 5%; margin-right: 1%;
  }
  .underContentDiv{
    background:url("{{asset('neostudio/4.png')}}"); background-size: contain; background-repeat: no-repeat;
  }
  .buttonsP{
    margin-left: 15%;
  }
  .button1{
    width: 40%;
  }
  .button2{
    width: 40%;
  }
  .footerImage{
     left: 0; bottom: 0;width: 20%;
  }
  .handClass{
    width: 100px; margin-top: 5px;
  }
  .cara{
    margin-top: 5%;
  }
  #navbarSupportedContent{
    padding-left: 30%;
  }
  .forLg{
    display: none;
  }
  .forSm{
    display: block;
  }
  .compIm{
    width: 80%;margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
  }
  .botIm{
    width: 85%;margin: 0;position: absolute;top: 50%;left: 50%;
        -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);
  }
  .size1{
    font-size: 75%;
  }
  .size2{
    font-size: 70%;
  }
  .mar{
    margin-left: 0%;margin-right: 0%;
  }
  .fo{
    font-size: x-small;
  }
@media only screen and (min-width: 1000px) {
  body{
    background: url("{{asset('neostudio/bodyback.jpg')}}");
      background-size: 100% 100%;
  }
  a{
    color: #777;
  }
  a:hover{
    text-decoration: none;
    color: white;
  }
  #nav li {
    display: inline;
  }
  #main-container {
    width: 100%;
   margin-top: -32px;
  }
  #main-video {
    object-fit: fill;
    width: 100%;
    height: 85vh;
  }
  .comienza{
    width: 40%;
  }
  .logoLeft{
    width: 10%; height: auto; position: absolute;
    left: 1px;
    top: 0px;
    z-index: 1;
  }
  .logoRight{
    display: block;
    width: 9%; height: auto; position: absolute;
    right: 2%;
    top: 0px;
    z-index: 1;
  }
  .firstLi{

  }
#horizontal-style {
    display: table;
    width: 70%;
    margin-left:5%;
    table-layout: fixed;

}
#horizontal-style li {
    display: table-cell;
}
#horizontal-style a {
    display: block;

    text-align: center;
    margin: 0 0px;

}
#sv{
  background:url("{{asset('neostudio/Header1.png')}}");
        background-size: 100% 100%; padding-top: 2%;padding-bottom: 4%;border:0
}
  .underVideoDiv{
    margin-top: -150px;
    background:url("{{asset('neostudio/4.png')}}"); background-size: contain; background-repeat: no-repeat;
  }
  .mainHeading{
    display: block;
    visibility: hidden;
    margin-left: 15%; padding-top: 5%;
  }
  .underHeadingDiv{
    margin-left: 20%; margin-right: 20%;
  }
  .content{
    display: block;
    visibility: hidden;
    margin-left: 0;
    margin-right: 0;
  }
  .underContentDiv{
    background:url();
  }
  .buttonsP{
    margin-left: 35%; padding-top: 5%;
  }
  .button1{
    width: 20%;
  }
  .button2{
    width: 20%;
  }
  .footerImage{
    left: 0; bottom: 0; width: 10%;
  }
  .handClass{
    width: 375px; margin-top: -100px;
  }
  #navbarSupportedContent{
    padding-left: 0;
  }
  .cara{
    margin-top: 0;
  }
  .forLg{
    display: block;
  }
  .forSm{
    display: none;
  }
  .compIm{
    width: 50%;margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
  }
  .botIm{
    width: 70%;margin: 0;position: absolute;top: 50%;left: 50%;
        -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);
  }
  .size1{
    font-size: 100%;
  }
  .size2{
    font-size: 100%;
  }
  .mar{
    margin-left: 10%;margin-right: 10%;
  }
  .fo{
    font-size: small;
  }


}
      </style>
   </head>

   <body style="">
    <div style="background:url('{{asset('neostudio/Header1.png')}}');background-size: cover;">
    <img class="logoLeft" src="{{asset('neostudio/1.png')}}">
    <img class="logoRight" src="{{asset('neostudio/Logo.png')}}">
    <nav id="sv" class="navbar navbar-expand-lg navbar-dark">

        <button id="tB"  style="border: none; position: absolute;right: 0 ;top: 0;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <img src="{{asset('neostudio/Logo.png')}}" class="lgm" style="width: 100px;"><br>
          <span class="navbar-toggler-icon" style="float: right; border-color: transparent;margin-top: -25px;"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="navbar-nav mr-auto" id="horizontal-style">
            <li style=""><a href="{{url('/')}}">Inicio</a></li>
            <li style=""><a href="{{url('oposicion')}}">Oposición</a></li>
            <li style=""><a href="{{url('formacion')}}">Formación</a></li>
            <li style=""><a href="{{url('equipo.html')}}">Equipo</a></li>
            <li style=""><a href="{{url('contacto')}}">Contacto</a></li>
            <li style=""><a href="{{url('registerate')}}">¡Regístrate!</a></li>
            <li style=""><a href="{{url('comienza')}}" style="color:white;text-decoration:underline;text-underline-position:under;">¡Comienza ya!</a></li>
          </ul>

        </div>
      </nav>

      <span class="forSm"><br><br><br></span>
    </div>
    <br>
    @if (!empty($message2))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>Alert!</h5>
          {{$message2}}
    </div>
    @endif
    @if (!empty($message))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>Alert!</h5>
          {{$message}}
    </div>
    @endif
      <div class="text-center"><h2 style="font-family: Proxima Nova Soft;">Historial De Pagos</h2></div>
  <span class="forLg"><br></span>
  <div class="container text-center">
    <div style="overflow-x: auto;">
    <table class="table table-striped" style="">
  <thead>
    <tr>
      <th scope="col">Tipo</th>
      <th scope="col">Precio</th>
      <th scope="col">Fecha límite</th>
      <th scope="col">Cuota no</th>
      <th scope="col">Estado</th>

    </tr>
  </thead>
  <tbody>

    @if(!empty($pays))
    @foreach($pays as $pay)
    <tr>

      <td>@if(!empty($pay->type)){{$pay->type}}@endif</td>
      <td>@if(!empty($pay->amount)){{$pay->amount}}@endif</td>
      <td>@if(!empty($pay->deadline)){{$pay->deadline}}@endif</td>
      <td>@if(!empty($pay->installment)){{$pay->installment}}@endif</td>
      @if($pay->status=="pending")<td>pendiente</td>@endif
      @if($pay->status=="paid")
      <td>pagada</td>
      @endif
      @if($pay->status=="pending")
        <td><a class="btn btn-success" href="{{url('pay/'.$pay->userId.'/'.$pay->amount.'/'.$pay->type.'/'.$pay->id)}}">pagar</a></td>
      @endif
    </tr>
    @endforeach
    @endif



  </tbody>
</table>
</div>
  </div>
  <?php
use Carbon\Carbon;

      $p=\App\Amount::where('amountType','books')->first();
      if($p){
      $price=$p->amount;}
     ?>
  @if($booksExists==false)
  <span class="forLg"><br><br><br><br><br><br><br><br></span>
  <span class="forSm"><br><br><br><br><br></span>

  <div class="row mar" style="">

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <img class="botIm" src="{{asset('neostudio/bot1a.png')}}" style="">
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <p class="size1" style="margin: 0;position: absolute;top: 50%;left: 50%;
      -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);"><b>Temario</b><br><span class="size2" ">Cupón -25%: 6</span></p>
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <p style="margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);"><b>@if(!empty($price)){{$price}}@endif</b>€</p>
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
     @if(!empty($userId))
      <a href="{{url('purchaseCo/'.$userId.'/'.'books')}}"><img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
      @endif
      @if(empty($userId))

      <a href="{{url('purchaseCo/'.'nul'.'/'.'books')}}"><img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
      @endif
    </div>

  </div>
  @endif
  <?php

$month=Carbon::now()->month;


        $ae=\App\Price::where('month',$month)->where('studentType','Alumno')->exists();
        if($ae==true){
          $a=\App\Price::where('month',$month)->where('studentType','Alumno')->first();
        $amount=$a->amount;
      }
 ?>
  @if($alumnoExists==false)
  <span class="forLg"><br><br><br><br><br><br><br></span>
  <span class="forSm"><br><br><br><br><br></span>
  <div class="row mar" style="">

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <img class="botIm" src="{{asset('neostudio/bot2a.png')}}" style="">
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <p class="size1" style="margin: 0;position: absolute;top: 50%;left: 50%;
      -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);text-align: left;"><b>Curso online</b></p>
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <p style="margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);"><b>@if(!empty($amount)){{$amount}}@endif</b>€</p>
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      @if(!empty($userId))
      <?php
        $existsB=\App\Pay::where('userId',$userId)->where('type','books')->exists();
       ?>
       @if($existsB==true)
        <a href="{{url('purchaseCo/'.$userId.'/'.'alumno')}}"><img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
        @endif
        @if($existsB==false)
        <img class="compIm" src="{{asset('neostudio/compblack.png')}}" style="">
        @endif
      @endif
       @if(empty($userId))

        <a href="{{url('purchaseCo/'.'nul'.'/'.'alumno')}}"><img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
      @endif
    </div>

  </div>
  @endif
  <?php

$month=Carbon::now()->month;


         $ace=\App\Price::where('month',$month)->where('studentType','Alumno Convocado')->exists();
        if($ace==true){
          $ac=\App\Price::where('month',$month)->where('studentType','Alumno Convocado')->first();
        $amountC=$ac->amount;
      }
 ?>
  @if($alumnoConvocadoExists==false)
  <span class="forLg"><br><br><br><br><br><br><br></span>
  <span class="forSm"><br><br><br><br><br></span>
  <div class="row mar" style="">

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <img class="botIm" src="{{asset('neostudio/bot3a.png')}}" style="">
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <p class="size1" style="margin: 0;position: absolute;top: 50%;left: 50%;
      -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);"><b>Continuación curso online </b><br><span class="size2" style="">(nuevo ciclo 12 meses hasta examen oficial)</span></p>
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      <p style="margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);"><b>@if(!empty($amountC)){{$amountC}}@endif</b>€</p>
    </div>

    <div class="col-md-3 col-3 text-center" style="position: relative;">
      @if(!empty($userId))
      <?php
        $existsA=\App\Pay::where('userId',$userId)->where('type','alumnoConvocado')->exists();
       ?>
       @if($existsA==true)
        <a href="{{url('purchaseCo/'.$userId.'/'.'alumnoConvocado')}}"><img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
        @endif
        @if($existsA==false)
        <img class="compIm" src="{{asset('neostudio/compblack.png')}}" style="">
        @endif
      @endif
       @if(empty($userId))

        <a href="{{url('purchaseCo/'.'nul'.'/'.'alumnoConvocado')}}"><img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
      @endif
    </div>

  </div>
  @endif
  <br><br>

<div style="visibility: hidden;">
   <?php
      dd($pays);
     ?>
   </div>
  <span class="forSm"><br><br><br><br><br><br></span>

<div class="underVideoDiv">
    <!--<br><br><br>-->


    <h4 class="mainHeading"><b>What is Lorem Ipsum?</b></h4><br>

    <div class="underHeadingDiv">

    <p class="content">What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has?</p>
    </div>

    <!--<br><br><br><br>-->
    <div class="underContentDiv">
    <p class="buttonsP"><img class="button1" src="{{asset('neostudio/ddd2.png')}}">&nbsp;&nbsp;&nbsp;<img class="button2" src="{{asset('neostudio/ddd.png')}}"></p>
    <p class="forSm" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">© 2020 Neoestudio Academia Online S.L.<br class="forSm">Todos los derechos reservados</p>
   <p class="forLg" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">© 2020 Neoestudio Academia Online S.L. Todos los derechos reservados</p>
    <img class="footerImage" src="{{asset('neostudio/5.png')}}">

  </div>

</div>




   </body>
</html>
