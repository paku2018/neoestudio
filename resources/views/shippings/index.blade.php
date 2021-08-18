@extends('dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Envíos</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
                            <li class="breadcrumb-item active"><a href="{{url('shippings')}}">Envíos</a>
                            </li>
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
                        <div class="card-header">
                            <h3 class="card-title">
                                <a class="btn btn-default" href="{{url('shippings/create')}}">@lang('lng.Create') Envío</a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="exampleContent" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Título</th>
                                    <th>@lang('lng.Price')</th>
                                    <th>@lang('lng.Status')</th>
                                    <th id="edit">@lang('lng.Edit')</th>
                                    <th id="delete">@lang('lng.Delete')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($shippings))
                                    @foreach($shippings as $shipping)
                                        <tr>
                                            <?php /*td>
                                                    <a href="{{url('shippings/edit/'.$shipping->id)}}" style="color: lightblue;"><i class="fa fa-folder" style="font-size: 40px;" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;{{$shipping->name}}
                                                </td */?>
                                            <td>{{$shipping->id}}</td>
                                            <td>{{$shipping->title}}</td>
                                            <td>{{ (fmod($shipping->price, 1) !== 0.00) ? $shipping->price : round($shipping->price) }} &euro;</td>
                                            <td>{{$shipping->status}}</td>
                                            <td>
                                                <a class="btn btn-warning" href="{{url('shippings/'.$shipping->id.'/edit')}}">@lang('lng.Edit')</a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $shipping->id ?>">
                                                    @lang('lng.Delete')
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="exampleModalCenter<?php echo $shipping->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b>Are you sure?</b>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a class="btn btn-danger" href="{{url('shippings/delete/'.$shipping->id)}}">@lang('lng.Delete')</a>
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
    </div>


@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {

            $(".sidebar").scrollTop(400);
        });

        $("#shippings").css('background-color', '#6c757d');
        $("#shippings").addClass('menu-open');
        $("#edit").removeClass('sorting');
        $("#delete").removeClass('sorting');
    </script>
@endsection