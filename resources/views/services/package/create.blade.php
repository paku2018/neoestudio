@extends('dashboard')
@section('content')
    <script src='https://cdn.tiny.cloud/1/z1hl3qqmyny67w62qg9g9rng1zr1sh1gi99ox8str4gbmadn/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.in',
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
                    <form method="POST" action="{{url('services/store_package')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body container">
                            <div class="form-group">
                                <label for="title">@lang('lng.Name')</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="@lang('lng.Name')" required/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Foto sin reflejos</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile" required>
                                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Foto con reflejos</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image_active" id="exampleInputFile2" required>
                                        <label class="custom-file-label" for="exampleInputFile2">@lang('lng.Choose file')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price">Etiqueta de precio<span style="font-size: 14px;color: #ff0000;">(Texto para mostrar por encima del precio)</span></label>
                                <input type="text" id="price_text" name="price_text" class="form-control" value="{{ old('price_text') }}" placeholder="Etiqueta de precio" required/>
                            </div>
                            @if($package_prices)
                                @foreach($package_prices AS $package_price)
                                    <h3>{{ ucwords($package_price)}}</h3>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="price">Precio anual
                                                <span style="font-size: 14px;color: #ff0000;"> (Escriba solo un n??mero o un valor decimal)</span></label>
                                            <input type="text" id="{{$package_price}}_price_annual" name="{{$package_price}}_price_annual" class="form-control" value="" placeholder="Precio anual" required/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="price">Precio fraccionado
                                                <span style="font-size: 14px;color: #ff0000;"> (Escriba solo un n??mero o un valor decimal)</span></label>
                                            <input type="text" id="{{$package_price}}_price_fractional" name="{{$package_price}}_price_fractional" class="form-control" value="" placeholder="Precio fracto" required/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="price">Precio mensual
                                                <span style="font-size: 14px;color: #ff0000;"> (Escriba solo un n??mero o un valor decimal)</span></label>
                                            <input type="text" id="{{$package_price}}_price_monthly" name="{{$package_price}}_price_monthly" class="form-control" value="" placeholder="Precio mensual" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="price">Texto para anual</label>
                                            <input type="text" id="{{$package_price}}_text_annual" name="{{$package_price}}_text_annual" class="form-control" value="" placeholder="Texto para anual"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="price">Texto durante seis meses</label>
                                            <input type="text" id="{{$package_price}}_text_fractional" name="{{$package_price}}_text_fractional" class="form-control" value="" placeholder="Texto durante seis meses"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="price">Texto para mensual</label>
                                            <input type="text" id="{{$package_price}}_text_monthly" name="{{$package_price}}_text_monthly" class="form-control" value="" placeholder="Texto para mensual"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="price">Descripci??n de la factura Anual</label>
                                            <textarea class="in" name="annual[]"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="price">Descripci??n de la factura Seis meses</label>
                                            <textarea class="in" name="fractional[]"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="price">Descripci??n de la factura Mensual</label>
                                            <textarea class="in" name="monthly[]"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label for="order">@lang('lng.Service Package') <span style="font-size: 14px;color: #ff0000;">(Escriba solo un n??mero)</span></label>
                                <input type="number" id="order" name="order" class="form-control" min="0" value="{{ (old('order')) ? old('order') : 1 }}" placeholder="Pedido de secci??n"/>
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

        $("#service_packages").css('background-color', '#6c757d');
        $("#service_packages").addClass('menu-open');
        $("#edit").removeClass('sorting');
        $("#delete").removeClass('sorting');
    </script>
@endsection