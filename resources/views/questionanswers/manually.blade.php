@extends('dashboard')
@section('content')
<script src='https://cdn.tiny.cloud/1/z1hl3qqmyny67w62qg9g9rng1zr1sh1gi99ox8str4gbmadn/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script>
  tinymce.init({selector:'#question',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
   content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});
  </script>
  <script>
  tinymce.init({selector:'#answer1',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
   content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});
  </script>  
  <script>
  tinymce.init({selector:'#answer2',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
   content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});
  </script>
  <script>
  tinymce.init({selector:'#answer3',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
   content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});
  </script>
  <script>
  tinymce.init({selector:'#answer4',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
   content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});
  </script>
  <script>
  tinymce.init({selector:'#description',content_css:"{{asset('new/mycss.css')}}",
      font_formats:'Regular=Regular;Bold=Bold;Rounded=Rounded;',
    toolbar: "sizeselect | bold italic | fontselect |  fontsizeselect",
    fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 24pt 36pt",
   content_style: "body { font-size: 13pt;}",
    forced_root_block : 'p',
forced_root_block_attrs: {
    'style': 'font-size: 13pt;'
}});
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
            <h1 class="m-0 text-dark">Crear Preguntas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('manually/'.$examId)}}">@lang('lng.Edit questions')</a></li>
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
          <form method="POST" action="{{url('manuallyStore')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  
                  
                  <input type="hidden" name="examId" value="{{$examId}}">
                  
                  <div class="form-group">
                    <label for="name">@lang('lng.Question')</label>
                    <textarea id="question" class="form-control" name="question"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Answer1')</label>
                    <textarea id="answer1" class="form-control" name="answer1"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Answer2')</label>
                    <textarea id="answer2" class="form-control" name="answer2"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Answer3')</label>
                    <textarea id="answer3" class="form-control" name="answer3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Answer4')</label>
                    <textarea id="answer4" class="form-control" name="answer4"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Correct')</label>
                    <input type="text" class="form-control" name="correct">
                  </div>
                  <div class="form-group">
                    <label for="name">@lang('lng.Description')</label>
                    <textarea id="description" class="form-control" name="description"></textarea>
                  </div>
                  
                                                <br><p>Si alguna</p><br>
                  <div class="form-group">
                    <label for="exampleInputFile">@lang('lng.Provide New Material')</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image">
                        <label class="custom-file-label" for="exampleInputFile">@lang('lng.Choose file')</label>
                      </div>
                      
                    </div>
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

<?php
$exam=\App\Exam::find($examId);
  $f=\App\Folder::find($exam->folderId);
 ?>
@endsection
@section('javascript')
<script type="text/javascript">
   var type="<?php echo $f->type ?>";
  var ty="<?php echo $f->studentType ?>";
  if(type=="exams"){
    
    if(ty=="Prueba"){
      $("#exP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#exA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#exAc").css('background-color','#6c757d');
    }
    $("#exams").addClass('menu-open');
  }
  if(type=="personalities"){
    if(ty=="Prueba"){
      $("#perP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#perA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#perAc").css('background-color','#6c757d');
    }
    $("#personalities").addClass('menu-open');
  }
  if(type=="reviews"){
    if(ty=="Prueba"){
      $("#repP").css('background-color','#6c757d');
    }
    if(ty=="Alumno"){
      $("#repA").css('background-color','#6c757d');
    }
    if(ty=="Alumno Convocado"){
      $("#repAc").css('background-color','#6c757d');
    }
    $("#reviews").addClass('menu-open');
  }
  //$("#exams").css('background-color','#6c757d');
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection