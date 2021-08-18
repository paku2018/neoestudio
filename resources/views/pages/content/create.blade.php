@extends('dashboard')
@section('content')
    <script src='https://cdn.tiny.cloud/1/z1hl3qqmyny67w62qg9g9rng1zr1sh1gi99ox8str4gbmadn/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#in',
            content_css: "{{asset('new/mycss.css')}}",
            font_formats: 'Regular=Regular;Bold=Bold;Rounded=Rounded;',
            toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect | link",
            fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
            content_style: "body { font-size: 13pt;}",
            forced_root_block: 'p',
            forced_root_block_attrs: {
                'style': 'font-size: 13pt;'
            },
            plugins: 'link',
            init_instance_callback: function (editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            }
        });
    </script>
    <style>
        .tox-statusbar__branding a {
            visibility: hidden;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Crear sección de contenido</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{url('pages/edit/content/'.$id)}}">Contenido de página</a></li>
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
                    <form method="POST" action="{{url('pages/store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="pid" id="pid" value="{{base64_encode($id)}}">
                        <div class="card-body container" style="width: 50%">
                            <div class="form-group">
                                <label for="name">Sección de título</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Sección de título"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Cargar icono de sección</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                                    </div>
                                </div>
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
                                <label for="name">Descripción de la sección</label>
                                <textarea id="in" name="description">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">Pedido de sección <span style="font-size: 14px;color: #ff0000;">(Escriba solo un número)</span></label>
                                <input type="number" id="order" name="order" class="form-control" min="0" value="{{ old('order') }}" placeholder="Pedido de sección"/>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('lng.Submit')</button>
                            </div>
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