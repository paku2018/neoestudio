@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$folder->name}} Crear Encuestas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('insideSurveysFoldersCreate/'.$studentType.'/'.$folder->id)}}">{{$folder->name}} Crear Encuestas</a></li>
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
          <form method="POST" action="{{url('insideSurveysFoldersStore')}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Name')</label>
                    <input type="text" class="form-control" name="name" placeholder="@lang('lng.Enter name here')" required>
                  </div>
                  <input type="hidden" name="studentType" value="{{$studentType}}">
                  <input type="hidden" name="folderId" value="{{$folder->id}}">
                
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
  $("#surveys").css('background-color','#6c757d');
</script>
@endsection