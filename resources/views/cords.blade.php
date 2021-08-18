<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css')}}">
<style>
body {
  font-family: "Lato", sans-serif;
}
*:focus{
	border:none;
	outline: 0 !important;
}
.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 68px;
  left: 0;
  background-color: white;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 30px;
}

.sidebar a {
  padding: 8px 8px 20px 32px;
  text-decoration: none;
  font-size: 15px;
  font-weight: bold;
  color: #053067;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  
}

.sidebar .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: transparent;
  color: white;
  padding: 10px 15px;
  border: transparent;

}

.openbtn:hover {
  
}

#main {
  transition: margin-left .5s;
  
}
#img{
	width: 130px;
}
#last{
	text-align: end;
}
#name{
	display: none;
}
.forLg{
	display: none;
}
.forSm{
	display: block;
}
#tablex{
	overflow-x: auto;
	display: block;
}
.button1 {

  border: none;
  color: white;
  padding: 40px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  border-radius: 50%;
}
.button2 {

  border: none;
  color: white;
  padding: 40px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  border-radius: 50%;
}
#fot{
	position: relative;
	margin-bottom: 0;
}

@media only screen and (min-width: 800px) {
	#tablex{
		overflow-x: auto;
		display: table;
	}
	#img{
		
		width: 250px;
	}
	#last{
		text-align: end;

	}
	.sidebar{
		top:86px;
	}
	#naav{
		padding: 10px;
	}
	#name{
		display: block;
	}
	.forLg{
	display: block;
	}
	.forSm{
		display: none;
	}
	#rightD{
		margin-top: 10px;
	}
	#fot{
		padding-left: 200px;

	}
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
</style>
</head>
<body style="background-color: #edf5f8;">

<div id="mySidebar" class="sidebar">
  
  <a href="{{url('web/parts')}}"> <img src="{{asset('website/4.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Parte diario</a>
  <a href="{{url('web/expenses')}}"> <img src="{{asset('website/5.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Mis gastos</a>
  <a href="{{url('web/documents')}}"> <img src="{{asset('website/6.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Documentos</a>
  <a href="{{url('web/epis')}}"> <img src="{{asset('website/10.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;EPIS</a>
  <a href="{{url('web/blog')}}"> <img src="{{asset('website/7.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Blog</a>
  <a href="{{url('web/holidays')}}"> <img src="{{asset('website/8.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Solicitar vacaciones</a>
  <a href="{{url('web/works')}}"> <img src="{{asset('website/9.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Orden de trabajo</a>
  <a  style="border-right: 4px solid #053067;" href="{{url('web/times')}}"> <img src="{{asset('website/9.png')}}" style="width: 24px;">&nbsp;&nbsp;&nbsp;Time Tracking</a>
</div>

<div id="main" style="">
	<div style="background-color:#053067; display: table; width: 100%; " id="naav">
	  <div style="display: table-cell;">
	  	<button class="openbtn" id="tog" onclick="openNav()">☰</button> <img src="{{asset('website/20.png')}}" id="img">  
	  </div>
	  <?php
	  	$user=Auth::user();
	  	use Carbon\Carbon;
	   ?>
	  <div style="display: table-cell;" id="last">
	  	<div class="btn-group" style="">
		  <button type="button" style="background: transparent; border: none; color: white;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <span class="forLg">@if($user){{$user->name}}@endif&nbsp;@if(!empty($user))<img src="{{asset($user->image)}}" style="width: 65px;">@endif</span>
		    <span class="forSm">@if(!empty($user))<img src="{{asset($user->image)}}" style="width: 60px;">@endif</span>
		  </button>
		  <div class="dropdown-menu dropdown-menu-right" id="rightD">
		    <div class="container">
		    <div class="text-center" style="line-height: 17px;">
		    	@if(!empty($user))<img src="{{asset($user->image)}}" style="width: 100px;">@endif
		    	<p style="border-bottom: 1px solid #053067;">Perfil</p>
		    	<p style="border-bottom: 1px solid #053067;">Acerca</p>
		    	<p style="border-bottom: 1px solid #053067;">Configuracion</p>
		    	<p style="border-bottom: 1px solid #053067;">Salir</p>
		    	<p style="border-bottom: 1px solid #053067;">Ajustus</p><br>
		    	<a href="{{url('logout-user')}}" style="text-decoration: none;"><p style="color: red">Logout</p></a>
		    </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="container">
		@if (!empty($started))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert !</h5>
                          {{$started}}
                    </div>
                    @endif
                    @if (!empty($message))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Alert !</h5>
                          {{$message}}
                    </div>
                    @endif
		<br>
		<div class="text-center" style="color: #053067;"><h2><b>Geolocation</b></h2></div>
		<br>
		<div class="row">
			<div class="col-md-6 col-6 text-center">
				<a id="ad" onclick="getLocation()" style="text-decoration: none">
					<div class="button1" style="background-color: grey">Start</div>
				</a>
			</div>
			<div class="col-md-6 col-6 text-center">
				<a style="text-decoration: none" href="{{url('web/pause')}}">
					<div class="button2" style="background-color: grey">Pause</div>
				</a>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-6 col-6 text-center">
				Start Time
			</div>
			<div class="col-md-6 col-6 text-center">
				@if(!empty($time)){{$time->startTime}}@endif
			</div>
			<br>
			<div class="col-md-6 col-6 text-center">
				Pause Time
			</div>
			<div class="col-md-6 col-6 text-center">
				@if(!empty($time)){{$time->endTime}}@endif
			</div>
			<div class="col-md-6 col-6 text-center">
				Total Time
			</div>
			<div class="col-md-6 col-6 text-center">
				<?php 
					if(!empty($time->startTime)&&!empty($time->endTime)){
						$secs2=Carbon::parse($time->endTime)->diffInSeconds(Carbon::parse($time->startTime));
			  			$tot2=gmdate('H:i:s', $secs2);
					}
					?>
					@if(!empty($tot2))
					{{$tot2}}
					@endif
			
			</div>
		</div>
		<br>
		<div style="background-color: white;">
			<p style="padding-left: 10px;padding-top: 10px; padding-bottom: 10px; border-bottom: 1px solid #053067; color: #053067;"><img src="{{asset('website/15.png')}}" style="width: 20px;">&nbsp;<b>Historia</b></p>
			<table class="table table-striped table-bordered" id="tablex" style="margin-top: -16px;">
			  <thead>
			    <tr style="border-top: none; text-align: center;">
			      
			      <th scope="col" style="border-bottom: 1px solid #053067; border-right: 1px solid white; color: #053067;">Fecha</th>
			      <th scope="col" style="border-bottom: 1px solid #053067; border-right: 1px solid white; color: #053067;">Start</th>
			      <th scope="col" style="border-bottom: 1px solid #053067; border-right: 1px solid white; color: #053067;">End</th>
			      <th scope="col" style="border-bottom: 1px solid #053067; border-right: 1px solid white; color: #053067;">Total</th>
			      <th scope="col" style="border-bottom: 1px solid #053067; border-right: 1px solid white; color: #053067;">Latitude - Longitude</th>
			    
			      
			      
			     
			    </tr>
			  </thead>
			  <tbody>
			  	
			    
			   
			    
			    
			    
			  </tbody>
			</table>
		</div>


	</div>
	
	<br><br>
	<div style="background-color: #053067; display: table; width: 100%;padding-top:15px;
		padding-bottom: 10px;" id="fot">
		
			<p style="display: table-cell; color: white;"><span class="forLg">Copyright @ 2020, Agefred platform, INC All Rights Reserved</span><span class="forSm">Copyright @ 2020, Agefred platform</span></p>
			<p style="display: table-cell; color: white">Privacy Policy</p>
		
	</div>
	
</div>

<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("tog").onclick=closeNav;
  //document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.getElementById("tog").onclick=openNav;
}

    
</script>
<script>
$(document).ready(function() {
	
    $('#tablex').DataTable();

});
var x = document.getElementById("demo");
getLocation();
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {

  console.log(position.coords.latitude);
  console.log(position.coords.longitude);
  document.getElementById("ad").href="start/"+position.coords.latitude+"/"+position.coords.longitude; 
}

</script>

   
</body>
</html> 
