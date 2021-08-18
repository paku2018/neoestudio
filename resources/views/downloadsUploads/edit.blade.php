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
                            <li class="breadcrumb-item active"><a
                                        href="{{url('downloadsUploadsInsideFolderEdit/'.$downloadUpload->id)}}">@lang('lng.Edit Materials')</a>
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
                    <form method="POST" action="{{url('downloadsUploadsInsideFolderUpdate/'.$downloadUpload->id)}}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body container" style="width: 50%">

                            <div class="form-group">
                                <label for="title">Título</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="title" id="title" value="{{ $downloadUpload->title ?? '' }}" placeholder="Título">
                                </div>
                            </div>

                            <div class="form-inline">
                                <input type="checkbox" class="form-control" name="check"><label>@lang('lng.Use This')
                                    &nbsp; &nbsp;</label><a
                                        href="{{url('downloadsUploadsDownload/'.$downloadUpload->id)}}"
                                        class="btn btn-success btn-sm">@lang('lng.Download')</a>
                            </div>
                        <!--<input type="text" class="form-control" name="filePath" value="{{$downloadUpload->file}}">-->
                            <br>
                            <p>@lang('lng.OR')</p><br>
                            <div class="form-group">
                                <label for="exampleInputFile">@lang('lng.Provide New Material')</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="materialFile">
                                        <label class="custom-file-label"
                                               for="exampleInputFile">@lang('lng.Choose file')</label>
                                    </div>

                                </div>
                            </div>


                            <input type="hidden" name="studentType" value="{{$studentType}}">

                            <?php
                            $courses = \App\Course::all();
                            ?>
                            @if(!empty($courses))
                                <div class="form-group">
                                    <label>@lang('lng.Courses')</label>
                                    <select class="form-control" name="courseId">
                                        @foreach($courses as $course)
                                            @if($course->id==$downloadUpload->courseId)
                                                <option value="{{$course->id}}" selected>{{$course->name}}</option>
                                            @endif
                                            @if($course->id!=$downloadUpload->courseId)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endif
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
@endsection
