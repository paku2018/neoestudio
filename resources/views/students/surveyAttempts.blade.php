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
              <li class="breadcrumb-item active"><a href="{{url('studentSurveysAttempted/'.$surveyRecord->id)}}">@lang('lng.Questions')</a></li>
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
                  <th>Estrellas</th>
                  <th>Explicación</th>
                  <th>Puntuación media</th>
                  
                  <th id="view">@lang('lng.View')</th>
              
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($questions))
                  @foreach($questions as $question)
                    <tr>
                      <?php 
                        $sss=\App\StudentSurveyAttempt::where('question',$question->question)->get();
                        $ssc=\App\StudentSurveyAttempt::where('question',$question->question)->get()->count();

                        $total=0;
                        $av=0;
                        foreach ($sss as $key => $value) {
                          $total=$total+$value->starResponse;
                        }
                        $av=$total/$ssc;
                        $av=(int)$av;
                      ?>
                      
                      
                      <td>{{$survey->name}}</td> 
                      <td>{{substr($question->question, 0, 15)}}</td>
                      <td>{{$question->starResponse}}</td>
                      <td>{{$question->descriptionResponse}}</td>
                      <td>{{$av}}</td>
                      
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $question->id ?>">
                        @lang('lng.View')
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
                                <p><b>Estrellas</b> :&nbsp;{{$question->starResponse}}</p>
                                <p><b>Explicación</b> :&nbsp;{{$question->descriptionResponse}}</p>
                                
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
  $("#surveys").css('background-color','#6c757d');
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