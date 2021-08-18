<?php

namespace App\Http\Controllers;

use App\PackagePrice;
use App\PackagePriceDescription;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use App\Product;
use App\ServicePackage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use PDF;
use Illuminate\Support\Facades\URL;
use DB;

class HomeController extends Controller
{
    public function subscription()
    {
        return view('subscription');
    }

    public function postSubscription(Request $request)
    {
        $payData = Session::get('payData');
        if (isset($payData) && empty($payData) === false && count($payData) > 0) {
            $this->paymentCallBackSuccess($payData);
            return redirect()->intended('paymentPays/'.$payData['payId']);
        }
        /*$user = Session::get('userData');
        $data = json_decode($user, true);
        return response()->json(['msg' => $data['name'] . ' Successfully subscribed']);
        exit;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($request->password);
        $user->save();
        $user->newSubscription('main', $request->subscription)->create($request->token);
        if ($user->subscribed('main')) {
            return response()->json(['msg' => 'Successfully subscribed']);
        }
        return response()->json(['msg' => 'Oops there is something error with your input']);*/

    }

    public function manualCheck()
    {
        $payData = array('userId' => '3049', 'amount' => '429.80', 'type' => 'books', 'payId' => '3336');
        if (isset($payData) && empty($payData) === false && count($payData) > 0) {
            $this->paymentCallBackSuccess($payData);
        }
        return redirect()->intended('paymentPays/'.$payData['payId']);

    }

    public function paymentCallBackSuccess($payData = array())
    {
        if (isset($payData) && empty($payData) === false && count($payData) > 0) {
            $userId = $payData['userId'];
            $amount = $payData['amount'];
            $type = $payData['type'];
            $payId = $payData['payId'];
            $user = \App\User::find($userId);
            $order = array();
            if ($type == "alumno") {
                $order = DB::table('subscriptions')->where('user_id', $userId)->orderBy('id', 'desc')->first();
            }
            if (!isset($payId) || empty($payId) === true) {
                $pay = new \App\Pay;
                $pay->userId = $userId;
                $pay->amount = $amount;
                $pay->type = $type;
                $pay->time = Carbon::now()->toDateTimeString();
                $pay->submitTime = Carbon::now();
                $pay->status = "paid";
                $pay->save();
            }
            if (isset($payId) && empty($payId) === false) {
                $pay = \App\Pay::find($payId);
                $pay->status = "paid";
                $pay->time = Carbon::now()->toDateTimeString();
                $pay->submitTime = Carbon::now();
                //$pay->authCode = $rr->Ds_AuthorisationCode;
                if(isset($order) && isset($order->id) && empty($order->id) === false){
                    $pay->orderNumber = $order->id;
                }
                $pay->save();
            }

            if ($type == "alumno") {
                //manual italian
                $paysIt = \App\Pay::where('process', 'auto')->where('userId', $userId)->where('status', 'deleted')->exists();
                if ($paysIt == true) {
                    $paysiit = \App\Pay::where('userId', $userId)->where('status', 'deleted')->where('process', 'auto')->get();
                    foreach ($paysiit as $valueiit) {
                        $valueiit->status = "pending";
                        $valueiit->save();
                    }
                }
                //end manual

                //recuuring
                if ($pay->paymentType == "recurring" && $paysIt == false && $user->recur != "yes") {
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(1);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(2);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(3);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(4);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(5);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(6);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(7);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(8);
                    $pay2->process = "auto";
                    $pay2->save();
                    $pay2 = new \App\Pay;
                    $pay2->amount = $amount;
                    $pay2->userId = $userId;
                    $pay2->type = "alumno";
                    $pay2->status = "pending";
                    $pay2->paymentType = "recurring";
                    $pay2->scheduleTime = Carbon::now()->addMonth(9);
                    $pay2->process = "auto";
                    $pay2->save();
                    $user->recur = "yes";
                    $user->save();
                }
                //end recurring

                if ($user->type == "Prueba") {
                    $user->type = "Alumno";
                    $user->studentCode = Str::random(6);
                    $user->save();
                    $preNots = \App\Notification::where('studentId', $user->id)->get();
                    if (!empty($preNots)) {
                        foreach ($preNots as $key => $value) {
                            $value->delete();
                        }
                    }
                    $preA = \App\AlertRecord::where('studentId', $user->id)->get();
                    if (!empty($preA)) {
                        foreach ($preA as $key => $value) {
                            $value->delete();
                        }
                    }
                    $alerts = \App\Alert::where('studentType', 'Alumno')->get();
                    if (!empty($alerts)) {
                        $aar = array();
                        foreach ($alerts as $key => $value) {
                            array_push($aar, $value->id);
                        }
                        $als = \App\AlertRecord::where('studentId', $user->id)->whereIn('newsId', $aar)->get();
                        if (!empty($als)) {
                            foreach ($als as $k => $v) {
                                $v->delete();
                            }
                        }
                    }
                    $news = \App\Alert::where('studentType', $user->type)->get();
                    if (!empty($news)) {
                        foreach ($news as $key => $value) {
                            $ar = new \App\AlertRecord;
                            $ar->studentId = $user->id;
                            $ar->news = $value->news;
                            $ar->newsId = $value->id;
                            $ar->status = "unseen";
                            $ar->save();
                        }
                    }
                    $efe = \App\Folder::where('studentType', $user->type)->where('type', 'exams')->exists();
                    $rfe = \App\Folder::where('studentType', $user->type)->where('type', 'reviews')->exists();
                    $pfe = \App\Folder::where('studentType', $user->type)->where('type', 'personalities')->exists();
                    if ($efe == true) {
                        $ef = \App\Folder::where('studentType', $user->type)->where('type', 'exams')->get();
                        $efArray = array();
                        foreach ($ef as $efv) {
                            array_push($efArray, $efv->id);
                        }
                        $examExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $efArray)->exists();


                        if ($examExists == true) {
                            $exams = \App\Exam::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $efArray)->get();
                            foreach ($exams as $exam) {
                                $notiE = new \App\Notification;
                                $notiE->studentId = $user->id;
                                $notiE->type = "exams";
                                $notiE->status = "pending";
                                $notiE->typeId1 = $exam->id;

                                $notiE->save();
                            }
                        }
                    }
                    if ($rfe == true) {
                        $rf = \App\Folder::where('studentType', $user->type)->where('type', 'reviews')->get();
                        $rfArray = array();
                        foreach ($rf as $rfv) {
                            array_push($rfArray, $rfv->id);
                        }
                        $reviewExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $rfArray)->exists();
                        if ($reviewExists == true) {
                            $reviews = \App\Exam::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $rfArray)->get();
                            foreach ($reviews as $review) {
                                $notiE = new \App\Notification;
                                $notiE->studentId = $user->id;
                                $notiE->type = "reviews";
                                $notiE->status = "pending";
                                $notiE->typeId1 = $review->id;

                                $notiE->save();
                            }

                        }
                    }
                    if ($pfe == true) {
                        $pf = \App\Folder::where('studentType', $user->type)->where('type', 'personalities')->get();
                        $pfArray = array();
                        foreach ($pf as $pfv) {
                            array_push($pfArray, $pfv->id);
                        }
                        $personalityExists = \App\Exam::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $pfArray)->exists();
                        if ($personalityExists == true) {
                            $personalities = \App\Exam::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $pfArray)->get();
                            foreach ($personalities as $personality) {
                                $notiE = new \App\Notification;
                                $notiE->studentId = $user->id;
                                $notiE->type = "personalities";
                                $notiE->status = "pending";
                                $notiE->typeId1 = $personality->id;

                                $notiE->save();
                            }

                        }
                    }
                    $descargasExists = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $user->type)->where('option', 'Descargas')->exists();
                    $subidasExists = \App\Folder::where('status', 'Habilitado')->where('studentType', $user->type)->where('type', 'Subidas')->exists();
                    $topicExists = \App\Topic::where('studentType', $user->type)->exists();
                    if ($topicExists == true) {
                        $topics = \App\Topic::where('studentType', $user->type)->get();
                        $topicArray = array();
                        foreach ($topics as $topic) {
                            array_push($topicArray, $topic->id);
                        }
                        if (!empty($topicArray)) {
                            $audioExists = \App\Material::where('status', 'Habilitado')->where('type', 'audio')->whereIn('topicId', $topicArray)->exists();
                            $videoExists = \App\Material::where('status', 'Habilitado')->where('type', 'video')->whereIn('topicId', $topicArray)->exists();
                        }
                    }
                    $folderExists = \App\Folder::where('studentType', $user->type)->where('type', 'surveys')->exists();
                    if ($folderExists == true) {
                        $folders = \App\Folder::where('studentType', $user->type)->where('type', 'surveys')->get();
                        $folderArray = array();
                        foreach ($folders as $folder) {
                            array_push($folderArray, $folder->id);
                        }
                        if (!empty($folderArray)) {
                            $surveyExists = \App\Survey::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $folderArray)->exists();
                        }
                    }

                    if ($descargasExists == true) {
                        $dess = \App\DownloadUpload::where('status', 'Habilitado')->where('studentType', $user->type)->where('option', 'Descargas')->get();
                        foreach ($dess as $key => $des) {
                            $notiDes = new \App\Notification;
                            $notiDes->studentId = $user->id;
                            $notiDes->type = "Descargas";
                            $notiDes->status = "pending";
                            $notiDes->typeId1 = $des->id;
                            $notiDes->typeId2 = $des->folderId;
                            $notiDes->save();
                        }

                    }
                    if ($subidasExists == true) {
                        $subs = \App\Folder::where('status', 'Habilitado')->where('studentType', $user->type)->where('type', 'Subidas')->get();
                        foreach ($subs as $sub) {
                            $notiSub = new \App\Notification;
                            $notiSub->studentId = $user->id;
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
                                $notiA->studentId = $user->id;
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
                                $notiV->studentId = $user->id;
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
                            $surs = \App\Survey::where('status', 'Habilitado')->where('studentType', $user->type)->whereIn('folderId', $folderArray)->get();
                            foreach ($surs as $sur) {
                                $notiSur = new \App\Notification;
                                $notiSur->studentId = $user->id;
                                $notiSur->type = "surveys";
                                $notiSur->status = "pending";
                                $notiSur->typeId1 = $sur->id;
                                $notiSur->save();
                            }

                        }
                    }

                }
            }
            $email = $user->email;
            $studentCode = $user->studentCode;
            $reg = \App\Register::where('userId', $user->id)->first();
            //edit
            $nameE = $reg->surname;
            $cpE = $reg->postal;
            $telephoneE = $reg->telefono;
            $addressE = $reg->domi;
            $townE = $reg->localidad;
            //end edit
            $password = $reg->contrasena;
            $user->password = $password;
            $user->save();
            if ($pay->type != "books") {
                $ta = 21 / 100 * $pay->amount;
                $amount2 = number_format($pay->amount - $ta, 2);
                $amount2a = explode(".", $amount2);
                $amount2 = $amount2a[0] . "," . $amount2a[1];
                $tax = number_format($ta, 2);
                $ta = explode(".", $tax);
                $tax = $ta[0] . "," . $ta[1];
            }
            if ($pay->type == "books") {
                $ta = 4 / 100 * $pay->amount;
                $amount2 = number_format($pay->amount - $ta, 2);
                $amount2a = explode(".", $amount2);
                $amount2 = $amount2a[0] . "," . $amount2a[1];
                $tax = number_format($ta, 2);
                $ta = explode(".", $tax);
                $tax = $ta[0] . "," . $ta[1];
            }
            $total = $pay->amount;
            $randomN = rand(10000, 99999);
            $pay->invoiceN = $randomN;
            $pay->save();
            $studentUsername = $reg->usuario;
            $date = Carbon::parse($pay->time)->format('d/m/Y');
            if ($pay->type == "books") {
                $paid_products = \App\PayProduct::where('pay_id',$payId)->with('product')->get();
                $pdf = PDF::loadView('tsmOld2', ['paid_products' => $paid_products, 'randomN' => $randomN, 'total' => $total, 'amount2' => $amount2, 'tax' => $tax, 'date' => $date, 'studentCode' => $studentCode, 'password' => $password, 'type' => $pay->type, 'amount' => $pay->amount, 'time' => $pay->time, 'nameE' => $nameE, 'cpE' => $cpE, 'telephoneE' => $telephoneE, 'addressE' => $addressE, 'townE' => $townE]);
            }

            if ($pay->type != "books") {
                $tenure = ['annual' => 'Anual', 'fractional' => 'Fraccionado', 'monthly' => 'Mensual'];
                $paid_package = \App\PayPackage::where('pay_id', $payId)->with('package')->first();
                $package_price = PackagePrice::where('package_id', $paid_package->package_id)->where('price_type', $paid_package->payment_method)->first();
                $package_description = array();
                $packageDesc = PackagePriceDescription::where('package_price_id',$package_price->id)->count();
                if($packageDesc > 0){
                    $package_description = PackagePriceDescription::where('package_price_id',$package_price->id)->select(DB::raw($paid_package->payment_method. ' AS description'))->first();
                }
                $pdf = PDF::loadView
                ('tsmOld', ['paid_package' => $paid_package, 'package_description' => $package_description, 'tenure' => $tenure, 'randomN' => $randomN, 'total' => $total, 'amount2' => $amount2, 'tax' => $tax, 'date' => $date, 'studentCode' => $studentCode, 'password' => $password, 'type' => $pay->type, 'amount' => $pay->amount, 'time' => $pay->time, 'nameE' => $nameE, 'cpE' => $cpE, 'telephoneE' => $telephoneE, 'addressE' => $addressE, 'townE' => $townE]);
            }
            $ran = Str::random(6);
            $fileName = "$ran-neoestudioinvoice.pdf";
            $pdf->save("invoices/$fileName");
            $re = public_path();
            //$re = str_replace("/public", "", $pp);
            $path = "$re/invoices/$fileName";

            if(empty($email) === true || $email == "skaka787@gmail.com"){
                $email = 'skaka786@gmail.com';
            }
            if ($pay->type == "books") {
                Mail::send('mail2', [], function ($message) use ($path, $email) {
                    $message->to($email)->cc(['info@neoestudioguardiacivil.es'])->subject
                    ('Factura de pago');
                    $message->from('info@neoestudioguardiacivil.es', 'Neoestudio');

                    $message->attach($path);
                });
            }
            if ($pay->type != "books") {
                Mail::send('mail', ['studentUsername' => $studentUsername, 'studentCode' => $studentCode, 'password' => $password], function ($message) use ($path, $email) {
                    $message->to($email)->cc(['info@neoestudioguardiacivil.es'])->subject
                    ('Factura de pago');
                    $message->from('info@neoestudioguardiacivil.es', 'Neoestudio');

                    $message->attach($path);
                });
            }
        }
    }

    public function paymentPays($payId)
    {
        $pay = \App\Pay::where('id', $payId)->first();
        $userId = $pay->userId;
        $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
        $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
        $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
        $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();
        if ($pay->type != "books") {
            $message = "Pago exitoso. Correo de confirmación enviado
            a su dirección de correo electrónico con código de estudiante y contraseña";
        }
        if ($pay->type == "books") {
            $message = "Pago exitoso. Correo de confirmación enviado
            a su dirección de correo electrónico";
        }
        return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists', 'message', 'pay'));

    }
}