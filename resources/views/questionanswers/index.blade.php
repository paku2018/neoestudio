@extends('dashboard')
@section('content')
<style type="text/css">
@font-face {
  font-family: "Regular";
  src: url("{{asset('neostudio/pnswr.ttf')}}");
}
@font-face {
  font-family: "Bold";
  src: url("{{asset('neostudio/psttf.ttf')}}");
}
@font-face {
  font-family: "Rounded";
  src: url("{{asset('neostudio/re.ttf')}}");
}


</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Questions')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('questions/'.$exam->id)}}">@lang('lng.Questions')</a></li>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Insertar imágenes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{url('insertExamImages')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  
                  
                  

                  <input type="hidden" name="examId" value="{{$exam->id}}">
                  
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Provide Material')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="images" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      
                    </div>
                  </div>
                  
                  
                
                 

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">@lang('lng.Submit')</button>
                </div>
              </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
                        <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                  Insertar imágenes
                </button></h3>
            </div>
            <div class="card-body"  style="overflow-x: scroll;">
              <a class="btn btn-success" href="{{url('manually/'.$exam->id)}}">Crear Preguntas</a>
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>@lang('lng.Exam')</th>
                  <th>@lang('lng.Question')</th>
                  <!--<th>@lang('lng.Answer1')</th>
                  <th>@lang('lng.Answer2')</th>
                  <th>@lang('lng.Answer3')</th>
                  <th>@lang('lng.Answer4')</th>
                  <th>@lang('lng.Correct')</th>
                  <th>@lang('lng.Description')</th>-->
                  <th>Imágenes</th>
                  <th id="view">@lang('lng.View')</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($questions))
                  @foreach($questions as $question)
                    <tr>
                      
                      <?php
                      if(!empty($question->examId)){
                          $exam=\App\Exam::find($question->examId);
                        }
                        
                       ?>
                      
                      <td>@if(!empty($exam)){{$exam->name}}@endif</td> 
                      <td>{!!$question->question!!}</td>
                      <!--<td>{{substr($question->question, 0, 15)}}</td>
                      <td>{{substr($question->answer1, 0, 15)}}</td>
                      <td>{{substr($question->answer2, 0, 15)}}</td>
                      <td>{{substr($question->answer3, 0, 15)}}</td>
                      <td>{{substr($question->answer4, 0, 15)}}</td>
                      <td>{{substr($question->correct, 0, 15)}}</td>
                      <td>{{substr($question->description, 0, 15)}}</td>-->
                      <td>@if(!empty($question->image))<img src="{{asset($question->image)}}" style="width: 80px; height: auto">@endif</td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $question->id ?>">
                        @lang('lng.View')
                        </button></td>
                      
                      <td><a class="btn btn-warning" href="{{url('questions/edit/'.$question->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('questions/delete/'.$question->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter2<?php echo $question->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $question->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>@lang('lng.View Question & Answers')</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p><b>@lang('lng.Question')</b> :&nbsp;{!!$question->question!!}</p>
                                <p><b>@lang('lng.Answer1')</b> :&nbsp;{!!$question->answer1!!}</p>
                                <p><b>@lang('lng.Answer2')</b> :&nbsp;{!!$question->answer2!!}</p>
                                <p><b>@lang('lng.Answer3')</b> :&nbsp;{!!$question->answer3!!}</p>
                                <p><b>@lang('lng.Answer4')</b> :&nbsp;{!!$question->answer4!!}</p>
                                <p><b>@lang('lng.Correct')</b> :&nbsp;{{$question->correct}}</p>
                                <p><b>@lang('lng.Description')</b> :&nbsp;{{$question->description}}</p>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter2<?php echo $question->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('questions/delete/'.$question->id)}}">@lang('lng.Delete')</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                  @endforeach
                @endif
                
              
                
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
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
  //$("#exams").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
  $("#view").removeClass('sorting');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection