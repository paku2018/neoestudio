@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Students')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('studentExamsById/'.$student->id)}}">@lang('lng.Students') Examenes</a></li>
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
            <div class="card-body" style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>@lang('lng.Name')</th>
                  <th>Examen @lang('lng.Name')</th>
                  <th>@lang('lng.Course Name')</th>
                  <th>@lang('lng.Folder Name')</th>
                  <th>Tipo de carpeta</th>
                  <th>Estudient Tipo</th>
                  <th>@lang('lng.Status')</th>
                  <th>@lang('lng.Score')</th>
                  <th>@lang('lng.Result')</th>
                  
                  
                  
                  <th id="examDetail">Exam Sheet</th>
                  <th id="reschedule">Reschedule</th>
                  
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($studentExamRecords))
                  @foreach($studentExamRecords as $record)
                  @if(!empty($record))
                  <?php
                        $exam=\App\Exam::find($record->examId);
                        if(!empty($exam)){
                        $folder=\App\Folder::find($exam->folderId);
                        if(empty($exam->courseId)){
                          $course=null;
                        }
                        if(!empty($exam->courseId)){
                          $course=\App\Course::find($exam->courseId);
                          
                        }
                        $timeFrom=$exam->timeFrom/60;
                        $examDuration=gmdate("H:i:s", $record->examDuration);
                        $exists=\App\Reschedule::where('studentId',$student->id)->where('examId',$exam->id)->exists();
                        if($exists==true){
                          $reSchedule=\App\Reschedule::where('studentId',$student->id)->where('examId',$exam->id)->first();
                        }
                      }

                       ?>
                       @if(!empty($exam))
                    <tr>
                      
                      
                      <td>{{$student->email}}</td>
                       <td>{{$exam->name}}</td>
                      <td>@if(!empty($course)){{$course->name}}@endif</td>
                      <td>@if(!empty($folder)){{$folder->name}}@endif</td>
                      <td>@if(!empty($folder)){{$folder->type}}@endif</td>
                      <td>@if(!empty($folder)){{$folder->studentType}}@endif</td>
                     
                      <td>{{$record->status}}</td>
                      <td>{{$record->score}}</td>
                      <td>{{$record->result}}</td>
                      
                      
                      <td><a class="btn btn-success" href="{{url('studentExamsAttempted/'.$record->id)}}">Examenes</a></td>
                      @if($exists==false)
                      <td><a class="btn btn-warning" href="{{url('rescheduleExamEnable/'.$record->id)}}">Reschedule</a></td>
                      @endif
                      @if($exists==true)
                        @if($reSchedule->status=="Habilitado")
                        <td><a class="btn btn-primary" href="{{url('rescheduleExamDisable/'.$reSchedule->id)}}">Rescheduled</a></td>
                        @endif
                        @if($reSchedule->status=="Deshabilitado")
                        <td><a class="btn btn-warning" href="{{url('rescheduleExamEnable/'.$record->id)}}">Reschedule</a></td>
                        @endif
                      @endif
                    </tr>
                    @endif
                    @endif
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
  $("#students").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
  $("#examDetail").removeClass('sorting');
  $("#reschedule").removeClass('sorting');
</script>
@endsection