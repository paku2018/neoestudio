@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Encuestas {{$survey->name}} @lang('lng.Questions')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('surveyquestions/'.$survey->id)}}">@lang('lng.Questions')</a></li>
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
          <div class="card">
                        <!-- /.card-header -->
            <div class="card-header">
              
            </div>
            <div class="card-body"  style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>Encuestas</th>
                  <th>@lang('lng.Question')</th>
                  <th>Estrellas Entrada</th>
                  <th>Explicación Entrada</th>
                  
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
                      if(!empty($question->surveyId)){
                          $survey=\App\Survey::find($question->surveyId);
                        }
                       ?>
                      
                      <td>@if(!empty($survey)){{$survey->name}}@endif</td> 
                      <td>{{substr($question->question, 0, 15)}}</td>
                      <td>{{$question->star}}</td>
                      <td>{{$question->description}}</td>
                      
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $question->id ?>">
                        @lang('lng.View')
                        </button></td>
                      
                      <td><a class="btn btn-warning" href="{{url('surveyquestions/edit/'.$question->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('surveyquestions/delete/'.$question->id)}}">@lang('lng.Delete')</a></td>-->
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
                                <p><b>@lang('lng.Question')</b> :&nbsp;{{$question->question}}</p>
                                
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
                                <a class="btn btn-danger" href="{{url('surveyquestions/delete/'.$question->id)}}">@lang('lng.Delete')</a>
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