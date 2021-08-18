@extends('dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('lng.Edit')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{url('pages/video')}}">Videos</a></li>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action="{{url('pages/updateVideo/'.$page->id)}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" id="vid" name="vid" value="{{$page}}">
                        <div class="card-body container" style="width: 50%">

                            <div class="form-group">
                                <label>Video para el nombre de la página:</label>
                                {{$page->title}}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">@lang('lng.Provide New Video')</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="page_video">
                                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Orden de video <span style="font-size: 14px;color: #ff0000;">(para mostrar el video después de qué sección de contenido)</span></label>
                                <input type="number" id="order" name="order" class="form-control" min="0" value="{{ $page->page_video->order }}" placeholder="Pedido de sección"/>
                            </div>

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
    </script>
@endsection