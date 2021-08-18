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
                        <h1 class="m-0 text-dark">@lang('lng.Create Product')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{url('products')}}">@lang('Products')</a></li>
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
                    <form method="POST" action="{{route('products.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body container" style="width: 50%">
                            <div class="form-group">
                                <label for="name">@lang('lng.Name')</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="@lang('lng.Name')" required/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">@lang('lng.Photo')</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile" required>
                                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('lng.Description')</label>
                                <textarea id="in" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">@lang('lng.Price') <span style="font-size: 14px;color: #ff0000;">(Escriba solo un número o un valor decimal)</span></label>
                                <input type="text" id="price" name="price" class="form-control" value="{{ old('price') }}" placeholder="@lang('lng.Price')" required/>
                            </div>
                            <div class="form-group">
                                <label for="order">@lang('lng.Product') <span style="font-size: 14px;color: #ff0000;">(Escriba solo un número)</span></label>
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

        $("#products").css('background-color', '#6c757d');
        $("#products").addClass('menu-open');

        $("input[name*='price']").keydown(function (event) {
            if (event.shiftKey == true) {
                event.preventDefault();
            }
            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
            } else {
                event.preventDefault();
            }
            if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();
            //if a decimal has been added, disable the "."-button
        });

    </script>
@endsection