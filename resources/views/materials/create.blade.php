@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Create') {{$type}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}"@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('materials/create')}}">@lang('lng.Create') {{$type}}</a></li>
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
          <form id="Form1" method="POST" action="{{url('insideFolderMaterialsStore')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <input type="hidden" name="type" value="{{$type}}">
                  <input type="hidden" name="topicId" value="{{$topicId}}">                  
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Provide Material')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="material" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      <img id="i1" style="display: none; width: 40px; height:auto;" src="{{asset('spinner/Spinner2.svg')}}" style="background-color: orange">
                      
                    </div>
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">@lang('lng.Submit')</button>
                </div>
              </form>
              
              <img id="i1" style="display: none;" src="{{asset('spinner/Spinner2.svg')}}" style="background-color: orange">

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
  $("#materials").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();

});
</script>
<script type="text/javascript">
    var frm = $('#Form1');

    frm.submit(function (e) {
      $("#i1").css('display','block');
       
    });
</script>
@endsection