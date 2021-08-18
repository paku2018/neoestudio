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
                        <h1 class="m-0 text-dark">@lang('lng.Create Service Package')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{url('service_packages')}}">@lang('Service Packages')</a></li>
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
                    <form method="POST" action="{{url('store_package_texts')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body container" style="width: 50%">
                            @if($packages_texts)
                                @foreach($packages_texts AS $packages_text)
                                    <div class="form-group">
                                        <label for="title">Texto arriba {{ str_replace('_',' ',$packages_text->type) }}</label>
                                        <input type="text" id="title" name="titles[{{$packages_text->type}}]" class="form-control" value="{{$packages_text->title }}" placeholder="título"/>
                                    </div>
                                @endforeach
                            @endif
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

        $("#service_packages").css('background-color', '#6c757d');
        $("#service_packages").addClass('menu-open');
        $("#edit").removeClass('sorting');
        $("#delete").removeClass('sorting');
    </script>
@endsection