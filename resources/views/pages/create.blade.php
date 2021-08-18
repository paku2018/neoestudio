@extends('dashboard')
@section('content')
<script src='https://cdn.tiny.cloud/1/7nple2g6lx4i235fpz577e36ven47s5k5u4ra75mn3qbnu5m/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script>
  tinymce.init({selector:'#in',
      content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
      toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
    content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}

});
  </script>
<style>
    .tox-statusbar__branding a{
        visibility:hidden;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Create News')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('news/create')}}">@lang('lng.Create News')</a></li>
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
          <form method="POST" action="{{url('news/store')}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.News')</label>
                    <textarea id="in" name="news"></textarea>
                  </div>
                  <div class="form-group">
                    <label>@lang('lng.Student Type')</label>
                    <select class="form-control" name="studentType">
                      <option selected disabled>@lang('lng.Choose here')</option>
                      <option value="@lang('lng.Trial')">@lang('lng.Trial')</option>
                      <option value="@lang('lng.First Year')">@lang('lng.First Year')</option>
                      <option value="@lang('lng.Second Year')">@lang('lng.Second Year')</option>
                    </select>
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
  $("#news").css('background-color','#6c757d');
</script>
@endsection