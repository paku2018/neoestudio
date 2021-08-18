@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Payments')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('payments')}}">@lang('lng.Payments')</a></li>
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
              <!--<h3 class="card-title"><a class="btn btn-default" href="{{url('payments/create')}}">@lang('lng.Create New Payment')</a></h3>-->
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Correo Electrónico</th>
                  <th>Precio</th>
                  <th>Número</th>
                  <th>Tip</th>
                  <th>Hora</th>
                  <th>Estado</th>  
                </tr>
                </thead>
                <tbody>
                @if(!empty($pays))
                  @foreach($pays as $pay)
                  @if(!empty($pay))
                  <?php
                        $student=\App\User::find($pay->userId);
                       ?>
                  @if(!empty($student))

                    <tr>
                      
                      <td>@if(!empty($student)){{$student->email}}@endif</td>
                      <td>{{$pay->amount}}</td>
                      <td>{{$pay->invoiceN}}</td>
                      <td>{{$pay->type}}</td>
                     
                      <td>{{$pay->time}}</td>
                     
                      <td>{{$pay->status}}</td>
                      
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
  $("#prices").addClass('menu-open');
  $("#priB").css('background-color','#6c757d');
  //$("#pays").css('background-color','#6c757d');
 
</script>
@endsection