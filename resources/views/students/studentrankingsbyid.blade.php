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
          @foreach($resultArray as $key => $value)

            @foreach($value as $key1=>$value1)
            <div class="container" style="background-color: white">
              <div class="text-center">
              @if($key1=="folderName")
                <span style="font-size: 30px;">{{$value1}}</span><br><br>
              @endif
            </div>
              @if($key1=="courses")
                @foreach($value1 as $key2=>$value2)
                <div class="row" style="margin-left: 6%;">
                  @foreach($value2 as $key3=>$value3)
                  <div class="col-md-3">
                    @if($key3!="id"&&$key3!="created_at"&&$key3!="updated_at")
                    
                      
                      @if($key3=="rankName")
                        <b></b>{{$value3}}
                      @endif
                    
                      
                      @if($key3=="percentage")
                        <b>Percentage : &nbsp;&nbsp;</b>{{$value3}}
                      @endif
                      
                      
                      @if($key3=="points")
                        <b>Points : &nbsp;&nbsp;</b>{{$value3}}
                      @endif
                      
                      
                      @if($key3=="totalPoints")
                        <b>Total Points : &nbsp;&nbsp;</b>{{$value3}}
                      @endif

                     
                     
                    @endif
                  </div>
                  @endforeach
                </div>
                  <br>    
                @endforeach
              @endif
              @if($key1=="withoutBaremo")
              <div class="row" style="margin-left: 6%;">
                
                @foreach($value1 as $key4 => $value4)
                  <div class="col-md-3">
                      @if($key4=="rankName")
                        {{$value4}}&nbsp;&nbsp;
                      @endif
                      @if($key4=="percentage")
                        <b>Percentage : &nbsp;&nbsp;</b>{{$value4}}&nbsp;&nbsp;
                      @endif
                      @if($key4=="points")
                        <b>Points : &nbsp;&nbsp;</b>{{$value4}}&nbsp;&nbsp;
                      @endif
                      @if($key4=="totalPoints")
                        <b>Total Points : &nbsp;&nbsp;</b>{{$value4}}
                      @endif
                  </div>
                   
                @endforeach

              </div>
                <br>
              @endif
              @if($key1=="withBaremo")
              <div class="row" style="margin-left:6% ">
                @foreach($value1 as $key5 => $value5)
                <div class="col-md-3">
              
                      @if($key5=="rankName")
                        <b></b>{{$value5}}
                      @endif
                      @if($key5=="percentage")
                        <b>Percentage : &nbsp;&nbsp;</b>{{$value5}}
                      @endif
                      @if($key5=="points")
                        <b>Points : &nbsp;&nbsp;</b>{{$value5}}
                      @endif
                      @if($key5=="totalPoints")
                        <b>Total Points : &nbsp;&nbsp;</b>{{$value5}}
                      @endif
                    </div>
                   
                @endforeach
              </div>
              @endif
            </div>
            @endforeach
            <br><br>
            
          @endforeach
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