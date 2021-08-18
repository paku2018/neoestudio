@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar Calendario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{url('calenders/edit/'.$calender->id)}}">Editar calendario</a></li>
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
          <form method="POST" action="{{url('calenders/update/'.$calender->id)}}">
            {{ csrf_field() }}
                <div class="card-body container" style="width: 50%">
                  <div class="form-group">
                    <label for="name">Fetcha</label>
                    <input type="date" class="form-control" name="date"
                     placeholder="@if(!empty($calender)){{$calender->date}}@endif"
                     value="@if(!empty($calender)){{$calender->date}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Descripción</label>
                    <input type="text" class="form-control" name="description"
                     placeholder="@if(!empty($calender)){{$calender->description}}@endif"
                     value="@if(!empty($calender)){{$calender->description}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Color</label>
                    <select class="form-control" name="color">
                      @if(!empty($calender->color))
                        @if($calender->color=="#b61a1b")
                        <option selected value="#b61a1b">Red</option>
                        <option value="#3f5d68">Blue</option>
                        @endif
                        @if($calender->color=="#3f5d68")
                        <option value="#b61a1b">Red</option>
                        <option selected value="#3f5d68">Blue</option>
                        @endif
                      @endif
                      @if(empty($calender->color))
                        <option selected disabled>Seleccionar el color</option>
                        <option value="#b61a1b">Red</option>
                        <option value="#3f5d68">Blue</option>
                      @endif
                    </select>
                  </div>
                  <!--<div class="form-group">
                    <label for="name">Background Color</label>
                    <input type="color" class="form-control" name="bgColor"
                     placeholder="@if(!empty($calender)){{$calender->bgColor}}@endif"
                     value="@if(!empty($calender)){{$calender->bgColor}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Color</label>
                    <input type="color" class="form-control" name="color"
                     placeholder="@if(!empty($calender)){{$calender->color}}@endif"
                     value="@if(!empty($calender)){{$calender->color}}@endif" required>
                  </div>-->
                  <!--
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
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
  $("#calenders").css('background-color','#6c757d');
</script>
@endsection