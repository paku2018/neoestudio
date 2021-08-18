@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$exam->name}} @lang('lng.Create Questions')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('questions/create/'.$exam->id)}}">@lang('lng.Create Questions')</a></li>
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
          <form method="POST" action="{{url('questions/store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  
                  
                  <input type="hidden" name="examId" value="{{$exam->id}}">
                  
                  

                  
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Provide Excel File')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="fileP" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      
                    </div>
                  </div>
                  
                
                 

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">@lang('lng.Submit')</button>
                </div>

              </form>
              <div class="text-center">
                OR
                <br><br>
                <a href="{{url('manually/'.$exam->id)}}" class="btn btn-success">Crear manualmente</a>
              </div>
          <!-- /.card -->

          
          <!-- /.card -->
        </div>
      </div>

    </section>
</div>

<?php
  $f=\App\Folder::find($exam->folderId);
 ?>
@endsection
@section('javascript')
<script type="text/javascript">
  var type="<?php echo $f->type ?>";
  var ty="<?php echo $f->studentType ?>";
  if(type=="exams"){
    
    if(ty=="Prueba"){
      $("#exP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#exA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#exAc").css('background-color','#6c757d');
    }
    $("#exams").addClass('menu-open');
  }
  if(type=="personalities"){
    if(ty=="Prueba"){
      $("#perP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#perA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#perAc").css('background-color','#6c757d');
    }
    $("#personalities").addClass('menu-open');
  }
  if(type=="reviews"){
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
  }
  //$("#questions").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection