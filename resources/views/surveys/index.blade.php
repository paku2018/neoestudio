@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$studentType}} {{$folder->name}} Encuestas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('insideSurveysFolders/'.$studentType.'/'.$folder->id)}}">Encuestas</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if (\Session::has('message'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Alert!</h5>
          {!! \Session::get('message') !!}
    </div>
    @endif
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
                        <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title"><a class="btn btn-default" href="{{url('insideSurveysFoldersCreate/'.$studentType.'/'.$folder->id)}}">Crear Encuestas</a></h3>
            </div>
            <div class="card-body" style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>@lang('lng.NAME')</th>
                  <th>@lang('lng.Student Type')</th>
                  <th>@lang('lng.STATUS')</th>
                  <th>@lang('lng.Change Status')</th>
                  <th>@lang('lng.Questions/Answers')</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($surveys))
                  @foreach($surveys as $survey)
                    <tr>
                      <td>{{$survey->id}}</td>
                      <td>{{$survey->name}}</td>
                      <td>{{$survey->studentType}}</td>
                      <td>{{$survey->status}}</td>
                      <td><a class="btn btn-info" href="{{url('insideSurveysFoldersStatusChange/'.$survey->id)}}">@lang('lng.Change Status')</a></td>
                      
                      
                      <?php 
                        $exists=\App\Question::where('surveyId',$survey->id)->exists();
                      ?> 
                      @if($exists==true)<td><a class="btn btn-success" href="{{url('surveyqas/'.$survey->id)}}">@lang('lng.Questions/Answers')</a></td>@endif

                      @if($exists==false)<td><a class="btn btn-success" href="{{url('surveyquestions/create/'.$survey->id)}}">Crear</a></td>@endif
                      

                      <td><a class="btn btn-warning" href="{{url('insideSurveysFoldersEdit/'.$survey->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('insideSurveysFoldersDelete/'.$survey->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $survey->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $survey->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('insideSurveysFoldersDelete/'.$survey->id)}}">@lang('lng.Delete')</a>
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
  var ty="<?php echo $studentType ?>";
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
</script>
@endsection