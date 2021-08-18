@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Chat Room</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('chats')}}">Chat Room</a></li>
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
    @if (\Session::has('message2'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5> @lang('lng.Alert')!</h5>
          {!! \Session::get('message2') !!}
    </div>
    @endif
    <section id="cha" class="content card container" style="overflow-y: scroll; height: 500px;">
      @foreach($chats as $chat)
      <div class="row">
        
          <?php
                $user=\App\User::find($chat->userId);
                
                ?>
                @if(!empty($user))
            @if($chat->sender=="teacher")
            <div class="col-md-6">
              
            </div>
            <div class="col-md-6">
              @if($chat->type=="message")
                <p style="background-color: lightblue; color: white; background-size: contain">{{$chat->message}}<span style="float: right;">{{$chat->created_at}}</span></p>
                <p style="float: right; margin-top: -20px;"><?php
                $user=\App\User::find($chat->userId);
                ?>
                  @if(!empty($user)){{$user->name}}@endif
                </p>
              @endif
              @if($chat->type!="message")
                @if(!empty($chat->file))
                  <p style="background-color: lightblue; color: white;"><a  class="btn btn-warning" href="{{url('downloadChat/'.$chat->id)}}">{{$chat->fileName}} <i class="fas fa-download"></i></a> <span style="float: right;">{{$chat->created_at}}</span></p>
                  <p style="float: right; margin-top: -20px;"><?php
                $user=\App\User::find($chat->userId);
                ?>
                  @if(!empty($user)){{$user->name}}@endif
                </p>
                @endif
              @endif
            </div>
            @endif
            @if($chat->sender=="student")
            <div class="col-md-6">
              @if($chat->type=="message")
                <p style="background-color: lightgrey; color: white;">{{$chat->message}}
                 <span style="float: right;">{{$chat->created_at}}</span>
               </p>
               <p style="float: right; margin-top: -20px;"><?php
                $user=\App\User::find($chat->userId);
                ?>
                  @if(!empty($user)){{$user->name}}@endif
                </p>
                
              @endif
              @if($chat->type!="message")
                @if(!empty($chat->file))
                 <p style="background-color: lightgrey; color: white;"> <a  class="btn btn-warning" href="{{url('downloadChat/'.$chat->id)}}">{{$chat->fileName}}<i class="fas fa-download"></i></a><span style="float: right;">{{$chat->created_at}}</span></p>
                 <p style="float: right; margin-top: -20px;"><?php
                $user=\App\User::find($chat->userId);
                ?>
                  @if(!empty($user)){{$user->name}}@endif
                </p>
                @endif
              @endif
            </div>
            <div class="col-md-6"></div>
            @endif
            @endif
          </div>
          @endforeach
          <!-- /.card -->

          
          <!-- /.card -->
        
      
    </section>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <form method="post" action="{{url('storeChatTeacher')}}">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="message" placeholder="Enter Your Message">
            <input type="hidden" name="teacherId" value="@if(Auth::user()){{Auth::user()->id}}@endif">
            <input type="hidden" name="field1x" value="@if(!empty($studentId)){{$studentId}}@endif">
            <input class="btn btn-default" type="submit" value="submit">
          </form>
        </div>
        <div class="col-md-6">
          <form method="post" action="{{url('storeChatTeacher')}}"  enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" class="form-control" name="file">
            <input type="hidden" name="teacherId" value="@if(Auth::user()){{Auth::user()->id}}@endif">
            <input type="hidden" name="field1x" value="@if(!empty($studentId)){{$studentId}}@endif">
            <input class="btn btn-default" type="submit" value="submit">
          </form>
        </div>
      </div>
    </div>
</div>


@endsection
@section('javascript')
<script type="text/javascript">
  $("#chat").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<script type="text/javascript">
  var objDiv = document.getElementById("cha");
objDiv.scrollTop = objDiv.scrollHeight;
</script>

@endsection