@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Edit Payments')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('payments/edit/'.$payment->id)}}">@lang('lng.Edit Payments')</a></li>
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
          <form method="POST" action="{{url('payments/update/'.$payment->id)}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Date From')</label>
                    <input type="date" class="form-control" name="from" value="@if(!empty($payment)){{$payment->from}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Date To')</label>
                    <input type="date" class="form-control" name="to" value="@if(!empty($payment)){{$payment->to}}@endif" required>
                  </div>
                  
                  <?php
                    $students=\App\Student::all();
                   ?>
                   @if(!empty($students))
                   <div class="form-group">
                    <select class="form-control" name="studentId">
                      
                      @foreach($students as $student)
                        @if($student->id==$payment->studentId)
                        <option value="{{$student->id}}" selected>{{$student->email}} &nbsp; {{$student->studentCode}}</option>
                        @endif
                        @if($student->id!=$payment->studentId)
                        <option value="{{$student->id}}">{{$student->email}} &nbsp; {{$student->studentCode}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  @endif
                  <div class="form-group">
                    <label>@lang('lng.Status')</label>
                    <select class="form-control" name="status">
                      @if($payment->status!="pending" && $payment->status!="received")
                      <option selected disabled>@lang('lng.Choose here')</option>
                      <option value="pending">@lang('lng.Pending')</option>
                      <option value="received">@lang('lng.Received')</option>
                      @endif
                      @if($payment->status=="pending")
                      
                      <option value="pending" selected>@lang('lng.Pending')</option>
                      <option value="received">@lang('lng.Received')</option>
                      @endif
                      @if($payment->status=="received")
                      
                      <option value="pending">@lang('lng.Pending')</option>
                      <option value="received" selected>@lang('lng.Received')</option>
                      @endif
                      
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