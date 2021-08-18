@extends('dashboard')
@section('content')
<style type="text/css">
@font-face {
  font-family: "Regular";
  src: url("{{asset('neostudio/pnswr.ttf')}}");
}
@font-face {
  font-family: "Bold";
  src: url("{{asset('neostudio/psttf.ttf')}}");
}
@font-face {
  font-family: "Rounded";
  src: url("{{asset('neostudio/re.ttf')}}");
}

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$folder->name}} @lang('lng.Faqs')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('faqs/'.$folder->id)}}">@lang('lng.Faqs')</a></li>
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
          <div class="card">
                        <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title"><a class="btn btn-default" href="{{url('faqs/create/'.$folder->id)}}">@lang('lng.Create Faqs')</a></h3>
            </div>
            <div class="card-body"  style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>@lang('lng.Question')</th>
                  <!--<th>@lang('lng.Answer')</th>-->
                  <th id="view">@lang('lng.View')</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($faqs))
                  @foreach($faqs as $faq)
                    <tr>
                      <td>{{$faq->id}}</td>
                      <td>{!!$faq->question!!}</td>
                      <!--<td>{{substr($faq->answer, 0, 15)}}</td>-->
                      
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $faq->id ?>">
                        @lang('lng.View')
                        </button></td>
                      
                      <td><a class="btn btn-warning" href="{{url('faqs/edit/'.$faq->id)}}">@lang('lng.Edit')</a></td>
                      <!--<td><a class="btn btn-danger" href="{{url('faqs/delete/'.$faq->id)}}">@lang('lng.Delete')</a></td>-->
                      <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter2<?php echo $faq->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $faq->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>@lang('lng.View Question & Answers')</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p><b>@lang('lng.Question')</b> :&nbsp;{!!$faq->question!!}</p>
                                <p><b>@lang('lng.Answer')</b> :&nbsp;{!!$faq->answer!!}</p>
                                
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter2<?php echo $faq->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('faqs/delete/'.$faq->id)}}">@lang('lng.Delete')</a>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                  @endforeach
                @endif
                
              
                
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
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
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
  $("#view").removeClass('sorting');
</script>
@endsection