@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Admins')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('get-backups')}}">Backups</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    @if (!empty($message))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> @lang('lng.Alert')!</h5>
          {{$message}}
    </div>
    @endif
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
                        <!-- /.card-header -->
            <div class="card-header">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="card-title">Take Backup</h3><br><br>
                  <h3 class="card-title"><a class="btn btn-primary" href="{{url('take-backup')}}">Get Backup</a></h3><br><br>
                </div>
                <div class="col-md-6">
                  <h3 class="card-title">Upload Backup</h3><br><br>
                  <form method="post" action="{{url('upload-backup')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input class="form-control" type="file" name="image">
                  <br>
                    <input class="btn btn-success" type="submit" value="Upload">
                  </form>
                </div>
              </div>
            </div>
           
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>@lang('lng.Name')</th>
                  <th>Exportar</th>
                  <th>Importar</th>
                  
                  
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($files))
                  @foreach($files as $file)
                    <tr>
                      <?php
                        $name=$file->getBasename();
                       ?>
                      <td>{{$file->getBasename()}}</td>
                      <td><a class="btn btn-success" href="{{url('download-backups/'.$name)}}">Exportar</a></td>
                      <td><a class="btn btn-primary" href="{{url('import-backups/'.$name)}}">Importar</a></td>
                      
                    
                    </tr>
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

     $(".sidebar").scrollTop(400);
 });
  $("#backups").css('background-color','#6c757d');
</script>
@endsection