@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Edit questions')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('surveyquestions/edit/'.$question->id)}}">@lang('lng.Edit questions')</a></li>
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
          <form method="POST" action="{{url('surveyquestions/update/'.$question->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  
                  
                  <input type="hidden" name="surveyId" value="{{$question->surveyId}}">
                  
                  <div class="form-group">
                    <label for="name">@lang('lng.Question')</label>
                    <input type="text" class="form-control" name="question"  placeholder="@if(!empty($question)){{$question->question}}@endif" value="@if(!empty($question)){{$question->question}}@endif">
                  </div>
                  <div class="form-group">
                    <label for="name">Estrellas Entrada</label>
                    <select class="form-control" name="star">
                      
                      @if($question->star=="si")
                      <option value="si" selected>si</option>
                      <option value="no">no</option>
                      @endif
                      @if($question->star=="no")
                      <option value="si">si</option>
                      <option value="no" selected>no</option>
                      @endif
                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="name">Explicación Entrada</label>
                    <select class="form-control" name="description">
                      
                      @if($question->description=="si")
                      <option value="si" selected>si</option>
                      <option value="no">no</option>
                      @endif
                      @if($question->description=="no")
                      <option value="si">si</option>
                      <option value="no" selected>no</option>
                      @endif
                    </select>
                  </div>
                  
                
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

<?php 
  $survey=\App\Survey::find($question->surveyId);
?>
@endsection
@section('javascript')
<script type="text/javascript">
   var ty="<?php echo $survey->studentType ?>";
  if(ty=="Prueba"){
    $("#surP").css('background-color','#6c757d');
  }
  if(ty=="Alumno"){
    $("#surA").css('background-color','#6c757d');
  }
  if(ty=="Alumno Convocado"){
    $("#surAc").css('background-color','#6c757d');
  }
  $("#surveys").addClass('menu-open');
  //$("#surveys").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection