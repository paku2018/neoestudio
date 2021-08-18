@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Repaso</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('insideReviewsFoldersEdit'.$review->id)}}">Editar Repaso</a></li>
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
          <form method="POST" action="{{url('insideReviewsFoldersUpdate/'.$review->id)}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Name')</label>
                    <input type="text" class="form-control" name="name"  placeholder="@if(!empty($review)){{$review->name}}@endif" value="@if(!empty($review)){{$review->name}}@endif" required>
                  </div>
                  
                  
                  
                  <div class="form-group">
                    <label for="name">@lang('lng.Schedule Date')</label>
                    <input type="date" class="form-control" name="scheduleDate" value="@if(!empty($review)){{$review->scheduleDate}}@endif"  placeholder="Enter schedule date here" required>
                  </div>
                  <!--
                  <div class="form-group">
                    <label for="name">@lang('lng.Time From')</label>
                    <input type="time" class="form-control" name="timeFrom" value="@if(!empty($exam)){{$exam->timeFrom}}@endif" required>
                  </div>-->
                  <div class="form-group col-md-4">
                    <label for="name">Tiempo Minutes</label>
                    <!--<input type="time" class="form-control" name="timeFrom" required>-->
                    <input class="form-control" type="number" name="timeFrom" value="@if(!empty($review)){{$review->timeFrom/60}}@endif">
                  </div>
                  
                  

                  <!--
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                 -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
  var ty="<?php echo $review->studentType ?>";
  if(ty=="Prueba"){
    $("#repP").css('background-color','#6c757d');
  }
  if(ty=="Alumno"){
    $("#repA").css('background-color','#6c757d');
  }
  if(ty=="Alumno Convocado"){
    $("#repAc").css('background-color','#6c757d');
  }
  $("#reviews").addClass('menu-open');
  //$("#reviews").css('background-color','#6c757d');
</script>
@endsection