<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{
    public function emailSubscription(Request $request)
    {
        $id = $request->json('id');

        $ue = \App\User::where('id', $id)->exists();
        if ($ue == false) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
        $user = \App\User::find($id);
        if (!empty($user)) {
            $user->emailSubscription = $request->json('emailSubscription');
            $user->save();
            return response()->json(['status' => 'Successfull', 'data' => $user]);
        }
        if (empty($user)) {
            return response()->json(['status' => 'Unsuccessfull', 'message' => 'User not found']);
        }
    }

    public function loginStudent(Request $request)
    {
        $email = $request->json('email');
        $password = $request->json('password');
        $telephone = $request->json('telephone');
        $studentCode = $request->json('studentCode');
        $type = $request->get('type');
        if ($type == "true") {
            if (!empty($studentCode) && !empty($password)) {

                $exists = \App\User::where('studentCode', $studentCode)
                    ->where('password', $password)->exists();
                if ($exists == false) {
                    $message = "El código o contraseña del estudiante es incorrecto";
                    return response()->json(['status' => 'Unsucessfull', 'message' => $message]);
                }
                if ($exists == true) {
                    $user = \App\User::where('studentCode', $studentCode)
                        ->where('password', $password)->first();
                    /*if(isset($user->isLogin) && $user->isLogin == "yes"){
                        return response()->json(['status' => $user->isLogin, 'message' => '¡Ya iniciado sesión!', 'data' => array()]);
                    }*/
                    User::where('id',$user->id)->update(['isLogin' => 'yes']);
                    return response()->json(['status' => 'Sucessfull', 'data' => $user]);
                }
            }
        }
        if ($type == "false") {
            $exists = \App\User::where('email', $email)
                ->where('telephone', $telephone)->exists();
            if ($exists == false) {
                $emEx = \App\User::where('email', $email)->exists();
                if ($emEx == true) {
                    $message = "el Email ya existe";
                    return response()->json(['status' => 'Unsucessfull', 'message' => $message]);
                }
                $tlEx = \App\User::where('telephone', $telephone)->exists();
                if ($tlEx == true) {
                    $message = "el teléfono ya existe";
                    return response()->json(['status' => 'Unsucessfull', 'message' => $message]);
                }
                $student = new \App\User;
                $student->email = $request->get('email');
                $student->telephone = $request->get('telephone');
                $student->type = "Prueba";
                $student->emailSubscription = null;
                $ex = \App\User::exists();
                if ($ex == true) {
                    $max = \App\User::where('role', 'student')->where('type', 'Prueba')->max('scale');
                    if ($max == null) {
                        $student->scale = 0;
                    }
                    if ($max != null) {
                        $student->scale = $max + 1;
                    }
                }
                if ($ex == false) {
                    $student->scale = 0;
                }
                $student->role = "student";
                $student->isLogin = "yes";
                $student->save();
                $news = \App\Alert::where('studentType', $student->type)->get();
                foreach ($news as $key => $value) {
                    $ar = new \App\AlertRecord;
                    $ar->studentId = $student->id;
                    $ar->news = $value->news;
                    $ar->newsId = $value->id;
                    $ar->status = "unseen";
                    $ar->save();
                }
                $efe = \App\Folder::where('studentType', $student->type)->where('type', 'exams')->exists();
                $rfe = \App\Folder::where('studentType', $student->type)->where('type', 'reviews')->exists();
                $pfe = \App\Folder::where('studentType', $student->type)->where('type', 'personalities')->exists();
                if ($efe == true) {
                    $ef = \App\Folder::where('studentType', $student->type)->where('type', 'exams')->get();
                    $efArray = array();
                    foreach ($ef as $efv) {
                        array_push($efArray, $efv->id);
                    }
                    $examExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $efArray)->exists();


                    if ($examExists == true) {
                        $exams = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $efArray)->get();
                        foreach ($exams as $exam) {
                            $notiE = new \App\Notification;
                            $notiE->studentId = $student->id;
                            $notiE->type = "exams";
                            $notiE->status = "pending";
                            $notiE->typeId1 = $exam->id;

                            $notiE->save();
                        }
                    }
                }
                if ($rfe == true) {
                    $rf = \App\Folder::where('studentType', $student->type)->where('type', 'reviews')->get();
                    $rfArray = array();
                    foreach ($rf as $rfv) {
                        array_push($rfArray, $rfv->id);
                    }
                    $reviewExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $rfArray)->exists();
                    if ($reviewExists == true) {
                        $reviews = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $rfArray)->get();
                        foreach ($reviews as $review) {
                            $notiE = new \App\Notification;
                            $notiE->studentId = $student->id;
                            $notiE->type = "reviews";
                            $notiE->status = "pending";
                            $notiE->typeId1 = $review->id;

                            $notiE->save();
                        }

                    }
                }
                if ($pfe == true) {
                    $pf = \App\Folder::where('studentType', $student->type)->where('type', 'personalities')->get();
                    $pfArray = array();
                    foreach ($pf as $pfv) {
                        array_push($pfArray, $pfv->id);
                    }
                    $personalityExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $pfArray)->exists();
                    if ($personalityExists == true) {
                        $personalities = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $pfArray)->get();
                        foreach ($personalities as $personality) {
                            $notiE = new \App\Notification;
                            $notiE->studentId = $student->id;
                            $notiE->type = "personalities";
                            $notiE->status = "pending";
                            $notiE->typeId1 = $personality->id;

                            $notiE->save();
                        }

                    }
                }
                $descargasExists = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $student->type)->where('option', 'Descargas')->exists();
                $subidasExists = \App\Folder::where('status', 'Habilitado')->where('studentType', $student->type)->where('type', 'Subidas')->exists();
                $topicExists = \App\Topic::where('studentType', $student->type)->exists();
                if ($topicExists == true) {
                    $topics = \App\Topic::where('studentType', $student->type)->get();
                    $topicArray = array();
                    foreach ($topics as $topic) {
                        array_push($topicArray, $topic->id);
                    }
                    if (!empty($topicArray)) {
                        $audioExists = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->exists();
                        $videoExists = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->exists();
                    }
                }
                $folderExists = \App\Folder::where('studentType', $student->type)->where('type', 'surveys')->exists();
                if ($folderExists == true) {
                    $folders = \App\Folder::where('studentType', $student->type)->where('type', 'surveys')->get();
                    $folderArray = array();
                    foreach ($folders as $folder) {
                        array_push($folderArray, $folder->id);
                    }
                    if (!empty($folderArray)) {
                        $surveyExists = \App\Survey::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $folderArray)->exists();
                    }
                }

                if ($descargasExists == true) {
                    $dess = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $student->type)->where('option', 'Descargas')->get();
                    foreach ($dess as $key => $des) {
                        $notiDes = new \App\Notification;
                        $notiDes->studentId = $student->id;
                        $notiDes->type = "Descargas";
                        $notiDes->status = "pending";
                        $notiDes->typeId1 = $des->id;
                        $notiDes->typeId2 = $des->folderId;
                        $notiDes->save();
                    }

                }
                if ($subidasExists == true) {
                    $subs = \App\Folder::where('status', 'Habilitado')->where('studentType', $student->type)->where('type', 'Subidas')->get();
                    foreach ($subs as $sub) {
                        $notiSub = new \App\Notification;
                        $notiSub->studentId = $student->id;
                        $notiSub->type = "Subidas";
                        $notiSub->status = "pending";
                        $notiSub->typeId2 = $sub->id;
                        $notiSub->save();
                    }

                }
                if ($topicExists == true) {
                    if ($audioExists == true) {
                        $auds = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->get();
                        foreach ($auds as $aud) {
                            $notiA = new \App\Notification;
                            $notiA->studentId = $student->id;
                            $notiA->type = "audio";
                            $notiA->status = "pending";
                            $notiA->typeId1 = $aud->id;
                            $notiA->typeId2 = $aud->topicId;
                            $notiA->save();
                        }

                    }
                    if ($videoExists == true) {
                        $vids = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->get();
                        foreach ($vids as $vid) {
                            $notiV = new \App\Notification;
                            $notiV->studentId = $student->id;
                            $notiV->type = "video";
                            $notiV->status = "pending";
                            $notiV->typeId1 = $vid->id;
                            $notiV->typeId2 = $vid->topicId;
                            $notiV->save();

                        }
                    }
                }
                if ($folderExists == true) {
                    if ($surveyExists == true) {
                        $surs = \App\Survey::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $folderArray)->get();
                        foreach ($surs as $sur) {
                            $notiSur = new \App\Notification;
                            $notiSur->studentId = $student->id;
                            $notiSur->type = "surveys";
                            $notiSur->status = "pending";
                            $notiSur->typeId1 = $sur->id;
                            $notiSur->save();
                        }

                    }
                }

                return response()->json(['status' => 'Sucessfull', 'data' => $student]);
            }
            if ($exists == true) {
                $user = \App\User::where('email', $email)
                    ->where('telephone', $telephone)->first();
                if ($user->field1x == "Bloquear") {
                    $message = "El administrador bloqueó su cuenta debido a tarifas pendientes";
                    return response()->json(['status' => 'Unsucessfull', 'message' => $message]);
                }
                if ($user->type == "Alumno") {
                    $message = "Inicie sesión como alumno con nombre de usuario y contraseña";
                    return response()->json(['status' => 'Unsucessfull', 'message' => $message]);
                }
                User::where('id',$user->id)->update(['isLogin' => 'yes']);
                return response()->json(['status' => 'Sucessfull', 'data' => $user]);
            }
        }
    }

    public function logoutStudent(Request $request){
        $studentId = $request->json('studentId');
        if(isset($studentId) && empty($studentId) === false){
            $exists = \App\User::where('id', $studentId)->exists();
            if($exists = "true"){
                User::where('id',$studentId)->update(['isLogin' => 'no']);
                return response()->json(['status' => 'Sucessfull', 'message' => 'Cierre de sesión de usuario', 'data' => array()]);
            }
        }
        return response()->json(['status' => 'Unsucessfull', 'message' => 'No se encontró el registro de usuario', 'data' => array()]);
    }

    public function registerStudent(Request $request)
    {
        if (empty($request->json('userId'))) {
            $exists33 = \App\User::where('email', $request->json('electronico'))->exists();
            if ($exists33 == true) {
                $message = "Has introducido un <strong>teléfono</strong> o <strong>correo electrónico</strong> que <strong>ya consta</strong> en nuestra base de datos. Por favor, <strong>inicia sesión</strong> para poder acceder a la ventana de pedidos.";
                return response()->json(['status' => 'error', 'message' => $message]);
            }
            $exists34 = \App\User::where('telephone', $request->json('telefono'))->exists();
            if ($exists34 == true) {
                //$message = "Teléfono móvil ya apartadas";
                $message = "Has introducido un <strong>teléfono</strong> o <strong>correo electrónico</strong> que <strong>ya consta</strong> en nuestra base de datos. Por favor, <strong>inicia sesión</strong> para poder acceder a la ventana de pedidos.";
                return response()->json(['status' => 'error', 'message' => $message]);
            }

            $messages = [
                'baremo.required' => "El <strong>baremo</strong> son los <strong>son los</strong> que se <strong>suman</strong> a la <strong>nota</strong> de la oposición por la posesión de <strong>títulos</strong> u otros <strong>méritos</strong>. Debe escribirse un <strong>número entero</strong> o <strong>decimal</strong> con un <strong>punto</strong>.",
                'baremo.numeric' => "El <strong>baremo</strong> son los <strong>son los</strong> que se <strong>suman</strong> a la <strong>nota</strong> de la oposición por la posesión de <strong>títulos</strong> u otros <strong>méritos</strong>. Debe escribirse un <strong>número entero</strong> o <strong>decimal</strong> con un <strong>punto</strong>."
            ];
            $validator = Validator::make($request->all(), [
                'baremo' => 'required|numeric|between:0,99.9999'
            ], $messages);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message', $validator->errors()]);
            }

            $student = new \App\User;
            $student->email = $request->json('electronico');
            $student->telephone = $request->json('telefono');
            $student->type = "Prueba";
            $student->emailSubscription = null;
            $ex = \App\User::exists();
            if ($ex == true) {
                $max = \App\User::where('role', 'student')->where('type', 'Prueba')->max('scale');
                if ($max == null) {
                    $student->scale = 0;
                }
                if ($max != null) {
                    $student->scale = $max + 1;
                }
            }
            if ($ex == false) {
                $student->scale = 0;
            }
            $student->role = "student";
            $student->save();

            $news = \App\Alert::where('studentType', $student->type)->get();
            foreach ($news as $key => $value) {
                $ar = new \App\AlertRecord;
                $ar->studentId = $student->id;
                $ar->news = $value->news;
                $ar->newsId = $value->id;
                $ar->status = "unseen";
                $ar->save();
            }
            $efe = \App\Folder::where('studentType', $student->type)->where('type', 'exams')->exists();
            $rfe = \App\Folder::where('studentType', $student->type)->where('type', 'reviews')->exists();
            $pfe = \App\Folder::where('studentType', $student->type)->where('type', 'personalities')->exists();
            if ($efe == true) {
                $ef = \App\Folder::where('studentType', $student->type)->where('type', 'exams')->get();
                $efArray = array();
                foreach ($ef as $efv) {
                    array_push($efArray, $efv->id);
                }
                $examExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $efArray)->exists();


                if ($examExists == true) {
                    $exams = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $efArray)->get();
                    foreach ($exams as $exam) {
                        $notiE = new \App\Notification;
                        $notiE->studentId = $student->id;
                        $notiE->type = "exams";
                        $notiE->status = "pending";
                        $notiE->typeId1 = $exam->id;

                        $notiE->save();
                    }
                }
            }
            if ($rfe == true) {
                $rf = \App\Folder::where('studentType', $student->type)->where('type', 'reviews')->get();
                $rfArray = array();
                foreach ($rf as $rfv) {
                    array_push($rfArray, $rfv->id);
                }
                $reviewExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $rfArray)->exists();
                if ($reviewExists == true) {
                    $reviews = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $rfArray)->get();
                    foreach ($reviews as $review) {
                        $notiE = new \App\Notification;
                        $notiE->studentId = $student->id;
                        $notiE->type = "reviews";
                        $notiE->status = "pending";
                        $notiE->typeId1 = $review->id;

                        $notiE->save();
                    }

                }
            }
            if ($pfe == true) {
                $pf = \App\Folder::where('studentType', $student->type)->where('type', 'personalities')->get();
                $pfArray = array();
                foreach ($pf as $pfv) {
                    array_push($pfArray, $pfv->id);
                }
                $personalityExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $pfArray)->exists();
                if ($personalityExists == true) {
                    $personalities = \App\Exam::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $pfArray)->get();
                    foreach ($personalities as $personality) {
                        $notiE = new \App\Notification;
                        $notiE->studentId = $student->id;
                        $notiE->type = "personalities";
                        $notiE->status = "pending";
                        $notiE->typeId1 = $personality->id;

                        $notiE->save();
                    }

                }
            }
            $descargasExists = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $student->type)->where('option', 'Descargas')->exists();
            $subidasExists = \App\Folder::where('status', 'Habilitado')->where('studentType', $student->type)->where('type', 'Subidas')->exists();
            $topicExists = \App\Topic::where('studentType', $student->type)->exists();
            if ($topicExists == true) {
                $topics = \App\Topic::where('studentType', $student->type)->get();
                $topicArray = array();
                foreach ($topics as $topic) {
                    array_push($topicArray, $topic->id);
                }
                if (!empty($topicArray)) {
                    $audioExists = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->exists();
                    $videoExists = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->exists();
                }
            }
            $folderExists = \App\Folder::where('studentType', $student->type)->where('type', 'surveys')->exists();
            if ($folderExists == true) {
                $folders = \App\Folder::where('studentType', $student->type)->where('type', 'surveys')->get();
                $folderArray = array();
                foreach ($folders as $folder) {
                    array_push($folderArray, $folder->id);
                }
                if (!empty($folderArray)) {
                    $surveyExists = \App\Survey::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $folderArray)->exists();
                }
            }

            if ($descargasExists == true) {
                $dess = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $student->type)->where('option', 'Descargas')->get();
                foreach ($dess as $key => $des) {
                    $notiDes = new \App\Notification;
                    $notiDes->studentId = $student->id;
                    $notiDes->type = "Descargas";
                    $notiDes->status = "pending";
                    $notiDes->typeId1 = $des->id;
                    $notiDes->typeId2 = $des->folderId;
                    $notiDes->save();
                }

            }
            if ($subidasExists == true) {
                $subs = \App\Folder::where('status', 'Habilitado')->where('studentType', $student->type)->where('type', 'Subidas')->get();
                foreach ($subs as $sub) {
                    $notiSub = new \App\Notification;
                    $notiSub->studentId = $student->id;
                    $notiSub->type = "Subidas";
                    $notiSub->status = "pending";
                    $notiSub->typeId2 = $sub->id;
                    $notiSub->save();
                }

            }
            if ($topicExists == true) {
                if ($audioExists == true) {
                    $auds = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->get();
                    foreach ($auds as $aud) {
                        $notiA = new \App\Notification;
                        $notiA->studentId = $student->id;
                        $notiA->type = "audio";
                        $notiA->status = "pending";
                        $notiA->typeId1 = $aud->id;
                        $notiA->typeId2 = $aud->folderId;
                        $notiA->save();
                    }

                }
                if ($videoExists == true) {
                    $vids = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->get();
                    foreach ($vids as $vid) {
                        $notiV = new \App\Notification;
                        $notiV->studentId = $student->id;
                        $notiV->type = "video";
                        $notiV->status = "pending";
                        $notiV->typeId1 = $vid->id;
                        $notiV->typeId2 = $vid->folderId;
                        $notiV->save();

                    }
                }
            }
            if ($folderExists == true) {
                if ($surveyExists == true) {
                    $surs = \App\Survey::where('status', 'Habilitado')->where('studentType', $student->type)->whereIn('folderId', $folderArray)->get();
                    foreach ($surs as $sur) {
                        $notiSur = new \App\Notification;
                        $notiSur->studentId = $student->id;
                        $notiSur->type = "surveys";
                        $notiSur->status = "pending";
                        $notiSur->typeId1 = $sur->id;
                        $notiSur->save();
                    }

                }
            }
            $register = new \App\Register;
            $register->usuario = $request->json('usuario');
            $register->contrasena = $request->json('contrasena');
            $register->dni = $request->json('dni');
            $register->domi = $request->json('domi');
            $register->electronico = $request->json('electronico');
            $register->localidad = $request->json('localidad');
            $register->telefono = $request->json('telefono');
            $register->postal = $request->json('postal');
            $register->surname = $request->json('surname');
            $register->baremo = $request->json('baremo');
            $register->userId = $student->id;
            $register->save();
            $student->baremo = $register->baremo;
            $student->password = $register->contrasena;
            $student->save();

            $reason = $request->json('reason');

            return response()->json(['status' => 'success', 'message' => "Registrado correctamente"]);
            /*if (!empty($reason)) {
                $userId = $student->id;

                if ($reason == "books") {
                    return view('payments/books', compact('userId'));
                }
                if ($reason == "alumno") {
                    return view('payments/alumno', compact('userId'));
                }
                if ($reason == "alumnoConvocado") {
                    return view('payments/alumnoConvocado', compact('userId'));
                }
            }
            if (empty($reason)) {
                $userId = $student->id;
                $message = "Registrado correctamente";
                return view('neoestudio/comienza', compact('message', 'userId'));
            }*/


        }
    }

    public function user(Request $request){
        $userId=$request->json('id');

        $ue=\App\User::where('id',$userId)->exists();
        if($ue==false){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found', 'is_deleted' => true]);
        }
        $u=\App\User::find($userId);
        if($u->field1x=="Bloquear"){
            return response()->json(['status'=>'Unsuccessfull','message'=>'User not found', 'is_block' => true]);
        }
        $user=\App\User::find($userId);

        $package = array();
        $hasPackage = \App\Pay::where('userId', $user->id)->where('status','paid')->where('type','alumno')->count();
        if($hasPackage > 0){
            $tenure = ['annual' => 'Anual', 'fractional' => 'Fraccionado', 'monthly' => 'Mensual'];
            $pay = \App\Pay::where('userId', $user->id)->where('status','paid')->where('type','alumno')->orderBy('id','desc')->first();
            $package = \App\PayPackage::where('pay_id', $pay->id)->with('package')->first();
        }

        return response()->json(['status' => 'Successfull', 'data' => $user, 'package' => $package]);
    }
}
