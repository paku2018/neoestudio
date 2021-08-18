@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Create Topics')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}"@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('topics/create')}}">@lang('lng.Create Topics')</a></li>
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
          <form method="POST" action="{{url('topics/store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  
                  <div class="form-group">
                    <label for="name">@lang('lng.Name')</label>
                    <input type="text" class="form-control" name="name" placeholder="@lang('lng.Enter name here')">
                  </div>
                  <div class="form-group">
                    <label>@lang('lng.Student Type')</label>
                    <select class="form-control" name="studentType">
                      <option selected disabled>@lang('lng.Choose here')</option>
                      <option value="@lang('lng.Trial')">@lang('lng.Trial')</option>
                      <option value="@lang('lng.First Year')">@lang('lng.First Year')</option>
                      <option value="@lang('lng.Second Year')">@lang('lng.Second Year')</option>
                    </select>
                  </div>
                  
                  <?php
                    $courses=\App\Course::all();
                   ?>
                   @if(!empty($courses))
                   <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Courses')</label>
                    <select class="form-control" name="courseId">
                      <option selected disabled>@lang('lng.Choose here')</option>
                      @foreach($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  
                  
                  
                
                 

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
  $("#topics").css('background-color','#6c757d');
</script>

@endsection