<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/admin-panel')}}" class="brand-link">
    <!--<img src="{{url('/')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">-->
        <span class="brand-text font-weight-light">Proyecto Neoestudio</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(!empty(Auth::user()))
                    <?php
                    $image = Auth::user()->photo;
                    ?>
                    @if(!empty($image))
                        <img src="{{asset($image)}}" class="img-circle elevation-2" alt="User Image">
                    @endif
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">@if(!empty(Auth::user())){{Auth::user()->name}}@endif</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!--<li class="nav-header">LABELS</li>-->
                @if(!empty(Auth::user()))
                    @if(Auth::user()->role=="superAdmin" || Auth::user()->role=="admin"|| Auth::user()->role=="teacher")

                        <li class="nav-item has-treeview" id="students">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    @lang('lng.Students')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" id="stuP">
                                    <?php
                                    $prueba = "Prueba";
                                    $alumno = "Alumno";
                                    $alumnoConvocado = "Alumno Convocado";
                                    ?>
                                    <a href="{{url('prueba')}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item" id="stuA">
                                    <a href="{{url('alumno')}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item" id="stuAc">
                                    <a href="{{url('alumnoConvocado')}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('threads')}}" id="chat" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>Consultas</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview" id="prices">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Pagos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item" id="priB">
                                    <a href="{{url('pays/books')}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Temario</p>
                                    </a>
                                </li>
                                <li class="nav-item" id="priA">
                                    <a href="{{url('pays/alumno')}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Curso online</p>
                                    </a>
                                </li>
                                <li class="nav-item" id="priAc">
                                    <a href="{{url('pays/alumnoConvocado')}}" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Continuación curso online</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('news')}}" id="news" class="nav-link">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>@lang('lng.News')</p>
                            </a>
                        </li>
                        <li class="nav-item" id="faqs">
                            <a href="{{url('faqs/folders')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>FAQ</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview" id="exams">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    @lang('lng.Exams')
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?php
                                    $prueba = "Prueba";
                                    $alumno = "Alumno";
                                    $alumnoConvocado = "Alumno Convocado";

                                    ?>
                                    <a href="{{url('examsFolders/'.$prueba)}}" class="nav-link" id="exP">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('examsFolders/'.$alumno)}}" class="nav-link" id="exA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('examsFolders/'.$alumnoConvocado)}}" class="nav-link" id="exAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview" id="reviews">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Repaso
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?php
                                    $prueba = "Prueba";
                                    $prF = \App\Folder::where('type', 'reviews')->where('studentType', 'Prueba')->first();
                                    $alumno = "Alumno";
                                    $arF = \App\Folder::where('type', 'reviews')->where('studentType', 'Alumno')->first();
                                    $alumnoConvocado = "Alumno Convocado";
                                    $acrF = \App\Folder::where('type', 'reviews')->where('studentType', 'Alumno Convocado')->first();
                                    ?>
                                    <?php /*a href="{{url('insideReviewsFolders/'.$prueba.'/'.$prF->id)}}" class="nav-link" id="repP" */?>
                                    <a href="{{url('reviewsFolders/'.$prueba)}}" class="nav-link" id="repP">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php /*a href="{{url('insideReviewsFolders/'.$alumno.'/'.$arF->id)}}" class="nav-link" id="repA" */?>
                                    <a href="{{url('reviewsFolders/'.$alumno)}}" class="nav-link" id="repA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <?php /*a href="{{url('insideReviewsFolders/'.$alumnoConvocado.'/'.$acrF->id)}}" class="nav-link" id="repAc" */?>
                                    <a href="{{url('reviewsFolders/'.$alumnoConvocado)}}" class="nav-link" id="repAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview" id="personalities">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Personalidad
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?php
                                    $prueba = "Prueba";
                                    $pF = \App\Folder::where('type', 'personalities')->where('studentType', 'Prueba')->first();
                                    $alumno = "Alumno";
                                    $aF = \App\Folder::where('type', 'personalities')->where('studentType', 'Alumno')->first();
                                    $alumnoConvocado = "Alumno Convocado";
                                    $acF = \App\Folder::where('type', 'personalities')->where('studentType', 'Alumno Convocado')->first();

                                    ?>
                                    <a href="{{url('insidePersonalitiesFolders/'.$prueba.'/'.$pF->id)}}" class="nav-link" id="perP">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('insidePersonalitiesFolders/'.$alumno.'/'.$aF->id)}}" class="nav-link" id="perA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('insidePersonalitiesFolders/'.$alumnoConvocado.'/'.$acF->id)}}" class="nav-link" id="perAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview" id="surveys">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Encuestas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?php
                                    $prueba = "Prueba";
                                    $psF = \App\Folder::where('type', 'surveys')->where('studentType', 'Prueba')->first();
                                    $alumno = "Alumno";
                                    $asF = \App\Folder::where('type', 'surveys')->where('studentType', 'Alumno')->first();
                                    $alumnoConvocado = "Alumno Convocado";
                                    $acsF = \App\Folder::where('type', 'surveys')->where('studentType', 'Alumno Convocado')->first();

                                    ?>
                                    <a href="{{url('insideSurveysFolders/'.$prueba.'/'.$psF->id)}}" class="nav-link" id="surP">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('insideSurveysFolders/'.$alumno.'/'.$asF->id)}}" class="nav-link" id="surA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('insideSurveysFolders/'.$alumnoConvocado.'/'.$acsF->id)}}" class="nav-link" id="surAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item has-treeview" id="materials">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Audiolibro y classes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                <?php
                                $audio = "audio";
                                $video = "video";
                                $pdf = "pdf";
                                $others = "others";
                                ?>
                                <li class="nav-item has-treeview" id="inMa">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            Audio
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php
                                            $prueba = "Prueba";
                                            $alumno = "Alumno";
                                            $alumnoConvocado = "Alumno Convocado";
                                            ?>
                                            <a href="{{url('materialFolders/'.$audio.'/'.$prueba)}}" class="nav-link" id="audP">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Prueba</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('materialFolders/'.$audio.'/'.$alumno)}}" class="nav-link" id="audA">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('materialFolders/'.$audio.'/'.$alumnoConvocado)}}" class="nav-link" id="audAc">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno Convocado</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item has-treeview" id="inMa">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            PDF
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php
                                            $prueba = "Prueba";
                                            $alumno = "Alumno";
                                            $alumnoConvocado = "Alumno Convocado";
                                            ?>
                                            <a href="{{url('materialFolders/'.$pdf.'/'.$prueba)}}" class="nav-link" id="audP">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Prueba</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('materialFolders/'.$pdf.'/'.$alumno)}}" class="nav-link" id="audA">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('materialFolders/'.$pdf.'/'.$alumnoConvocado)}}" class="nav-link" id="audAc">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno Convocado</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item has-treeview" id="inMv">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            Classes
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php
                                            $prueba = "Prueba";
                                            $alumno = "Alumno";
                                            $alumnoConvocado = "Alumno Convocado";
                                            ?>
                                            <a href="{{url('materialFolders/'.$video.'/'.$prueba)}}" class="nav-link" id="vidP">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Prueba</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('materialFolders/'.$video.'/'.$alumno)}}" class="nav-link" id="vidA">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('materialFolders/'.$video.'/'.$alumnoConvocado)}}" class="nav-link" id="vidAc">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno Convocado</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                            </ul>
                        </li>

                        <!--st -->

                        <!-- end -->


                        <li class="nav-item has-treeview" id="downloadsUploads">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Descargas Y Subidas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                <?php
                                $downloads = "Descargas";
                                $uploads = "Subidas";
                                ?>
                                <li class="nav-item has-treeview" id="inDUd">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            Descargas
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php
                                            $prueba = "Prueba";
                                            $alumno = "Alumno";
                                            $alumnoConvocado = "Alumno Convocado";
                                            ?>
                                            <a href="{{url('downloadsUploadsFolders/'.$downloads.'/'.$prueba)}}" class="nav-link" id="downP">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Prueba</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('downloadsUploadsFolders/'.$downloads.'/'.$alumno)}}" class="nav-link" id="downA">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('downloadsUploadsFolders/'.$downloads.'/'.$alumnoConvocado)}}" class="nav-link" id="downAc">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno Convocado</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                </li>
                                <li class="nav-item">
                                <li class="nav-item has-treeview" id="inDUu">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            Subidas
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php
                                            $prueba = "Prueba";
                                            $alumno = "Alumno";
                                            $alumnoConvocado = "Alumno Convocado";
                                            ?>
                                            <a href="{{url('downloadsUploadsFolders/'.$uploads.'/'.$prueba)}}" class="nav-link" id="upP">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Prueba</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('downloadsUploadsFolders/'.$uploads.'/'.$alumno)}}" class="nav-link" id="upA">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('downloadsUploadsFolders/'.$uploads.'/'.$alumnoConvocado)}}" class="nav-link" id="upAc">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno Convocado</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                </li>

                            </ul>
                        </li>

                        {{--PDF Download and uploads - 210303--}}
                        <li class="nav-item has-treeview" id="downloadsUploads">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Pdf
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                <?php
                                $downloads = "DescargasPdf";
                                $uploads = "SubidasPdf";
                                ?>
                                {{--<li class="nav-item has-treeview" id="inDUd">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            Descargas
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">--}}
                                <li class="nav-item">
                                    <?php
                                    $prueba = "Prueba";
                                    $alumno = "Alumno";
                                    $alumnoConvocado = "Alumno Convocado";
                                    ?>
                                    <a href="{{url('downloadsUploadsFolders/'.$downloads.'/'.$prueba)}}" class="nav-link" id="downP">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('downloadsUploadsFolders/'.$downloads.'/'.$alumno)}}" class="nav-link" id="downA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('downloadsUploadsFolders/'.$downloads.'/'.$alumnoConvocado)}}" class="nav-link" id="downAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                                {{--</ul>
                            </li>--}}
                                <li class="nav-item"></li>
                                <?php /*li class="nav-item has-treeview" id="inDUu">
                                    <a href="#" class="nav-link">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="nav-icon far fa-circle text-danger"></i>
                                        <p>
                                            Subidas
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <?php
                                            $prueba = "Prueba";
                                            $alumno = "Alumno";
                                            $alumnoConvocado = "Alumno Convocado";
                                            ?>
                                            <a href="{{url('downloadsUploadsFolders/'.$uploads.'/'.$prueba)}}" class="nav-link" id="upP">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Prueba</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('downloadsUploadsFolders/'.$uploads.'/'.$alumno)}}" class="nav-link" id="upA">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{url('downloadsUploadsFolders/'.$uploads.'/'.$alumnoConvocado)}}" class="nav-link" id="upAc">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Alumno Convocado</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li */?>


                            </ul>
                        </li>
                        <?php
                        $prueba = "Prueba";
                        $alumno = "Alumno";
                        $alumnoConvocado = "Alumno Convocado";
                        ?>

                        <li class="nav-item has-treeview" id="calenders">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Calendario
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('calenders/'.$prueba)}}" class="nav-link" id="calP">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Prueba</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('calenders/'.$alumno)}}" class="nav-link" id="calA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('calenders/'.$alumnoConvocado)}}" class="nav-link" id="calAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <li class="nav-item" id="teachers">
                            <a href="{{url('teachers')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p class="text">@lang('lng.Teachers')</p>
                            </a>
                        </li>

                        <li class="nav-item" id="comments">
                            <a href="{{url('comments')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-success"></i>
                                <p>Observaciones</p>
                            </a>
                        </li>
                        <li class="nav-item" id="combines">
                            <a href="{{url('commulative')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-success"></i>
                                <p>Commulative Marking</p>
                            </a>
                        </li>
                        <li class="nav-item" id="courses">
                            <a href="{{url('courses')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>@lang('lng.Courses')</p>
                            </a>
                        </li>


                        <li class="nav-item" id="courseprice">
                            <a href="{{url('courseprice')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>Temario precio</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview" id="precios">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Precios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?php

                                    $alumno = "Alumno";
                                    $alumnoConvocado = "Alumno Convocado";
                                    ?>
                                    <a href="{{url('prices/'.$alumno)}}" class="nav-link" id="precA">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{url('prices/'.$alumnoConvocado)}}" class="nav-link" id="precAc">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Alumno Convocado</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item has-treeview" id="paginas">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-circle text-danger"></i>
                                <p>
                                    Paginas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('pages/content')}}" class="nav-link" id="pageC">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Contenido</p>
                                    </a>
                                </li>

                                <?php /*li class="nav-item">
                                    <a href="{{url('pages/video')}}" class="nav-link" id="pageV">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Videos</p>
                                    </a>
                                </li */?>

                            </ul>
                        </li>
                        <li class="nav-item" id="products">
                            <a href="{{url('products')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>@lang('lng.Products')</p>
                            </a>
                        </li>

                        <li class="nav-item" id="shippings">
                            <a href="{{url('shippings')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>Envíos</p>
                            </a>
                        </li>

                        <?php /*li class="nav-item" id="services">
                            <a href="{{url('services')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>@lang('lng.Services')</p>
                            </a>
                        </li */?>


                        <li class="nav-item" id="service_packages">
                            <a href="{{url('service_packages')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>Paquetes de servicios</p>
                            </a>
                        </li>
                    @endif

                <!--
          <li class="nav-item" id="materials">
            <a href="{{url('materials')}}" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">@lang('lng.Course Material')</p>
            </a>
          </li>
          -->



                    <li class="nav-item" id="topics">
                        <a href="{{url('topics')}}" id="#" class="nav-link">
                            <i class="nav-icon far fa-circle text-info"></i>
                            <p>Temas</p>
                        </a>
                    </li>




                <!--
          <li class="nav-item" id="questions">
            <a href="{{url('questions')}}" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p class="text">@lang('lng.Questions & Answers')</p>
            </a>
          </li>-->






                    @if(Auth::user()->role=="superAdmin"||Auth::user()->role=="admin")
                        <li class="nav-item" id="admins">
                            <a href="{{url('admins')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>Admins</p>
                            </a>
                        </li>
                        <li class="nav-item" id="backups">
                            <a href="{{url('get-backups')}}" class="nav-link">
                                <i class="nav-icon far fa-circle text-warning"></i>
                                <p>Backups</p>
                            </a>
                        </li>
                    @endif


                    <li class="nav-item" id="#">
                        <a href="{{url('logoutUser')}}" class="nav-link">
                            <i class="nav-icon far fa-circle text-info"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                    <!--
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>Results</p>
                      </a>
                    </li>
                  -->
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
