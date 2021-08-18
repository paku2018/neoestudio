@extends('dashboard')
@section('content')
<?php
$exam=\App\Exam::find($record->examId);
//$questions=\App\StudentAttempt::where('studentExamRecordId',$record->id)->orderBy('id','asc')->get();

 ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Exam Sheet ({{$exam->name}})</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('studentExamsAttempted/'.$record->id)}}">@lang('lng.Questions')</a></li>
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
              <p><b>@lang('lng.Correct')</b> : {{$correctCount}} <b>@lang('lng.Correct Percentage')</b> : {{$correctPercentage}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.False')</b> : {{$wrongCount}} <b>@lang('lng.False Percentage')</b> : {{$wrongPercentage}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>@lang('lng.Not Attempted')</b> : {{$nonAttemptedCount}} <b>@lang('lng.Null Percentage')</b> : {{$nullPercentage}}</p>
              <p>@foreach($answersArray as $sA)
                @if($sA=="correct")
                <i class="fa fa-circle" aria-hidden="true" style="color: green "></i>
                @endif
                @if($sA=="wrong")
                <i color="red" class="fa fa-circle" aria-hidden="true" style="color: red "></i>
                @endif
                @if($sA=="notAttempted")
                <i color="red" class="fa fa-circle" aria-hidden="true" style="color: grey "></i>
                @endif
                @endforeach
                
              </p>
              <?php
                $exam=\App\Exam::find($record->examId);
                $timeFrom=gmdate("H:i:s", $exam->timeFrom);
                        $examDuration=gmdate("H:i:s", $record->examDuration);
               ?>
              <p><b>@lang('lng.Completion Time')</b> : {{$examDuration}}&nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.End Time')</b> : {{$record->studentAttemptedEndingTime}}&nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Official Exam Duration')</b> : {{$timeFrom}}</p>
              <p><b>@lang('lng.Score')</b> : {{$record->score}} &nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Status')</b> : {{$record->status}} &nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Can Pause')</b> : {{$record->canPause}} &nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Ending Way')</b> : {{$record->endingWay}} &nbsp;&nbsp;&nbsp;&nbsp;</p>
              <p><b>@lang('lng.Starting Time')</b> : {{$record->startingTime}} &nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Official Ending Time')</b> : {{$record->officialEndingTime}} &nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Paused Time')</b> : {{$record->pausedTime}} &nbsp;&nbsp;&nbsp;&nbsp;<b>@lang('lng.Resumed Time')</b> : {{$record->resumedTime}} &nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
            <div class="card-body"  style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>Database Id</th>
                  <th>@lang('lng.Question')</th>
                  <th>@lang('lng.Answer1')</th>
                  <th>@lang('lng.Answer2')</th>
                  <th>@lang('lng.Answer3')</th>
                  <th>@lang('lng.Answer4')</th>
                  <th>@lang('lng.Correct')</th>
                  <th>@lang('lng.Student Answered')</th>
                  <th>@lang('lng.Status')</th>
                  <th>@lang('lng.Description')</th>
                  <th id="view">@lang('lng.View')</th>
                  <th id="edit" style="display: none">@lang('lng.Edit')</th>
                  <th id="delete" style="display: none">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                 
                @if(!empty($questions))
                  @foreach($questions as $key=>$question)
                  
                    <tr>
                      <td>{{$question->id}}</td>
                      <td>{{substr($question->question, 0, 15)}}</td>
                      <td>{{substr($question->answer1, 0, 15)}}</td>
                      <td>{{substr($question->answer2, 0, 15)}}</td>
                      <td>{{substr($question->answer3, 0, 15)}}</td>
                      <td>{{substr($question->answer4, 0, 15)}}</td>
                      <td>{{substr($question->correct, 0, 15)}}</td>
                      <td>@if(!empty($question->studentAnswered)){{$question->studentAnswered}}@endif</td>
                      @if(empty($question->studentAnswered))
                        <td><i class="fa fa-circle" aria-hidden="true" style="color: grey "></i></td>
                      @endif
                      @if(!empty($question->studentAnswered))
                        
                            @if($answersArray[$key]=="correct")
                              <td><i class="fa fa-circle" aria-hidden="true" style="color: green "></i></td>
                            @endif
                            @if($answersArray[$key]=="wrong")
                              <td><i color="red" class="fa fa-circle" aria-hidden="true" style="color: red "></i></td>
                            @endif
                            @if($answersArray[$key]=="notAttempted")
                              <td><i color="red" class="fa fa-circle" aria-hidden="true" style="color: grey "></i></td>
                            @endif
                         
                      @endif
                      <td>{{substr($question->description, 0, 15)}}</td>
                    
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $question->id ?>">
                        @lang('lng.View')
                        </button></td>
                        <td style="display: none"><a class="btn btn-warning" href="{{url('questions/edit/'.$question->id)}}">@lang('lng.Edit')</a></td>
                      <td style="display: none"><a class="btn btn-danger" href="{{url('questions/delete/'.$question->id)}}">@lang('lng.Delete')</a></td>
                      
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
                                <p><b>@lang('lng.Answer1')</b> :&nbsp;{{$question->answer1}}</p>
                                <p><b>@lang('lng.Answer2')</b> :&nbsp;{{$question->answer2}}</p>
                                <p><b>@lang('lng.Answer3')</b> :&nbsp;{{$question->answer3}}</p>
                                <p><b>@lang('lng.Answer4')</b> :&nbsp;{{$question->answer4}}</p>
                                <p><b>@lang('lng.Correct')</b> :&nbsp;{{$question->correct}}</p>
                                <p><b>Student Answered</b> :&nbsp;{{$question->studentAnswered}}</p>
                                <p><b>@lang('lng.Description')</b> :&nbsp;{{$question->description}}</p>
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
  $("#questions").css('background-color','#6c757d');
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