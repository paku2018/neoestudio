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
      src: url("neostudio/pr.otf");
    }
    @font-face {
      font-family: "Proxima Nova Bold";
      src: url("neostudio/pb.otf");
    }
    @font-face {
  font-family: "Proxima Nova Soft";
  src: url("neostudio/pss.ttf");
}
b{
  font-family: Proxima Nova Soft;
}
    body{
      font-family: Proxima Nova Regular;
      background: url('neostudio/bodyback.jpg');
      background-size: 100% 100%;
    }
    #tB:focus{
    outline: 1px;
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
      .mU {
  list-style-type: none;
}

.liU:before {
  content: '-';
  position: absolute;
  margin-left: -20px;
}

         #main-container {
    width: 100%;
   margin-top: 0;
}
#main-video {
    object-fit: fill;
    width: 100%;
    height: 100%;
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
    text-align: center;
  }
  .underHeadingDiv{

  }
  .content{
    margin-left: 5%; margin-right: 1%;
  }
  .underContentDiv{
    background:url(neostudio/4.png); background-size: contain; background-repeat: no-repeat;
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
  .fig{
    font-size:60%;
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


@media only screen and (min-width: 1000px) {
  body{
    background: url('neostudio/bodyback.jpg');
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
  background:url('neostudio/Header1.png');
        background-size: 100% 100%; padding-top: 2%;padding-bottom: 4%;border:0;
}
  .underVideoDiv{
    background:url(neostudio/4.png); background-size: contain; background-repeat: no-repeat;
  }
  .mainHeading{
    padding-top: 0;
    text-align: center;
  }
  .underHeadingDiv{
    margin-left: 20%; margin-right: 20%;
  }
  .content{
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
    left: 0; bottom: 0;width: 10%;
  }
  .fig{
    font-size:100%;
  }
  #navbarSupportedContent{
    padding-left: 0;

  }
  .forLg{
    display: block;
  }
  .forSm{
    display: none;
  }
}
      </style>
   </head>

   <body>
    <div style="background:url('neostudio/Header1.png');background-size: cover;">
    <img class="logoLeft" src="neostudio/1.png">
    <img class="logoRight" src="neostudio/Logo.png">
    <nav id="sv" class="navbar navbar-expand-lg navbar-dark">

        <button id="tB" style="border: none; position: absolute;right: 0 ;top: 0;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <img src="neostudio/Logo.png" class="lgm" style="width: 100px;"><br>
          <span class="navbar-toggler-icon" style="float: right; border-color: transparent;margin-top: -25px;"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >

          <ul class="navbar-nav mr-auto" id="horizontal-style">
            <li style=""><a href="{{url('/')}}" style="color:white;text-decoration:underline;text-underline-position:under;">Inicio</a></li>
            <li style=""><a href="{{url('oposicion')}}">Oposici??n</a></li>
            <li style=""><a href="{{url('formacion')}}">Formaci??n</a></li>
            <li style=""><a href="{{url('equipo')}}">Equipo</a></li>
            <li style=""><a href="{{url('contacto')}}">Contacto</a></li>
            <li style=""><a href="{{url('registerate')}}">??Reg??strate!</a></li>
            <li style=""><a href="{{url('comienza')}}">??Comienza ya!</a></li>
          </ul>

        </div>
      </nav>
      <span class="forSm"><br><br><br></span>
      </div>

      <div id="main-container" style="">

    <div style="">
    <video controls playsinline autoplay muted loop id="main-video">
      <source src="neostudio/vid3.mov">

    </video>
    <!--<img src="3.png" id="vi" style="position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%,-50%);" onclick="play()">  -->
  </div>
    <div class="underVideoDiv">
    <!--<br><br><br>-->

      <br>
    <h4 class="mainHeading"><b>??Por qu?? Neoestudio es tu academia online?</b></h4><br>

    <div class="underHeadingDiv">

    <p class="content">
      Porque es la ??nica academia que te va a <b>impulsar</b> al ??xito y porque cuenta:
      <ul class="mU">
        <li class="liU">Con un <b>ranking masivo</b> en tiempo real desarrollado en la ??nica aplicaci??n nativa espec??fica para la oposici??n de ingreso a la Guardia Civil.</li>
        <li class="liU">Con <b>r??plicas de oposici??n</b> que aplican la puntuaci??n del <b>baremo</b> y la f??mula de psicot??cnicos (<b>Campana de Gauss</b>).</li>
        <li class="liU">Con m??s de 1000 <b>im??genes</b> y <b>esquemas</b> de <b>alta calidad</b>.</li>
        <li class="liU">Con un <b>temario sintetizado</b> con todas las <b>palabras clave marcadas</b> por jerarqu??a de importancia.</li>
        <li class="liU">Con un <b>libro guia explicativo</b> desarrollado con ejemplos pr??cticos y ex??menes oficiales de a??os anteriores, ejercicios, definiciones, etc.</li>
        <li class="liU">Con un <b>audiolibro profesional</b>.</li>
        <li class="liU">Con un sistema de <b>ranking por objetivos</b> que miden el rendimiento y aumentan la competitividad con tus compa??eros.</li>
        <li class="liU">Formada por un atento <b>equipo de suboficiales</b> de la Guardia Civil.</li>
        <li class="liU">Con una amplia cola de <b>proyectos innovadores</b> que aplican las <b>t??cnicas de estudio m??s eficaces</b>.</li>
      </ul>
    </p>
    </div>

    <!--<br><br><br><br>-->
    <div class="underContentDiv">
    <p class="buttonsP"><img class="button1" src="neostudio/ddd2.png">&nbsp;&nbsp;&nbsp;<img class="button2" src="neostudio/ddd.png"></p>
  <p id="foT" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">?? 2020 Neoestudio Academia Online S.L.<br class="forSm">  Todos los derechos reservados.<br class="forSm"></p>
    <img class="footerImage" src="neostudio/5.png">
  </div>
</div>
</div>
<script type="text/javascript">
</script>
   </body>
</html>