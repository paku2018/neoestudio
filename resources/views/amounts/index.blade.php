@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Temario precio</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('courseprice')}}">Temario precio</a></li>
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
            <?php 
                          $type1="books";
                        ?>
                        <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title"><a class="btn btn-default" href="{{url('courseprice/create/'.$type1)}}">Crear Temario precio</a></h3>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>Precio</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($amounts))
                  @foreach($amounts as $amount)
                    <tr>
                      
                      <td>{{$amount->amount}}</td>
                      <td><a class="btn btn-warning" href="{{url('courseprice/edit/'.$amount->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('courseprice/delete/'.$amount->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $amount->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $amount->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('courseprice/delete/'.$amount->id)}}">@lang('lng.Delete')</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
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
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
                        <!-- /.card-header -->
                        <?php 
                          $type2="strike";
                        ?>
            <div class="card-header">
              <h3 class="card-title"><a class="btn btn-default" href="{{url('courseprice/create/'.$type2)}}">Crear Temario Tachada Precio</a></h3>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  
                  <th>Precio</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($amounts2))
                  @foreach($amounts2 as $amount2)
                    <tr>
                      
                      <td>{{$amount2->amount}}</td>
                      <td><a class="btn btn-warning" href="{{url('courseprice/edit/'.$amount2->id)}}">@lang('lng.Edit')</a></td>
                      <td><a class="btn btn-danger" href="{{url('courseprice/delete/'.$amount2->id)}}">@lang('lng.Delete')</a></td>
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

     $(".sidebar").scrollTop(350);
 });
  $("#courseprice").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
</script>
@endsection