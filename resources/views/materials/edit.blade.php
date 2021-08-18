@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Edit')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('materials/edit/'.$material->id)}}">@lang('lng.Edit Materials')</a></li>
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
    @if (\Session::has('message2'))
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5> @lang('lng.Alert')!</h5>
          {!! \Session::get('message2') !!}
    </div>
    @endif
    <section class="content">
      <div class="row">
        <div class="col-12">
          <form method="POST" action="{{url('insideFolderMaterialsUpdate/'.$material->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  
                  <div class="form-group">
                    <label>Nombre</label>
                    <?php 
                      if(!empty($material->name)){
                        $name=$material->name;
                      }
                      if(empty($material->name)){
                        $name=substr($material->material, strpos($material->material, "/") + 1);
                      }
                    ?>
                    <input type="text" class="form-control" name="name" value="@if(!empty($name)){{$name}}@endif">
                  </div>
                  
                  
                  <?php
                    $topics=\App\Topic::all();
                   ?>
                   @if(!empty($topics))
                   <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Topics')</label>
                    <select class="form-control" name="topicId">
                      @foreach($topics as $topic)
                        @if($topic->id==$material->topicId)
                          <option value="{{$topic->id}}" selected>{{$topic->name}}</option>
                        @endif
                        @if($topic->id!=$material->topicId)
                          <option value="{{$topic->id}}">{{$topic->name}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  @endif
                  
                  
                  <div class="form-inline">
                  <input type="checkbox" class="form-control" name="check"><label>@lang('lng.Use This') &nbsp; &nbsp;</label><a href="{{url('materialDownload/'.$material->id)}}" class="btn btn-success btn-sm">@lang('lng.Download')</a>
                </div>
                                                <br><p>@lang('lng.OR')</p><br>
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Provide New Material')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="material">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      
                    </div>
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


@endsection
@section('javascript')
<script type="text/javascript">
  $("#materials").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection