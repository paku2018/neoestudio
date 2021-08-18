<style>
    .active {
        color: white;
        text-decoration: underline;
        text-underline-position: under;
    }
</style>
<div style="background:url('neostudio/Header1.png');background-size: cover;">
    <img class="logoLeft" src="{{ asset('neostudio/1.png') }}">
    <img class="logoRight" src="{{ asset('neostudio/Logo.png') }}">
    <nav id="sv" class="navbar navbar-expand-lg navbar-dark">

        <button id="tB" style="border: none; position: absolute;right: 0 ;top: 0;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <img src="{{ asset('neostudio/Logo.png') }}" class="lgm" style="width: 100px;"><br>
            <span class="navbar-toggler-icon" style="float: right; border-color: transparent;margin-top: -45px;"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto" id="horizontal-style">
                <li style="font-size: larger;"><a href="{{url('/')}}" class="{{ (isset($slug) && $slug == "inicio") ? 'active' : '' }}">Inicio</a></li>
                <li style="font-size: larger;"><a href="{{url('oposicion')}}" class="{{ (isset($slug) && $slug == "oposicion") ? 'active' : '' }}">Oposición</a></li>
                <li style="font-size: larger;"><a href="{{url('formacion')}}" class="{{ (isset($slug) && $slug == "formacion") ? 'active' : '' }}">Formación</a></li>
                <li style="font-size: larger;"><a href="{{url('equipo')}}" class="{{ (isset($slug) && $slug == "equipo") ? 'active' : '' }}">Equipo</a></li>
                <li style="font-size: larger;"><a href="{{url('contacto')}}">Contacto</a></li>
                @if(!isset($user_data) || empty($user_data->id) === true)
                    <li style="font-size: larger;"><a href="{{url('regístrate')}}" class="{{ (isset($slug) && $slug == "") ? 'active' : '' }}">¡Regístrate!</a></li>
                @endif
                <li style="font-size: larger;">
                    <a href="{{url('comienza')}}" class="{{ (isset($slug) && $slug == "comienza") ? 'active' : '' }}">¡Comienza ya!</a></li>
                @if(isset($user_data) && empty($user_data->id) === false)
                    <li style="font-size: larger;"><a href="{{url('logout')}}">Logout</a></li>
                @endif
            </ul>

        </div>
    </nav>
    <div id="ww" style="display: none;">
        <a href="https://wa.me/34621231350"><img src="{{asset('neostudio/Whatapp-min.png')}}" style="position: fixed;bottom: 8px;right: 8px; width: 80px;"></a>
    </div>
    <span class="forSm"><br><br><br></span>
</div>