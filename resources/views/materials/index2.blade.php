@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$type}} @lang('lng.Materials')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('materials/'.$type)}}">{{$type}} @lang('lng.Materials')</a></li>
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
            
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                
                  <th>Id</th>
                  <th>@lang('lng.Topics')</th>
                  <th>Tema Student Type</th>
                  
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($topics))
                  @foreach($topics as $topic)
                    <tr>
                      <td>{{$topic->id}}</td>
                       <td>@if(!empty($topic))<a href="{{url('insideMaterialFolders/'.$type.'/'.$topic->id)}}" style="color: lightblue;"><i class="fa fa-folder" style="font-size: 40px;" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;{{$topic->name}}@endif</td>
                       <td>@if(!empty($topic)){{$topic->studentType}}@endif</td>
                      
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

     $(".sidebar").scrollTop(300);
 });

  $("#materials").addClass('menu-open');
  var ty="<?php echo $studentType ?>";
  var acty="<?php echo $type ?>";
  if(acty=="audio"){
    $("#inMa").addClass('menu-open');
    if(ty=="Prueba"){
      $("#audP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#audA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#audAc").css('background-color','#6c757d');
    }
  }

  if(acty=="video"){
    $("#inMv").addClass('menu-open');
    if(ty=="Prueba"){
      $("#vidP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#vidA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#vidAc").css('background-color','#6c757d');
    }
  }
  
  //$("#materials").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
</script>
@endsection