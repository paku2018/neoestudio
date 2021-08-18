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
        !function (f, b, e, v, n, t, s) {
            if (f.fbq)return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '468174144423257');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=468174144423257&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

    <script type="text/javascript">

        // A $( document ).ready() block.
        $(document).ready(function () {
            //console.log('asdasd')
            // var mainHeight = $('#mainTable td').height();
            //$('#payTable thead th').css('height', mainHeight + 'px')

            window.history.pushState("", "", 'https://neoestudioguardiaciviloposiciones.es/paymentHistory/<?php echo $userId; ?>');

        });

    </script>
    <title>Payment | Pays | Neoestudio</title>
    <style type="text/css">
        @font-face {
            font-family: "Proxima Nova Regular";
            src: url("{{asset('neostudio/pnswr.ttf')}}");
        }

        @font-face {
            font-family: "Proxima Nova Bold";
            src: url("{{asset('neostudio/pnsb.otf')}}");
        }

        @font-face {
            font-family: "Proxima Nova Soft";
            src: url("{{asset('neostudio/pss.ttf')}}");
        }

        b {
            font-family: Proxima Nova Bold;
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

        .underHeadingDiv {

        }

        .comienza {
            width: 100%;
            margin-left: 5%;
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

        }

        #navbarSupportedContent {
            padding-left: 30%;
        }

        .forLg {
            display: none;
        }

        .forSm {
            display: block;
        }

        .compIm {
            width: 100%;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .botIm {
            width: 95%;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .size1 {
            font-size: 75%;
        }

        .size2 {
            font-size: 70%;
        }

        .mar {
            margin-left: 0%;
            margin-right: 0%;
        }

        .fo {
            font-size: x-small;
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

            #main-video {
                object-fit: fill;
                width: 100%;
                height: 85vh;
            }

            .comienza {
                width: 40%;
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

            .compIm {
                width: 65%;
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .botIm {
                width: 60%;
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .size1 {
                font-size: 120%;
            }

            .size2 {
                font-size: 100%;
            }

            .mar {
                margin-left: 10%;
                margin-right: 10%;
            }

            .fo {
                font-size: small;
            }

        }

        .td-pad {
            padding: 5px 0 !important;
        }
    </style>
    <script type="text/javascript">
        function printPageArea(areaID) {
            var printContent = document.getElementById(areaID);
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        }
    </script>
</head>
`
<body style="">
<!-- Google Tag Manager (noscript) - SK 210422 -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQ6ZC4F"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
@if(empty($pay) === false)
    <script>
        fbq('track', 'Purchase', {currency: "USD", value: '{{$pay->amount}}'});
    </script>
@endif
<!-- End Google Tag Manager (noscript) -->
@include('menus')
<br>
<div class="text-center"><h2 style="font-family: Proxima Nova Bold;">¡Comienza Ya!</h2></div>
<span class="forLg"></span>
@if (!empty($message))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>Alerta!</h5>
        {{$message}}
    </div>
@endif
@if (!empty($message2))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5>Alerta!</h5>
        {{$message2}}
    </div>
@endif


@if(!empty($pay))
    <div class="container">
        <a onclick="printPageArea('printableArea')" class="btn btn-small btn-success" style="float: right; color: white;">Imprimir</a>
    </div>
    <div class="container" id="printableArea" style="text-align: center;">

        <h2>Recibo</h2>
        <br>
        <p><b>FUC of trade</b> : 351565320</p>
        <p><b>Name of business</b> : Neoestudio Guardia Civil</p>
        <p><b>URL del comercio</b> : https://neoestudioguardiaciviloposiciones.es/</p>
        <p><b>Importe de la operación</b> : {{$pay->amount}}</p>
        <?php /*p><b>Código de autorización de Redsys</b> : {{$pay->authCode}}</p */?>
        <p><b>Fecha / hora de la operación</b> : {{$pay->submitTime}}</p>
        @if($pay->type=="alumno")<p><b>Descripción del producto</b> : Curso online</p>@endif
        @if($pay->type=="books")<p><b>Descripción del producto</b> : Temario + Libro guía</p>@endif
        <br>
        <img src="{{asset('neostudio/maim.jpg')}}" style="width: 100%; height: auto;">

    </div>
@endif
<div class="text-center"><h2 style="font-family: Proxima Nova Soft;">Historial De Pagos</h2></div>
<span class="forLg"><br></span>
<div class="container">
    <?php
    $canEx = \App\Pay::where('userId', $userId)->where('status', 'pending')->where('process', 'auto')->exists();
    $reEx = \App\Pay::where('userId', $userId)->where('status', 'deleted')->where('process', 'auto')->exists();
    $meEx = \App\Pay::where('userId', $userId)->where('status', 'pending')->where('process', 'manual')->exists();

    ?>
    @if($canEx==true)
        <a class="btn btn-danger btn-small" href="{{url('cancelRecurring/'.$userId)}}" style="float: right;">Cancelar
            pago recurrente</a>
    @endif
    @if($reEx==true&&$meEx==false)
        <a class="btn btn-success btn-small" href="{{url('reactivateRecurring/'.$userId)}}" style="float: left;">Reactivar
            pago recurrente</a>
    @endif
</div>
<br><br>
<div class="container text-center">
    <div class="d-flex">
        <div class="d-block d-md-none">
            <table class="table table-striped" id="payTable" style="">
                <thead>
                <tr>
                    <th style="visibility: hidden;">Tipo de Pago</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($pays))
                    @php $cnt=0;@endphp
                    @foreach($pays as $pay)
                        <tr>
                            <td class="{{ ($cnt == 0) ? 'td-pad' : 'ntd-pad' }}">
                                <a class="btn btn-success" href="{{url('pay/'.$pay->userId.'/'.$pay->amount.'/'.$pay->type.'/'.$pay->id)}}">pagar</a>
                            </td>
                        </tr>
                        @php $cnt++;@endphp
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div style="overflow-x: auto;">
            <table class="table table-striped" id="mainTable" style="">
                <thead>
                <tr>
                    <th>id</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Tipo de Pago</th>
                    <th scope="col">Tiempo programado</th>
                    <th scope="col">Tiempo de presentación</th>
                    <th scope="col">Código de autorización</th>
                    <th scope="col">N. de Orden</th>

                    <th scope="col">Estado</th>

                </tr>
                </thead>
                <tbody>

                @if(!empty($pays))
                    @foreach($pays as $pay)
                        <tr>
                            @if($pay->status!="deleted")
                                <td>{{$pay->id}}</td>
                                <td>@if(!empty($pay->type)){{$pay->type}}@endif</td>
                                <td>@if(!empty($pay->amount)){{$pay->amount}}@endif</td>
                                <td>@if(!empty($pay->paymentType))
                                        @if($pay->paymentType=="once")
                                            Único pago
                                        @endif
                                        @if($pay->paymentType=="recurring")
                                            Recurrente
                                        @endif
                                    @endif
                                </td>
                                <td>@if(!empty($pay->scheduleTime)){{$pay->scheduleTime}}@endif</td>
                                <td>@if(!empty($pay->submitTime)){{$pay->submitTime}}@endif</td>
                                <td>@if(!empty($pay->authCode)){{$pay->authCode}}@endif</td>
                                <td>@if(!empty($pay->orderNumber)){{$pay->orderNumber}}@endif</td>
                                @if($pay->status=="pending")
                                    <td>pendiente</td>
                                @endif
                                @if($pay->status=="paid")
                                    <td>pagada</td>
                                @endif
                                @if($pay->status=="pending")
                                    @if($pay->process!="auto")
                                        <td class="d-none d-md-block ">
                                            <a class="btn btn-success" href="{{url('pay/'.$pay->userId.'/'.$pay->amount.'/'.$pay->type.'/'.$pay->id)}}">pagar</a>
                                        </td>
                                    @endif
                                @endif
                                @if($pay->status=="deleted")
                                    <td>{{$pay->status}}</td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                @endif


                </tbody>
            </table>
        </div>
    </div>
</div>
<span class="forLg"></span>

<!--<div class="text-center">
  <p>Alumnos de años consecutivos solo <b>360 € (30 € / mes)</b></p>
</div>-->

<div class="forSm">
    <?php
    $p = \App\Amount::where('amountType', 'books')->first();
    if ($p) {
        $price = $p->amount;
    }
    $rand = rand(1, 7);
    $str = \App\Amount::where('amountType', 'strike')->first();
    if ($str) {
        $priceStr = $str->amount;
    }
    ?>
    <div style="margin-left: 2%; margin-right: 2%;">
        @if($booksExists==false)
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{asset('neostudio/bot1a.png')}}" style="width: 75px;">
                        </div>
                        <div class="col-9" style="position: absolute;top: 50%;transform: translate(50%,-50%);">
                            <span style="font-size: 90%;"><b>Temario</b> +<br> <b>Libro guía</b><!--<br><p style="line-height: 1; font-size: 75%;">Últimos cupones<br> del -25%: <b>{{$rand}}</b></p>--></span>
                        </div>

                    </div>

                </div>
                <div class="col-3" style="transform: translateY(20%);">
                    <p style="font-size: 100%; line-height: 1"><span style="font-size: 75%;"><span style='color:red;text-decoration:line-through'>
  <span style='color:black'>@if(!empty($priceStr)){{$priceStr}}@endif</span>
</span> €</span> <b>@if(!empty($price)){{$price}}@endif</b> €</p>
                </div>
                <div class="col-3" style="transform: translateY(30%);">
                    @if(!empty($userId))
                        <a href="{{url('purchaseCo/'.$userId.'/'.'books')}}"><img src="{{asset('neostudio/comp.png')}}" style="width: 105px ; margin-left: -42px;"></a>
                    @endif
                    @if(empty($userId))
                        <a href="{{url('purchaseCo/'.'nul'.'/'.'books')}}"><img src="{{asset('neostudio/comp.png')}}" style="width: 105px ; margin-left: -42px;"></a>
                    @endif
                </div>


            </div>
        @endif
        <?php
        use Carbon\Carbon;
        $month = Carbon::now()->month;
        $ae = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->exists();
        $aNowSE = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->exists();
        if ($ae == true) {
            $a = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->first();
            $amount = $a->amount;
        }
        if ($aNowSE == true) {
            $aNowS = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->first();
            $aNowSA = $aNowS->amount;
        }
        ?>
        @if($alumnoExists==false)
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{asset('neostudio/bot2a.png')}}" style="width: 75px;">
                        </div>
                        <div class="col-9" style="position: absolute;top: 50%;transform: translate(50%,-38%);">
                            <p style="font-size: 90%;line-height: 1"><b>Curso <!--online-->online</b>
                                <!--<br><p style="line-height: 1; font-size: 75%; margin-top: -15px;">(ciclo de 12 meses<br> hasta examen oficial)Acceso 10 meses<br> (49,8 €/mes)</p>-->
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-3" style="transform: translateY(40%);">
                    <p style="font-size: 100%; line-height: 1;"><span style="font-size: 75%;"><span style='color:red;text-decoration:none;'>
  <span style='color:black'>@if(!empty($aNowSA)){{$aNowSA}}@endif</span>
</span> € / mes</span><br><b>@if(!empty($amount)){{$amount}}@endif</b> €</p>
                </div>
                <div class="col-3" style="transform: translateY(30%);">
                    @if(!empty($userId))

                        <a href="{{url('purchaseCo/'.$userId.'/'.'alumno')}}"><img src="{{asset('neostudio/comp.png')}}" style="width: 105px ; margin-left: -42px;"></a>

                    @endif

                    @if(empty($userId))
                        <a href="{{url('purchaseCo/'.'nul'.'/'.'alumno')}}"><img src="{{asset('neostudio/comp.png')}}" style="width: 105px ; margin-left: -42px;"></a>
                    @endif
                </div>

            </div>
        @endif


    </div>
    <br><br><br><br><br><br><br><br><br>
</div>
<!--For web screen start-->
<span class="forLg"></span>


<div class="forLg">

    <?php /*@if($booksExists==false)
        <span class="forLg"><br><br><br></span>
        <div class="row mar" style="">

            <div class="col-md-3 text-center" style="position: relative;">
                <img class="botIm" src="{{asset('neostudio/bot1a.png')}}" style="">
            </div>
            <?php
            $p = \App\Amount::where('amountType', 'books')->first();
            if ($p) {
                $price = $p->amount;
            }
            $rand = rand(1, 7);
            $str = \App\Amount::where('amountType', 'strike')->first();
            if ($str) {
                $priceStr = $str->amount;
            }
            ?>
            <div class="col-md-4" style="position: relative;">
                <p class="size1" style="margin: 0;position: absolute;top: 50%;left: 50%;
      -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);">
                    <b>Temario</b><br><span class="size2" style="visibility: hidden;">Últimos cupones del -25%: <b>{{$rand}}</b></span>
                </p>
            </div>

            <div class="col-md-2 text-center" style="position: relative;">
                <p style="font-size: 120%; margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);"><span style="font-size: 75%;"><span style='color:red;text-decoration:line-through'>
  <span style='color:black'>@if(!empty($priceStr)){{$priceStr}}@endif</span>
</span> €</span><br><b>@if(!empty($price)){{$price}}@endif</b> €</p>
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
    @if($alumnoExists==false)
        <span class="forLg"><br><br><br><br><br><br><br></span>

        <div class="row mar" style="">

            <div class="col-md-3 text-center" style="position: relative;">
                <img class="botIm" src="{{asset('neostudio/bot2a.png')}}" style="">
            </div>

            <div class="col-md-4" style="position: relative;">
                <p class="size1" style="margin: 0;position: absolute;top: 50%;left: 50%;
      -ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);text-align: left;"><b>Curso <!--online-->
                        online</b>
                    <!--<br><span class="size2">(Ciclo de 12 meses hasta examen oficial)Acceso 10 meses (49,8 €/mes)</span>-->
                </p>
            </div>
            <?php

            $month = Carbon::now()->month;


            $ae = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->exists();
            $aNowLE = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->exists();
            if ($ae == true) {
                $a = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->first();
                $amount = $a->amount;
            }
            if ($aNowLE == true) {
                $aNowL = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->first();
                $aNowLA = $aNowL->amount;
            }
            ?>
            <div class="col-md-2 text-center" style="position: relative;">
                <p style="font-size: 120%; margin: 0;position: absolute;top: 50%;left: 50%;-ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);"><span style="font-size: 80%;"><span style='color:red;text-decoration:none'>
  <span style='color:black'>@if(!empty($aNowLA)){{$aNowLA}}@endif</span>
</span> € / mes</span><br><b>@if(!empty($amount)){{$amount}}@endif</b> €</p>
            </div>

            <div class="col-md-3 col-3 text-center" style="position: relative;">
                @if(!empty($userId))
                    <a href="{{url('purchaseCo/'.$userId.'/'.'alumno')}}">
                        <img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
                @endif
                @if(empty($userId))
                    <a href="{{url('purchaseCo/'.'nul'.'/'.'alumno')}}">
                        <img class="compIm" src="{{asset('neostudio/comp.png')}}" style=""></a>
                @endif

            </div>

        </div>
    @endif
*/?>
    <span class="forLg"><br><br><br><br><br><br><br><br></span>
    <div style="visibility: hidden;">
        <?php
        dd($pays);
        ?>
    </div>
    <!--For web screen end-->
    <div class="underVideoDiv">
        <!--<br><br><br>-->


        <h4 class="mainHeading"><b>What is Lorem Ipsum?</b></h4><br>

        <div class="underHeadingDiv">

            <p class="content">What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting
                industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown
                printer took a galley of type and scrambled it to make a type specimen book it has?</p>
        </div>

        <!--<br><br><br><br>-->
        <div class="underContentDiv">
            <p class="buttonsP">
                <a style="text-decoration: none;" href="https://apps.apple.com/es/app/neoestudio-guardia-civil/id1531939360"><img class="button1" src="{{asset('neostudio/ddd2.png')}}"></a>&nbsp;&nbsp;&nbsp;<a href="https://play.google.com/store/apps/details?id=com.neostudio&hl=es_419" style="text-decoration: none;"><img class="button2" src="{{asset('neostudio/ddd.png')}}"></a>
            </p>
            <p class="forSm" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">
                © 2020 Neoestudio Academia Online S.L.<br class="forSm">Todos los derechos reservados</p>
            <p class="forLg" style="text-align: center; margin-bottom: -5%; margin-top: 20%; font-size: small;color: grey;">
                © 2020 Neoestudio Academia Online S.L. Todos los derechos reservados</p>
            <img class="footerImage" src="{{asset('neostudio/5.png')}}">

        </div>
    </div>
</div>
</body>
</html>