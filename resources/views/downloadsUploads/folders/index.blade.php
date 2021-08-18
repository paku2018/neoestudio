@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">({{$option}}) ({{$studentType}}) @lang('lng.Folders')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('downloadsUploads/folders/'.$option.'/'.$studentType)}}">({{$option}}) ({{$studentType}}) @lang('lng.Folders')</a></li>
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
              <?php
                $withoutFolder="withoutFolder";
               ?>
              <h3 class="card-title"><a class="btn btn-default" href="{{url('downloadsUploadsFoldersCreate/'.$option.'/'.$studentType)}}">@lang('lng.Create Folders')</a><a class="btn btn-default" href="{{url('downloadsUploadsOnlyFiles/'.$option.'/'.$studentType)}}">Crear Archivos</a></h3>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>@lang('lng.NAME')</th>
                  <th>@lang('lng.STATUS')</th>
                  <th>@lang('lng.Change Status')</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($folders))
                  @foreach($folders as $folder)
                    <tr>
                      <td>{{$folder->id}}</td>
                      <td><a href="{{url('downloadsUploadsInsideFolderIndex/'.$option.'/'.$folder->id.'/'.$studentType)}}" style="color: lightblue;"><i class="fa fa-folder" style="font-size: 40px;" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;{{$folder->name}}</td>
                      <td>{{$folder->status}}</td>
                      <td><a class="btn btn-info" href="{{url('downloadsUploadsFolderStatusChange/'.$folder->id)}}">@lang('lng.Change Status')</a></td>
                      
                      <td><a class="btn btn-warning" href="{{url('downloadsUploadsFoldersEdit/'.$folder->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('downloadsUploadsFoldersDelete/'.$folder->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $folder->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $folder->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('downloadsUploadsFoldersDelete/'.$folder->id)}}">@lang('lng.Delete')</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                  @endforeach
                @endif
                 <?php
                    $files=\App\DownloadUpload::where('option',$option)->where('studentType',$studentType)->where('folderId','empty')->get();
                   ?>
                @if(!empty($files))
                  @foreach($files as $file)
                    <tr>
                      <td>{{$file->id}}</td>
                      <td>{{$file->file}}</td>
                      <td>{{$file->status}}</td>
                      <td><a class="btn btn-info" href="{{url('downloadsUploadsChangeStatus/'.$file->id)}}">@lang('lng.Change Status')</a></td>
                      
                      <td><a class="btn btn-warning" href="{{url('downloadsUploadsInsideFolderEdit/'.$file->id.'/'.$studentType)}}">@lang('lng.Edit')</a></td>
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $file->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                      <!--<td><a class="btn btn-danger" href="{{url('downloadsUploadsInsideFolderDelete/'.$file->id)}}">@lang('lng.Delete')</a></td>-->
                      
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $file->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('downloadsUploadsInsideFolderDelete/'.$file->id)}}">@lang('lng.Delete')</a>
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

     $(".sidebar").scrollTop(350);
 });

  $("#downloadsUploads").addClass('menu-open');
  var ty="<?php echo $studentType ?>";
  var acty="<?php echo $option ?>";
  if(acty=="Descargas"){
    $("#inDUd").addClass('menu-open');
    if(ty=="Prueba"){
      $("#downP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#downA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#downAc").css('background-color','#6c757d');
    }
  }

  if(acty=="Subidas"){
    $("#inDUu").addClass('menu-open');
    if(ty=="Prueba"){
      $("#upP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#upA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#upAc").css('background-color','#6c757d');
    }
  }
  
  //$("#downloadsUploads").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
  
</script>
@endsection