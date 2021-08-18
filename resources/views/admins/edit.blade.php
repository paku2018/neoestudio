@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Edit Admins')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('admins/edit/'.$admin->id)}}">@lang('lng.Edit Admins')</a></li>
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
        <div class="col-12">
          <form method="POST" action="{{url('admins/update/'.$admin->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Name')</label>
                    <input type="text" class="form-control" name="name"  placeholder="@if(!empty($admin)){{$admin->name}}@endif" value="@if(!empty($admin)){{$admin->name}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.User Name')</label>
                    <input type="text" class="form-control" name="userName"  placeholder="@if(!empty($admin)){{$admin->userName}}@endif" value="@if(!empty($admin)){{$admin->userName}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Email')</label>
                    <input type="text" class="form-control" name="email"  placeholder="@if(!empty($admin)){{$admin->email}}@endif" value="@if(!empty($admin)){{$admin->email}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Password')</label>
                    <input type="text" class="form-control" name="password"  placeholder="@if(!empty($admin)){{$admin->password}}@endif" value="@if(!empty($admin)){{$admin->password}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Telephone')</label>
                    <input type="text" class="form-control" name="telephone"  placeholder="@if(!empty($admin)){{$admin->telephone}}@endif" value="@if(!empty($admin)){{$admin->telephone}}@endif" required>
                  </div>
                  
                  

                  <div class="form-inline">
                  <input type="checkbox" class="form-control" name="check"><label>@lang('lng.Use This') &nbsp; &nbsp;</label><img style="width: 80px; height:auto;" src="{{asset($admin->photo)}}">
                </div>
                                                <br><p>@lang('lng.OR')</p><br>
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Provide New Photo')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      
                    </div>
                  </div>
                  

                  <!--
                  <div class="form-group">
                    <label for="adminpleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="adminpleInputFile">
                        <label class="custom-file-label" for="adminpleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="adminpleCheck1">
                    <label class="form-check-label" for="adminpleCheck1">Check me out</label>
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
  $("#admins").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection