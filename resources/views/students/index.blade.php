@extends('dashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('lng.Students') {{$ty}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('home')}}">@lang('lng.Home')</a></li>
              <li class="breadcrumb-item active"><a href="{{url('students')}}">@lang('lng.Students')</a></li>
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
             <!-- <h3 class="card-title"><a class="btn btn-default" href="{{url('students/create')}}">@lang('lng.Create New Student')</a></h3>-->
            </div>
            <div class="card-body" style="overflow-x: scroll;">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <!--<th>@lang('lng.Scale')</th>-->
                  <th>Telephone</th>
                  <!--<th>@lang('lng.Name')</th>-->
                  <th>@lang('lng.Email')</th>
                  <!--<th>@lang('lng.Telephone')</th>
                  <th>@lang('lng.Type')</th>
                  <th>Baremo</th>
                  <th>Suscripción de e-mail</th>-->
                  <th>Usuario</th>
                  <th>@lang('lng.Password')</th>
                  <th>Observaciones</th>
                  <th>Detalle</th>
                  <th id="examDetail">Examenes</th>
                  <th id="rankDetail">Ranking</th>
                  <th id="surveyDetail">Encuestas</th>
                  <th id="edit">@lang('lng.Edit')</th>
                  <th id="block">Bloquear</th>
                  <th id="delete">@lang('lng.Delete')</th>
                  
                </tr>
                </thead>
                <tbody>
                @if(!empty($students))
                  @foreach($students as $student)
                  <?php
                    $reg=\App\Register::where('userId',$student->id)->first();
                   ?>
                    <tr>
                      <td>{{$student->id}}</td>
                      <!--<td>{{$student->scale}}</td>-->
                      <td>{{$student->telephone}}</td>
                      <!--<td>{{$student->name}}</td>-->
                      <td>{{$student->email}}</td>
                      <!--<td>{{$student->telephone}}</td>
                      <td>{{$student->type}}</td>
                      <td>{{$student->baremo}}</td>
                      <td>{{$student->emailSubscription}}</td>-->
                      <td>{{$student->studentCode}}</td>
                      <td>@if(!empty($student)){{$student->password}}@endif</td>
                      <td>
                        <?php 
                          $commE=\App\Comment::where('userId',$student->id)->exists();
                          if($commE==true){
                            $comm=\App\Comment::where('userId',$student->id)->first();
                            $comment=$comm->comment;
                          }
                          if($commE==false){
                            $comment=null;
                          }

                        ?>
                        <form id="fm{{$student->id}}" method="POST" action="{{url('comments/store')}}">
                          {{ csrf_field() }}
                          <textarea name="comment" value="@if(!empty($comment)){{$comment}}@endif">@if(!empty($comment)){{$comment}}@endif</textarea><br>
                         
                          <input type="hidden" name="userId" value="{{$student->id}}">
                          <input type="submit" value="Enviar">
                        </form>
                      </td>
                      <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter<?php echo $student->id ?>">
                        @lang('lng.View')
                        </button></td>
                      
                      <td><a class="btn btn-success" href="{{url('studentExamsById/'.$student->id)}}">Examenes</a></td>
                      <td><div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Choose Type
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{url('studentRankingsById/'.$student->id)}}">With Temas</a>
                            <a class="dropdown-item" href="{{url('studentRankings2ById/'.$student->id)}}">Without Temas</a>
                            <a class="dropdown-item" href="{{url('googleChart?studentId='.$student->id)}}">Google Chart</a>
                          </div>
                        </div></td>
                      
                      <td><a class="btn btn-success" href="{{url('studentSurveysById/'.$student->id)}}">Encuestas</a></td>

                      <td><a class="btn btn-warning" href="{{url('students/edit/'.$student->id)}}">@lang('lng.Edit')</a></td>
                       @if(empty($student->field1x))
                        <?php $field1x='Desbloquear'; ?>
                      @endif
                      @if(!empty($student->field1x))
                        <?php $field1x=$student->field1x; ?>
                      @endif

                      @if(!empty($field1x))
                      <td><a class="btn btn-danger" href="{{url('studentsBlock/'.$student->id)}}">{{$field1x}}</a></td>
                      @endif
                      

                      <!--<td><a class="btn btn-danger" href="{{url('students/delete/'.$student->id)}}">@lang('lng.Delete')</a></td>-->
                       <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter2<?php echo $student->id ?>">
                        @lang('lng.Delete')
                        </button></td>
                    </tr>
                    <div class="modal fade" id="exampleModalCenter<?php echo $student->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Detalle</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                @if(!empty($reg))
                                <p><b>Nombre de usuario</b> :&nbsp;{{$reg->usuario}}</p>
                                <p><b>DNI</b> :&nbsp;{{$reg->dni}}</p>
                                <p><b>Correo electrónico</b> :&nbsp;{{$reg->electronico}}</p>
                                <p><b>Contrasena</b> :&nbsp;{{$reg->contrasena}}</p>
                                <p><b>Teléfono móvil</b> :&nbsp;{{$reg->telefono}}</p>
                                <p><b>Nombre y apelidos</b> :&nbsp;{{$reg->surname}}</p>
                                <p><b>Domicilio, num, bloque, piso y letra</b> :&nbsp;{{$reg->domi}}</p>
                                <p><b>Código postal</b> :&nbsp;{{$reg->postal}}</p>
                                <p><b>Localidad, Provincia</b> :&nbsp;{{$reg->localidad}}</p>
                                <p><b>Baremo</b> :&nbsp;{{$student->baremo}}</p>
                                @endif
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter2<?php echo $student->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <b>Are you sure?</b>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <a class="btn btn-danger" href="{{url('students/delete/'.$student->id)}}">@lang('lng.Delete')</a>
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
  var type="<?php echo $ty ?>";
  $("#students").addClass('menu-open');
  if(type=="Prueba"){
    $("#stuP").css('background-color','#6c757d');
  }
  if(type=="Alumno"){
    $("#stuA").css('background-color','#6c757d');
  }
  if(type=="Alumno Convocado"){
    $("#stuAc").css('background-color','#6c757d');
  }
  //$("#students").css('background-color','#6c757d');
  $("#edit").removeClass('sorting');
  $("#delete").removeClass('sorting');
  $("#examDetail").removeClass('sorting');
  $("#rankDetail").removeClass('sorting');
  $("#surveyDetail").removeClass('sorting');
</script>
@endsection