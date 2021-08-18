@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Topics')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('topics')}}">@lang('lng.Topics')</a></li>
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
              <h3 class="card-title"><a class="btn btn-default" href="{{url('topics/create')}}">@lang('lng.Create New Topic')</a></h3>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>@lang('lng.Name')</th>
                  <th>@lang('lng.COURSE NAME')</th>
                  <th>@lang('lng.TYPE')</th>
                  <th>@lang('lng.STATUS')</th>
                  
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($topics))
                  @foreach($topics as $topic)
                    <tr>
                      <td>{{$topic->name}}</td>
                      
                      <?php
                      if(!empty($topic->courseId)){
                          $course=\App\Course::find($topic->courseId);
                        }
                       ?>
                       
                      <td>@if(!empty($course)){{$course->name}}@endif</td>
                      <td>{{$topic->studentType}}</td>
                      <td>{{$topic->status}}</td>
                      <td><a class="btn btn-info" href="{{url('topicChangeStatus/'.$topic->id)}}">@lang('lng.Change Status')</a></td>
                      <td><a class="btn btn-warning" href="{{url('topics/edit/'.$topic->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('topics/delete/'.$topic->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $topic->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                     <div class="modal fade" id="exampleModalCenter<?php echo $topic->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('topics/delete/'.$topic->id)}}">@lang('lng.Delete')</a>
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
  $(document).ready(function() {

     $(".sidebar").scrollTop(400);
 });
  $("#topics").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
</script>
@endsection