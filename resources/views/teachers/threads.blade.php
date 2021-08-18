@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Tickets</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('threads')}}">Chat Tickets</a></li>
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
              
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                 
              
                  <th>@lang('lng.Email')</th>
                  <th>@lang('lng.Telephone')</th>

                  <th>Status</th>
                  <th id="status">Change Status</th>
                  <th id="view">View</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($threads))
                  @foreach($threads as $thread)
                  <?php
                        $student=\App\User::find($thread->studentId);
                       ?>
                       @if(!empty($student))
                    <tr>
                      
                      <td>@if(!empty($student)){{$student->email}}@endif</td>
                      <td>@if(!empty($student)){{$student->telephone}}@endif</td>
                      <td>@if(!empty($thread)){{$thread->status}}@endif</td>
                      
                      <td><a class="btn btn-success" href="{{url('threadStatusChange/'.$thread->id)}}">Edit Status</a></td>
                      <td><a class="btn btn-warning" href="{{url('chats/'.$thread->studentId)}}">View</a></td>
                    
                    </tr>
                    @endif
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
  $("#chat").css('background-color','#6c757d');
  $("#status").removeClass('sorting');
  $("#view").removeClass('sorting');

</script>
@endsection