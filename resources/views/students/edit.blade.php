@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Edit Students')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('students/edit/'.$student->id)}}">@lang('lng.Edit Students')</a></li>
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
          <form method="POST" action="{{url('students/update/'.$student->id)}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Name')</label>
                    <input type="text" class="form-control" name="name"  placeholder="@if(!empty($student)){{$student->name}}@endif" value="@if(!empty($student)){{$student->name}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Email')</label>
                    <input type="text" class="form-control" name="email"  placeholder="@if(!empty($student)){{$student->email}}@endif" value="@if(!empty($student)){{$student->email}}@endif" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="name">@lang('lng.Telephone')</label>
                    <input type="text" class="form-control" name="telephone"  placeholder="@if(!empty($student)){{$student->telephone}}@endif" value="@if(!empty($student)){{$student->telephone}}@endif" required>
                  </div>
                  <!--<div class="form-group">
                    <label>@lang('lng.Student Type')</label>
                    <select class="form-control" name="type">
                      @if($student->type=="Prueba")
                      <option selected value="@lang('lng.Trial')">@lang('lng.Trial')</option>
                      <option value="@lang('lng.First Year')">@lang('lng.First Year')</option>
                      <option value="@lang('lng.Second Year')">@lang('lng.Second Year')</option>
                      @endif
                      @if($student->type=="Alumno")
                      <option value="@lang('lng.Trial')">@lang('lng.Trial')</option>
                      <option selected value="@lang('lng.First Year')">@lang('lng.First Year')</option>
                      <option value="@lang('lng.Second Year')">@lang('lng.Second Year')</option>
                      @endif
                      @if($student->type=="Alumno Convocado")
                      <option value="@lang('lng.Trial')">@lang('lng.Trial')</option>
                      <option value="@lang('lng.First Year')">@lang('lng.First Year')</option>
                      <option selected value="@lang('lng.Second Year')">@lang('lng.Second Year')</option>
                      @endif
                    </select>
                  </div>-->
                  <div class="form-group">
                    <label for="name">@lang('lng.Student Code')</label>
                    <input type="text" class="form-control" name="studentCode"  placeholder="@if(!empty($student)){{$student->studentCode}}@endif" value="@if(!empty($student)){{$student->studentCode}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Password')</label>
                    <input type="text" class="form-control" name="password"  placeholder="@if(!empty($student)){{$student->password}}@endif" value="@if(!empty($student)){{$student->password}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Baremo</label>
                    <input type="text" class="form-control" name="baremo"  placeholder="@if(!empty($student)){{$student->baremo}}@endif" value="@if(!empty($student)){{$student->baremo}}@endif" required>
                  </div>

                  
                  
                  

                  <!--
                  <div class="form-group">
                    <label for="studentpleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="studentpleInputFile">
                        <label class="custom-file-label" for="studentpleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="studentpleCheck1">
                    <label class="form-check-label" for="studentpleCheck1">Check me out</label>
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
  var type="<?php echo $student->type ?>";
  $("#students").addClass('menu-open');
  if(type=="Prueba"){
    $("#stuP").css('background-color','#6c757d');
  }
  if(type=="Alumno"){
    $("#stuA").css('background-color','#6c757d');
  }
  if(type=="Alumno Convocado"){
    $("#stuAc").css('background-color','#6c757d');
  }
 // $("#students").css('background-color','#6c757d');
</script>
@endsection