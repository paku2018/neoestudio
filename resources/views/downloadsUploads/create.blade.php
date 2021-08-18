@extends('dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@lang('lng.Create') {{$option}} @if(!empty($folder))({{$folder->name}}
                            )@endif ({{$studentType}})</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}"@lang('lng.Home')</a></li>
                            @if(!empty($folder))
                                <li class="breadcrumb-item active">
                                    <a href="{{url('downloadsUploadsInsideFolderCreate/'.$option.'/'.$folder->id.'/'.$studentType)}}">@lang('lng.Create') {{$option}} @if(!empty($folder)){{$folder->name}}@endif {{$studentType}}</a>
                                </li>
                            @endif
                            @if(empty($folder))
                                <li class="breadcrumb-item active">
                                    <a class="btn btn-default" href="{{url('downloadsUploadsOnlyFiles/'.$option.'/'.$studentType)}}">@lang('lng.Create Files')</a>
                                </li>
                            @endif
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
        @if (\Session::has('message2'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5> @lang('lng.Alert')!</h5>
                {!! \Session::get('message2') !!}
            </div>
        @endif
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <form id="Form1" method="POST" action="{{url('downloadsUploadsInsideFolderStore')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body container" style="width: 50%">


                            <input type="hidden" name="option" value="{{$option}}">
                            <input type="hidden" name="studentType" value="{{$studentType}}">
                            @if(!empty($folder))
                                <input type="hidden" name="folderId" value="{{$folder->id}}">
                            @endif
                            @if(empty($folder))
                                <input type="hidden" name="folderId" value="empty">
                            @endif

                            <div class="form-group">
                                <label for="title">Título</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="title" id="Título" value="" placeholder="Title">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputFile">@lang('lng.Provide Material')</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="materialFile" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                                    </div>
                                    <img id="i1" style="display: none; width: 40px; height:auto;" src="{{asset('spinner/Spinner2.svg')}}" style="background-color: orange">

                                </div>
                            </div>

                            <?php
                            $courses = \App\Course::all();
                            ?>
                            @if(!empty($courses))
                                <div class="form-group">
                                    <label>@lang('lng.Courses')</label>
                                    <select class="form-control" name="courseId">
                                        <option selected disabled>@lang('lng.Choose here')</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif


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
        $("#downloadsUploads").css('background-color', '#6c757d');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
    <script type="text/javascript">
        var frm = $('#Form1');

        frm.submit(function (e) {
            $("#i1").css('display', 'block');

        });
    </script>
@endsection