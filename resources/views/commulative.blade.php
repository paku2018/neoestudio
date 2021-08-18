@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Commulative Scores</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('commulativeScores')}}">Commulative Scores</a></li>
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
            <div class="card-body" style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>StudentId</th>
                  <th>Student Email</th>
                  <th>Folder Name</th>
                  <th>Folder Type</th>
                  <th>Course Name</th>
                  <th>Points</th>
                  <th>Total Points</th>
                  <th>field 1x</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($combines))
                  @foreach($combines as $combine)
                  @if(!empty($combine))
                  <?php
                    $u=\App\User::find($combine->studentId);
                  ?>
                  @if(!empty($u))
                    <tr>
                      <?php
                        $email=\App\User::find($combine->studentId)->email;
                        $folderName=\App\Folder::find($combine->folderId)->name;
                        $folderType=\App\Folder::find($combine->folderId)->studentType;
                        $courseName=\App\Course::find($combine->courseId)->name;
                       ?>
                       <td>{{$combine->id}}</td>
                       <td>{{$u->id}}</td>
                       <td>@if(!empty($email)){{$email}}@endif</td>
                       <td>@if(!empty($folderName)){{$folderName}}@endif</td>
                       <td>@if(!empty($folderType)){{$folderType}}@endif</td>
                       <td>@if(!empty($courseName)){{$courseName}}@endif</td>
                       <td>{{$combine->points}}</td>
                       <td>{{$combine->totalPoints}}</td>
                       <td>{{$combine->field1x}}</td>
                     
                      
                    </tr>
                    @endif
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
   $(document).ready(function() {

     $(".sidebar").scrollTop(350);
 });
  $("#combines").css('background-color','#6c757d');
 
</script>
@endsection