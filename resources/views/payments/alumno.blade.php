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

    <title>Payment | Alumno | Neoestudio</title>
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
        img.btn-submit{cursor: pointer;}
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
                <li style=""><a href="{{url('oposicion')}}">Oposici??n</a></li>
                <li style=""><a href="{{url('formacion')}}">Formaci??n</a></li>
                <li style=""><a href="{{url('equipo')}}">Equipo</a></li>
                <li style=""><a href="{{url('contacto')}}">Contacto</a></li>
                <li style=""><a href="" style="color:white;text-decoration:underline;text-underline-position:under;">Iniciar
                        sesi??n</a></li>
                <li style=""><a href="{{url('comienza')}}">??Comienza ya!</a></li>
            </ul>

        </div>
    </nav>


    <span class="forSm"><br><br><br></span>
</div>
<br>
<div class="text-center"><h2 style="font-family: Proxima Nova Soft">Curso online</h2></div>
<br>

<div class="container text-center">
    <p>Tipo&nbsp;&nbsp;:&nbsp;&nbsp;Alumno</p>
    <?php

    $jan1 = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->exists();
    $jan2 = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->exists();

    if ($jan1 == true) {
        $jan = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->first();
    }
    if ($jan2 == true) {
        $jan2 = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->first();
    }


    ?>
    <p>Pago anual (ahorra m??s)&nbsp;&nbsp;:&nbsp;&nbsp;{{$jan->amount}}&euro;</p>
    <p>Pago mensual&nbsp;&nbsp;:&nbsp;&nbsp;{{$jan2->amount}}&euro;</p>


    <form method="post" action="{{url('temario')}}">
        {{ csrf_field() }}
        <label>Seleccione el tipo de pago</label>

        <?php /*select class="form-control" name="number">
            <option value="once" selected>Pago anual (ahorra m??s)</option>
            <option value="recurring">Recurrente</option>

        </select */?>
        <input type="hidden" name="number" id="number" value="once"><br>
        <input type="hidden" name="userId" value="{{$userId}}">
        <p>
            <img class="button1 btn-submit" src="{{asset('neostudio/pago-anual.PNG')}}" data-val="once">&nbsp;&nbsp;&nbsp;
            <img class="button2 btn-submit" src="{{asset('neostudio/pago-mensual.PNG')}}" data-val="recurring">
        </p>
        <?php /*input class="btn btn-primary" type="submit" value="Enviar" value="Enviar" */?>
    </form>
</div>


<div class="underVideoDiv">
    <!--<br><br><br>-->


    <h4 class="mainHeading"><b>What is Lorem Ipsum?</b></h4><br>

    <div class="underHeadingDiv">

        <p class="content"></p>
    </div>

    <!--<br><br><br><br>-->
    <div class="underContentDiv">
        <?php /*p class="buttonsP">
            <img class="button1" src="{{asset('neostudio/ddd2.png')}}">&nbsp;&nbsp;&nbsp;<img class="button2"
                                                                                              src="{{asset('neostudio/ddd.png')}}">
        </p */?>
        <p class="forSm" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">
            ?? 2020 Neoestudio Academia Online S.L.<br class="forSm">Todos los derechos reservados</p>
        <p class="forLg" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">
            ?? 2020 Neoestudio Academia Online S.L. Todos los derechos reservados</p>
        <img class="footerImage" src="{{asset('neostudio/5.png')}}">
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        console.log("ready!");
        $(document).on('click', 'img.btn-submit', function () {
            var this_val = $(this).attr('data-val');
            $('#number').val(this_val);
            $(this).parents('form').submit();
        });
    });
</script>
</body>
</html>