@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Student Ranking</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('studentRankingsByid/'.$id)}}">Commulative Scores</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if (\Session::has('message'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> @lang('lng.Alert')!</h5>
          {!! \Session::get('message') !!}
    </div>
    @endif
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          
<?php 
$i=0;
?>
<div class="container" style="background-color: white; padding-top: 30px;">
  <div class="text-center">
    <h3>Global Ranking</h3><br>
  </div>
            @foreach($coursesArray as $key=>$value)
              <div class="row" style="margin-left:9%;">

              @foreach($value as $k=>$v)
              <div class="col-md-4">
                @if($k=="rankName")
                  <span style="font-size: 20px;">{{$v}}</span>&nbsp;&nbsp;
                @endif
                @if($k=="percentage")
                  @if(empty($v))
                  <b>Percentage : &nbsp;&nbsp;</b>null&nbsp;&nbsp;
                  @endif
                  @if(!empty($v))
                  <b>Percentage : &nbsp;&nbsp;</b>{{$v}}%&nbsp;&nbsp;
                  @endif
                @endif
                @if($i!=0)
                @if($k=="points")
                  @if(empty($v))
                  <b>Points : &nbsp;&nbsp;</b>null&nbsp;&nbsp;
                  @endif
                  @if(!empty($v))
                  <b>Points : &nbsp;&nbsp;</b>{{$v}}&nbsp;&nbsp;
                  @endif
                @endif
                @endif
              </div>
              @endforeach
              <?php
              $i=1; 
              ?>
              <br><br>
              </div>
            @endforeach
          </div>
          
        </div>
      </div>
    </section>
</div>


@endsection
@section('javascript')
<script type="text/javascript">
  $("#students").css('background-color','#6c757d');
 
</script>
@endsection