<?php

// The library is included

// Object is created
$am = $amount * 100;

// Fields are filled

if ($_SERVER['REMOTE_ADDR'] == "119.157.84.1051") {
    $stripe_key = env('STRIPE_KEY_TEST');
} else {
    $stripe_key = env("STRIPE_KEY");
}

$route = 'purchase';
if (isset($type) && $type != "books") {
    $route = 'create';
}
?>
        <!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Payment | Neoestudio</title>
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

        .underHeadingDiv {

        }

        .comienza {
            width: 60%;
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
            margin-top: 5%;
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
            width: 80%;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .botIm {
            width: 85%;
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
                width: 50%;
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .botIm {
                width: 70%;
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .size1 {
                font-size: 100%;
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
    </style>
</head>

<body style="">
<!-- Google Tag Manager (noscript) - SK 210422 -->

<!-- End Google Tag Manager (noscript) -->
<div style="background:url('{{asset('neostudio/Header1.png')}}');background-size: cover;">
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
                <li style=""><a href="{{url('equipo.html')}}">Equipo</a></li>
                <li style=""><a href="{{url('contacto')}}">Contacto</a></li>
                <li style=""><a href="{{url('registerate')}}">¡Regístrate!</a></li>
                <li style=""><a href="{{url('comienza')}}">¡Comienza ya!</a></li>
            </ul>

        </div>
    </nav>

    <span class="forSm"><br><br><br></span>
</div>
<br>

<span class="forLg"><br></span>
<div class="container text-center">
    <div class="form-group">
        <label>Amount</label>


        <input class="form-control" type="text" name="amount" value="<?php echo $amount; ?>" readonly/>
    </div>

</div>
<form action="{{ route('subscription.'.$route) }}" method="post" id="payment-form">
    @csrf
    <div class="form-group">
        <div class="card-header">
            <label for="card-element">
                Enter your credit card information
            </label>
        </div>
        <div class="card-body">
            <div id="card-element">
                <!-- A Stripe Element will be inserted here. -->
            </div>
            <!-- Used to display form errors. -->
            <div id="card-errors" role="alert"></div>
            <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
            <?php
            $tt = 'pr';
            if ($type != "books") {
                $package = $amount;

                switch ($package) {
                    case "120":
                        $tt = "9";
                        break;
                    case "80":
                        $tt = "10";
                        break;
                    case "540":
                        $tt = "8";
                        break;
                    case "540":
                        $tt = "8";
                        break;
                    case "45":
                        $tt = "7";
                        break;
                    case "75":
                        $tt = "6";
                        break;
                    case "360":
                        $tt = "5";
                        break;
                    case "15":
                        $tt = "4";
                        break;
                    case "110":
                        $tt = "3";
                        break;
                    case "25":
                        $tt = "1";
                        break;
                    default:
                        "";

                }
            }
            ?>
            <input type="hidden" name="plan" value="<?php echo $tt;?>"/>
        </div>
    </div>
    <div class="card-footer">
        <button id="card-button" class="btn btn-dark" type="button"
      data-secret="{{ $intent->client_secret }}">Subscribe</button>
    </div>
</form>
<script src="https://js.stripe.com/v3/"></script>
<script>
  const stripe = Stripe("{{ env('STRIPE_KEY') }}");

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                    );

                if (error) {
                    console.log(error.message);
                } else {
                    console.log('The card has been verified successfully...');
                    console.log(setupIntent);
                    console.log(setupIntent.payment_method);

                    setTimeout(function(){
                        $('form input[type="text"]').val(setupIntent.payment_method);
                        $('form input[type="submit"]').click();
                    }, 3000);
                }
            });
</script>

<div class="underVideoDiv">
    <!--<br><br><br>-->


    <h4 class="mainHeading"><b>What is Lorem Ipsum?</b></h4><br>

    <div class="underHeadingDiv">

        <p class="content">What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a
            galley of type and scrambled it to make a type specimen book it has?</p>
        <div class="container ssp2">
            <p style="text-align: center;">
                <img class="img-fluid" src="{{asset('Mano-tarjeta.png')}}">
            </p>
        </div>
    </div>

    <!--<br><br><br><br>-->
    <div class="underContentDiv">
        <p class="buttonsP">
            <img class="button1" src="{{asset('neostudio/ddd2.png')}}">&nbsp;&nbsp;&nbsp;<img class="button2" src="{{asset('neostudio/ddd.png')}}">
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
