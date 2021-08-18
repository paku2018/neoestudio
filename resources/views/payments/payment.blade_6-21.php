<?php

// The library is included
include 'redsys/apiRedsys.php';
// Object is created
$miObj = new RedsysAPI;

// Input values ​​that we have not changed for any example
$fuc = "351565320";
$terminal = "1";
$moneda = "978";
$trans = "0";
$url = "http://neoestudioguardiaciviloposiciones.es/paymentCallBackSuccess/$userId/$amount/$type/$payId";



$urlOKKO = "http://neoestudioguardiaciviloposiciones.es/paymentCallBackSuccess/$userId/$amount/$type/$payId";
$urlOKKO2 = "http://neoestudioguardiaciviloposiciones.es/paymentFailure/$userId";
$id = time();
$am = $amount * 100;

// Fields are filled
$miObj->setParameter("DS_MERCHANT_AMOUNT", $am);
$miObj->setParameter("DS_MERCHANT_ORDER", $id);
$miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
$miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
$miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
$miObj->setParameter("DS_MERCHANT_MERCHANTURL", $url);
$miObj->setParameter("DS_MERCHANT_URLOK", $urlOKKO);
$miObj->setParameter("DS_MERCHANT_URLKO", $urlOKKO2);
$miObj->setParameter("Ds_Merchant_Identifier", 'REQUIRED');

//Configuration data
$version = "HMAC_SHA256_V1";
$kc = 'I8c7RLGs35xGlPYuu95SYweaFHf + eHwA';//Key retrieved from CHANNELS
//$kc='sq7HjrUOBfKmC576ILgskD5srU870gJ7';
// Request parameters are generated
$request = "";
$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignature($kc);

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
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQ6ZC4F"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
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
<div class="text-center"><h2 style="font-family: Proxima Nova Soft;">Red Sys</h2></div>
<span class="forLg"><br></span>
<div class="container text-center">
    <div class="form-group">
        <label>Amount</label>
      
      
	<?php
      
	echo $_SERVER['QUERY_STRING'];
	  ?>
	  
        <input class="form-control" type="text" name="" value="<?php echo $amount; ?>" readonly/>
    </div>
    <form action="https://www.neoestudioguardiaciviloposiciones.es/paymentfinal" method="POST" id="paymentFrm">
 {{method_field('post')}}
    @csrf
<input type="hidden" name="_method" value="Post">
        <div class="panel-heading">
            <h3 class="panel-title">Plan Subscription with Stripe</h3>
			
            <!-- Plan Info -->
            <p>
                <b>Select Plan:</b>
             
                  <input type="text" name="subscr_plan" id="subscr_plan" class="field"  value="<?php echo $amount; ?>">
            </p>
        </div>
        <div class="panel-body">
            <!-- Display errors returned by createToken -->
            <div id="paymentResponse"></div>
			
            <!-- Payment form -->
            <div class="form-group">
                <label>NAME</label>
                <input type="text" name="name" id="name" class="field" placeholder="Enter name" required="" autofocus="">
            </div>
            <div class="form-group">
                <label>EMAIL</label>
                <input type="email" name="email" id="email" class="field" placeholder="Enter email" required="">
            </div>
            <div class="form-group">
                <label>CARD NUMBER</label>
                <div id="card_number" class="field"></div>
            </div>
            <div class="row">
                <div class="left">
                    <div class="form-group">
                        <label>EXPIRY DATE</label>
                        <div id="card_expiry" class="field"></div>
                    </div>
                </div>
                <div class="right">
                    <div class="form-group">
                        <label>CVC CODE</label>
                        <div id="card_cvc" class="field"></div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button>
        </div>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>


<script>
// Create an instance of the Stripe object
// Set your publishable API key
var stripe = Stripe('<?php echo 'pk_test_51IukhrBFGyC80xoFFMMHbhBegf61bYadqg9diyOWqRWgV7tBRkcI5W3ZET9ZYdaowpvyzIvwNviSv26UaZkt5URT00Dos9R045'; ?>');

// Create an instance of elements
var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        lineHeight: '1.4',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});
cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// Get payment form element
var form = document.getElementById('paymentFrm');

// Create a token when the form is submitted.
form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});

// Create single-use token to charge the user
function createToken() {
    stripe.createToken(cardElement).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error
            resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
        } else {
            // Send the token to your server
            stripeTokenHandler(result.token);
        }
    });
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
	
    // Submit the form
    form.submit();
}
</script>
<div class="underVideoDiv">
    <!--<br><br><br>-->


    <h4 class="mainHeading"><b>What is Lorem Ipsum?</b></h4><br>

    <div class="underHeadingDiv">

        <p class="content">What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a
            galley of type and scrambled it to make a type specimen book it has?</p>
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
