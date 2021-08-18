@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Create Teachers')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('teachers/create')}}">@lang('lng.Create Teachers')</a></li>
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
    <section class="content">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{url('teachers/store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Name')</label>
                    <input type="text" class="form-control" name="name" placeholder="@lang('lng.Enter name here')" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.User Name')</label>
                    <input type="text" class="form-control" name="userName" placeholder="@lang('lng.Enter user name here')" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Email')</label>
                    <input type="email" class="form-control" name="email" placeholder="@lang('lng.Enter email here')" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Password')</label>
                    <input type="text" class="form-control" name="password" placeholder="@lang('lng.Enter password here')" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Telephone')</label>
                    <input type="text" class="form-control" name="telephone" placeholder="@lang('lng.Enter telephone here')" required>
                  </div>
                  
                  
                  

                  
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Upload Photo')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      
                    </div>
                  </div>
                  <!--
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                 -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">@lang('lng.Submit')</button>
                </div>
              </form>
          <!-- /.card -->

          
          <!-- /.card -->
        </div>
      </div>
    </section>
</div>


@endsection
@section('javascript')
<script type="text/javascript">
  $("#teachers").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

@endsection