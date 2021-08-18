@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$option}} {{$studentType}} {{$folder->name}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('downloadsUploads/'.$option.'/'.$folder->id.'/'.$studentType)}}">{{$folder->name}}</a></li>
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
              <h3 class="card-title"><a class="btn btn-default" href="{{url('downloadsUploadsInsideFolderCreate/'.$option.'/'.$folder->id.'/'.$studentType)}}">@lang('lng.Create New') {{$folder->name}}</a></h3>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                
                  <th>Id</th>
                  <th>@lang('lng.MATERIAL')</th>
                  <th>@lang('lng.Student Type')</th>
                  <th>Alumno</th>
                  <th>@lang('lng.STATUS')</th>
                  <th>@lang('lng.Change Status')</th>
                  
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($downloadsUploads))
                  @foreach($downloadsUploads as $du)
                    <tr>
                      <td>{{$du->id}}</td>        
                      <td>{{$du->adminDownloadName}} <a class="btn btn-success btn-sm" href="{{url('downloadsUploadsDownload/'.$du->id)}}">@lang('lng.Download')</a></td>
                      <td>{{$du->studentType}}</td>
                      <?php
                        $user=\App\User::find($du->studentId);
                       ?>
                      <td>@if(!empty($user)){{$user->email}}@endif</td>
                      <td>{{$du->status}}</td>
                      <td><a class="btn btn-info" href="{{url('downloadsUploadsChangeStatus/'.$du->id)}}">@lang('lng.Change Status')</a></td>
                      <td><a class="btn btn-warning" href="{{url('downloadsUploadsInsideFolderEdit/'.$du->id.'/'.$studentType)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('downloadsUploadsInsideFolderDelete/'.$du->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $du->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $du->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('downloadsUploadsInsideFolderDelete/'.$du->id)}}">@lang('lng.Delete')</a>
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
  $("#downloadsUploads").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
</script>
@endsection