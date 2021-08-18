@extends('dashboard')
@section('content')
<script src='https://cdn.tiny.cloud/1/z1hl3qqmyny67w62qg9g9rng1zr1sh1gi99ox8str4gbmadn/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'#in',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});</script>
<script>tinymce.init({selector:'#in2',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});</script>
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
            <h1 class="m-0 text-dark">Editar FAQ</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('faqs/edit/'.$faq->id)}}">@lang('lng.Edit Faqs')</a></li>
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
          <form method="POST" action="{{url('faqs/update/'.$faq->id)}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">@lang('lng.Question')</label>
                    <textarea id="in" name="question">@if(!empty($faq)){{$faq->question}}@endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Answer')</label>
                    <textarea id="in2" name="answer">@if(!empty($faq)){{$faq->answer}}@endif</textarea>
                  </div>
                 
                  <!--
                  <div class="form-group">
                    <label for="newspleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="newspleInputFile">
                        <label class="custom-file-label" for="newspleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="newspleCheck1">
                    <label class="form-check-label" for="newspleCheck1">Check me out</label>
                  </div>
                </div>
                 -->

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
  $("#faqs").css('background-color','#6c757d');
</script>
@endsection