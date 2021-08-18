@extends('dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Paginas {{$pageType}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
                            <li class="breadcrumb-item active"><a href="{{url('pages/'.$pageType)}}">Paginas</a>
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
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title">
                                <a class="btn btn-default" href="{{url('pages/create/'.$pageType.'/'.$page->id)}}">Crear
                                    sección de contenido</a></h3>
                            @if($page->id == 7)
                                <h3 class="card-title ml-3">
                                    <a class="btn btn-default" href="{{url('pages/video/'.$pageType.'/'.$page->id)}}">Video
                                        para la sección superior</a></h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="exampleContent" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Sección de título</th>
                                    <th>Icono de sección</th>
                                    <th>Video de la sección</th>
                                    <th>Descripción de la sección</th>
                                    <th>Pedido de sección</th>
                                    <th id="edit">@lang('lng.Edit')</th>
                                    <th id="delete">@lang('lng.Delete')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($contents))
                                    @foreach($contents as $content)
                                        <tr>
                                            <td>{{$content->title}}</td>
                                            <td>{{$content->image}}</td>
                                            <td>{{$content->video}}</td>
                                            <td>{!! $content->description2 !!}</td>
                                            <td>{{$content->order}}</td>
                                            <td>
                                                <a class="btn btn-warning" href="{{url('pages/edit/'.$pageType.'/section/'.$content->id)}}">@lang('lng.Edit')</a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter<?php echo $content->id ?>">
                                                    @lang('lng.Delete')
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="exampleModalCenter<?php echo $content->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b>Are you sure?</b>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a class="btn btn-danger" href="{{url('pages/delete/'.$content->id)}}">@lang('lng.Delete')</a>
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

            $(".sidebar").scrollTop(450);
        });
        var ty = "<?php echo $pageType ?>";

        if (ty == "video") {
            $("#pageV").css('background-color', '#6c757d');
        }
        if (ty == "content") {
            $("#pageC").css('background-color', '#6c757d');
        }
        $("#paginas").addClass('menu-open');
        //$("#paginas").css('background-color','#6c757d');
        $("#edit").removeClass('sorting');
        $("#delete").removeClass('sorting');
    </script>
@endsection