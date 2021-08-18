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
                        <div class="card-body">
                            <table id="exampleContent" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Nombre de la página</th>
                                    @if($pageType == "video")
                                        <th>Video</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($pages))
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>
                                                <a href="{{url('pages/edit/'.$pageType.'/'.$page->id)}}" style="color: lightblue;"><i class="fa fa-folder" style="font-size: 40px;" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;{{$page->title}}
                                            </td>
                                            @if($pageType == "video")
                                                <td>{{ (isset($page->page_video) && empty($page->page_video) === false) ? $page->page_video->video : 'No disponible'}}</td>
                                            @endif
                                            <?php /*td>
                                                <a class="btn btn-warning" href="{{url('pages/edit/'.$pageType.'/'.$page->id)}}">@lang('lng.Edit')</a>
                                            </td */?>
                                        </tr>
                                        <div class="modal fade" id="exampleModalCenter<?php echo $page->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <b>Are you sure?</b>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a class="btn btn-danger" href="{{url('pages/delete/'.$page->id)}}">@lang('lng.Delete')</a>
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