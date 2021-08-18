@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Create Payments')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('payments/create')}}">@lang('lng.Create Payments')</a></li>
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
          <form method="POST" action="{{url('payments/store')}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Date From')</label>
                    <input type="date" class="form-control" name="from" placeholder="" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Date To')</label>
                    <input type="date" class="form-control" name="to" placeholder="" required>
                  </div>
                  
                  <?php
                    $students=\App\Student::all();
                   ?>
                   @if(!empty($students))
                   <div class="form-group">
                    <label>@lang('lng.Students')</label>
                    <select class="form-control" name="studentId">
                      <option selected disabled>@lang('lng.Choose here')</option>
                      @foreach($students as $student)
                        <option value="{{$student->id}}">{{$student->email}} &nbsp; {{$student->studentCode}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  <div class="form-group">
                    <label>@lang('lng.Status')</label>
                    <select class="form-control" name="status">
                      <option selected disabled>@lang('lng.Choose here')</option>
                      <option value="pending">@lang('lng.Pending')</option>
                      <option value="received">@lang('lng.Received')</option>
                      
                    </select>
                  </div>

                  <!--
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                 -->

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
  $("#payments").css('background-color','#6c757d');
</script>
@endsection