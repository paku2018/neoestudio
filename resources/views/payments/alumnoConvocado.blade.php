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

    <!-- Google Tag Manager - SK 210422 -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TQ6ZC4F');</script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics - SK 210422 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B9GP0K48SR"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-B9GP0K48SR');
    </script>
    <!-- End Global site tag (gtag.js) -->

    <!-- Facebook Pixel Code - Sk 210422 -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '468174144423257');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=468174144423257&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

    <title>Payment | Alumno Convocado | Neoestudio</title>
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

        b {
            font-family: Proxima Nova Soft;
        }

        body {
            font-family: Proxima Nova Regular;
            background: url("{{asset('neostudio/bodyback.jpg')}}");
            background-size: 100% 100%;
        }

        #tB:focus {
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

        a {
            color: #777;
        }

        a:hover {
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

        .logoLeft {
            width: 30%;
            height: auto;
            position: absolute;
            left: 1px;
            top: 0px;
            z-index: 1;
        }

        .logoRight {
            display: none;
        }

        .firstLi {
            padding-right: 75px;
        }

        #sv {

        }

        .underVideoDiv {

        }

        .mainHeading {
            display: none;
            margin-left: 4%;
        }

        .forLg {
            display: none;
        }

        .forSm {
            display: block;
        }

        .underHeadingDiv {

        }

        .content {
            display: none;
            margin-left: 5%;
            margin-right: 1%;
        }

        .underContentDiv {
            background: url("{{asset('neostudio/4.png')}}");
            background-size: contain;
            background-repeat: no-repeat;
        }

        .buttonsP {
            margin-left: 15%;
        }

        .button1 {
            width: 40%;
        }

        .button2 {
            width: 40%;
        }

        .footerImage {
            left: 0;
            bottom: 0;
            width: 20%;
        }

        .handClass {
            width: 100px;
            margin-top: 5px;
        }

        .cara {
            margin-top: 20%;
        }

        #navbarSupportedContent {
            padding-left: 30%;
        }

        input[type="text"]::placeholder {
            text-align: center;
        }

        @media only screen and (min-width: 1000px) {
            body {
                background: url("{{asset('neostudio/bodyback.jpg')}}");
                background-size: 100% 100%;
            }

            a {
                color: #777;
            }

            a:hover {
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

            #forLg {
                display: block;
            }

            #forSm {
                display: none;
            }

            #main-video {
                object-fit: fill;
                width: 100%;
                height: 85vh;
            }

            .logoLeft {
                width: 10%;
                height: auto;
                position: absolute;
                left: 1px;
                top: 0px;
                z-index: 1;
            }

            .logoRight {
                display: block;
                width: 9%;
                height: auto;
                position: absolute;
                right: 2%;
                top: 0px;
                z-index: 1;
            }

            .firstLi {

            }

            #horizontal-style {
                display: table;
                width: 70%;
                margin-left: 5%;
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

            #sv {
                background: url("{{asset('neostudio/Header1.png')}}");
                background-size: 100% 100%;
                padding-top: 2%;
                padding-bottom: 4%;
                border: 0
            }

            .underVideoDiv {
                margin-top: -150px;
                background: url("{{asset('neostudio/4.png')}}");
                background-size: contain;
                background-repeat: no-repeat;
            }

            .mainHeading {
                display: block;
                visibility: hidden;
                margin-left: 15%;
                padding-top: 5%;
            }

            .underHeadingDiv {
                margin-left: 20%;
                margin-right: 20%;
            }

            .content {
                display: block;
                visibility: hidden;
                margin-left: 0;
                margin-right: 0;
            }

            .underContentDiv {
                background: url();
            }

            .buttonsP {
                margin-left: 35%;
                padding-top: 5%;
            }

            .button1 {
                width: 20%;
            }

            .button2 {
                width: 20%;
            }

            .footerImage {
                left: 0;
                bottom: 0;
                width: 10%;
            }

            .handClass {
                width: 375px;
                margin-top: -100px;
            }

            #navbarSupportedContent {
                padding-left: 0;
            }

            .cara {
                margin-top: 0;
            }

            .forLg {
                display: block;
            }

            .forSm {
                display: none;
            }

            input[type="text"]::placeholder {
                text-align: center;
                vertical-align: middle;
            }
        }
    </style>
</head>

<body style="">
<!-- Google Tag Manager (noscript) - SK 210422 -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQ6ZC4F"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div style="background:url('{{asset('neostudio/Header1.png')}}'); background-size: cover;">
    <img class="logoLeft" src="{{asset('neostudio/1.png')}}">
    <img class="logoRight" src="{{asset('neostudio/Logo.png')}}">
    <nav id="sv" class="navbar navbar-expand-lg navbar-dark">

        <button id="tB" style="border: none; position: absolute;right: 0 ;top: 0;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <img src="{{asset('neostudio/Logo.png')}}" class="lgm" style="width: 100px;"><br>
            <span class="navbar-toggler-icon" style="float: right; border-color: transparent;margin-top: -25px;"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto" id="horizontal-style">
                <li style=""><a href="{{url('/')}}">Inicio</a></li>
                <li style=""><a href="{{url('oposicion')}}">Oposición</a></li>
                <li style=""><a href="{{url('formacion')}}">Formación</a></li>
                <li style=""><a href="{{url('equipo')}}">Equipo</a></li>
                <li style=""><a href="{{url('contacto')}}">Contacto</a></li>
                <li style=""><a href="" style="color:white;text-decoration:underline;text-underline-position:under;">Iniciar
                        sesión</a></li>
                <li style=""><a href="{{url('comienza')}}">¡Comienza ya!</a></li>
            </ul>

        </div>
    </nav>


    <span class="forSm"><br><br><br></span>
</div>
<br>
<div class="text-center"><h2 style="font-family: Proxima Nova Soft">Continuación curso online</h2></div>
<br>
<?php
$existsA = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
?>
@if($existsA==false)
    <br><br><br><br><br><br><br>
    <h2 style="text-align: center;">Tienes que comprar Curso onine antes de Continuación curso online</h2>
    <br><br><br><br><br>
    <p class="" style="visibility: hidden;">
        Porque es la única academia que te va a <b>impulsar</b> al éxito y porque cuenta:
        Porque es la única academia que te va a <b>impulsar</b> al éxito y porque cuenta:


    </p>
@endif
@if($existsA==true)
    <div class="container text-center">
        <p>Tipo&nbsp;&nbsp;:&nbsp;&nbsp;Alumno Convocado</p>
        <?php
        $jan1 = \App\Price::where('month', '1')->where('studentType', 'Alumno Convocado')->exists();

        if ($jan1 == true) {
            $jan = \App\Price::where('month', '1')->where('studentType', 'Alumno Convocado')->first();

        }
        $feb1 = \App\Price::where('month', '2')->where('studentType', 'Alumno Convocado')->exists();
        if ($feb1 == true) {
            $feb = \App\Price::where('month', '2')->where('studentType', 'Alumno Convocado')->first();

        }
        $mar1 = \App\Price::where('month', '3')->where('studentType', 'Alumno Convocado')->exists();
        if ($mar1 == true) {
            $mar = \App\Price::where('month', '3')->where('studentType', 'Alumno Convocado')->first();

        }

        $apr1 = \App\Price::where('month', '4')->where('studentType', 'Alumno Convocado')->exists();
        if ($apr1 == true) {
            $apr = \App\Price::where('month', '4')->where('studentType', 'Alumno Convocado')->first();

        }
        $may1 = \App\Price::where('month', '5')->where('studentType', 'Alumno Convocado')->exists();
        if ($may1 == true) {
            $may = \App\Price::where('month', '5')->where('studentType', 'Alumno Convocado')->first();

        }
        $jun1 = \App\Price::where('month', '6')->where('studentType', 'Alumno Convocado')->exists();
        if ($jun1 == true) {
            $jun = \App\Price::where('month', '6')->where('studentType', 'Alumno Convocado')->first();

        }
        $jul1 = \App\Price::where('month', '7')->where('studentType', 'Alumno Convocado')->exists();
        if ($jul1 == true) {
            $jul = \App\Price::where('month', '7')->where('studentType', 'Alumno Convocado')->first();

        }
        $aug1 = \App\Price::where('month', '8')->where('studentType', 'Alumno Convocado')->exists();
        if ($aug1 == true) {
            $aug = \App\Price::where('month', '8')->where('studentType', 'Alumno Convocado')->first();

        }
        $sep1 = \App\Price::where('month', '9')->where('studentType', 'Alumno Convocado')->exists();
        if ($sep1 == true) {
            $sep = \App\Price::where('month', '9')->where('studentType', 'Alumno Convocado')->first();

        }
        $oct1 = \App\Price::where('month', '10')->where('studentType', 'Alumno Convocado')->exists();
        if ($oct1 == true) {
            $oct = \App\Price::where('month', '10')->where('studentType', 'Alumno Convocado')->first();

        }
        $nov1 = \App\Price::where('month', '11')->where('studentType', 'Alumno Convocado')->exists();
        if ($nov1 == true) {
            $nov = \App\Price::where('month', '11')->where('studentType', 'Alumno Convocado')->first();

        }
        $dec1 = \App\Price::where('month', '12')->where('studentType', 'Alumno Convocado')->exists();
        if ($dec1 == true) {
            $dec = \App\Price::where('month', '12')->where('studentType', 'Alumno Convocado')->first();

        }
        ?>
        <div style="overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Jan</th>
                    <th scope="col">Feb</th>
                    <th scope="col">Mar</th>
                    <th scope="col">Apr</th>
                    <th scope="col">May</th>
                    <th scope="col">Jun</th>
                    <th scope="col">Jul</th>
                    <th scope="col">Aug</th>
                    <th scope="col">Sep</th>
                    <th scope="col">Oct</th>
                    <th scope="col">Nov</th>
                    <th scope="col">December</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($jan)&&!empty($feb)&&!empty($mar)&&!empty($apr)&&!empty($may)&&!empty($jun)&&!empty($jul)&&!empty($aug)&&!empty($sep)&&!empty($oct)&&!empty($nov)&&!empty($dec)&&!empty($jan))
                    <tr>

                        <td>{{$jan->amount}}</td>
                        <td>{{$feb->amount}}</td>
                        <td>{{$mar->amount}}</td>
                        <td>{{$apr->amount}}</td>
                        <td>{{$may->amount}}</td>
                        <td>{{$jun->amount}}</td>
                        <td>{{$jul->amount}}</td>
                        <td>{{$aug->amount}}</td>
                        <td>{{$sep->amount}}</td>
                        <td>{{$oct->amount}}</td>
                        <td>{{$nov->amount}}</td>
                        <td>{{$dec->amount}}</td>

                    </tr>
                @endif


                </tbody>
            </table>
        </div>
        <form method="post" action="{{url('temario2')}}">
            {{ csrf_field() }}
            <label>¿Cuántas cuotas quieres?</label>
            <select class="form-control" name="number">
                <option value="1" selected>At once</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <input type="hidden" name="userId" value="{{$userId}}"><br>
            <input class="btn btn-primary" type="submit" value="Enviar" value="submit">
        </form>
    </div>
@endif


<div class="underVideoDiv">
    <!--<br><br><br>-->


    <h4 class="mainHeading"><b>What is Lorem Ipsum?</b></h4><br>

    <div class="underHeadingDiv">

        <p class="content"></p>
    </div>

    <!--<br><br><br><br>-->
    <div class="underContentDiv">
        <p class="buttonsP">
            <img class="button1" src="{{asset('neostudio/ddd2.png')}}">&nbsp;&nbsp;&nbsp;<img class="button2"
                                                                                              src="{{asset('neostudio/ddd.png')}}">
        </p>
        <p class="forSm" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">
            © 2020 Neoestudio Academia Online S.L.<br class="forSm">Todos los derechos reservados</p>
        <p class="forLg" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">
            © 2020 Neoestudio Academia Online S.L. Todos los derechos reservados</p>
        <img class="footerImage" src="{{asset('neostudio/5.png')}}">
    </div>
</div>


</body>
</html>