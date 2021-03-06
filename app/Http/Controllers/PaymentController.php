<?php

namespace App\Http\Controllers;

use App\Product;
use App\ServicePackage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use PDF;
use Illuminate\Support\Facades\URL;
use DB;
use Illuminate\Support\Facades\Session;

class RedsysAPI
{

    /******  Array de DatosEntrada ******/
    var $vars_pay = array();

    /******  Set parameter ******/
    function setParameter($key, $value)
    {
        $this->vars_pay[$key] = $value;
    }

    /******  Get parameter ******/
    function getParameter($key)
    {
        return $this->vars_pay[$key];
    }


    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////                    FUNCIONES AUXILIARES:                             ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////


    /******  3DES Function  ******/
    function encrypt_3DES($message, $key)
    {
        // Se cifra
        $l = ceil(strlen($message) / 8) * 8;
        return substr(openssl_encrypt($message . str_repeat("\0", $l - strlen($message)), 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, "\0\0\0\0\0\0\0\0"), 0, $l);

    }

    /******  Base64 Functions  ******/
    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    function encodeBase64($data)
    {
        $data = base64_encode($data);
        return $data;
    }

    function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    function decodeBase64($data)
    {
        $data = base64_decode($data);
        return $data;
    }

    /******  MAC Function ******/
    function mac256($ent, $key)
    {
        $res = hash_hmac('sha256', $ent, $key, true);//(PHP 5 >= 5.1.2)
        return $res;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////       FUNCIONES PARA LA GENERACI??N DEL FORMULARIO DE PAGO:           ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /******  Obtener N??mero de pedido ******/
    function getOrder()
    {
        $numPedido = "";
        if (empty($this->vars_pay['DS_MERCHANT_ORDER'])) {
            $numPedido = $this->vars_pay['Ds_Merchant_Order'];
        } else {
            $numPedido = $this->vars_pay['DS_MERCHANT_ORDER'];
        }
        return $numPedido;
    }

    /******  Convertir Array en Objeto JSON ******/
    function arrayToJson()
    {
        $json = json_encode($this->vars_pay); //(PHP 5 >= 5.2.0)
        return $json;
    }

    function createMerchantParameters()
    {
        // Se transforma el array de datos en un objeto Json
        $json = $this->arrayToJson();
        // Se codifican los datos Base64
        return $this->encodeBase64($json);
    }

    function createMerchantSignature($key)
    {
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se genera el par??metro Ds_MerchantParameters
        $ent = $this->createMerchantParameters();
        // Se diversifica la clave con el N??mero de Pedido
        $key = $this->encrypt_3DES($this->getOrder(), $key);
        // MAC256 del par??metro Ds_MerchantParameters
        $res = $this->mac256($ent, $key);
        // Se codifican los datos Base64
        return $this->encodeBase64($res);
    }



    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////// FUNCIONES PARA LA RECEPCI??N DE DATOS DE PAGO (Notif, URLOK y URLKO): ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /******  Obtener N??mero de pedido ******/
    function getOrderNotif()
    {
        $numPedido = "";
        if (empty($this->vars_pay['Ds_Order'])) {
            $numPedido = $this->vars_pay['DS_ORDER'];
        } else {
            $numPedido = $this->vars_pay['Ds_Order'];
        }
        return $numPedido;
    }

    function getOrderNotifSOAP($datos)
    {
        $posPedidoIni = strrpos($datos, "<Ds_Order>");
        $tamPedidoIni = strlen("<Ds_Order>");
        $posPedidoFin = strrpos($datos, "</Ds_Order>");
        return substr($datos, $posPedidoIni + $tamPedidoIni, $posPedidoFin - ($posPedidoIni + $tamPedidoIni));
    }

    function getRequestNotifSOAP($datos)
    {
        $posReqIni = strrpos($datos, "<Request");
        $posReqFin = strrpos($datos, "</Request>");
        $tamReqFin = strlen("</Request>");
        return substr($datos, $posReqIni, ($posReqFin + $tamReqFin) - $posReqIni);
    }

    function getResponseNotifSOAP($datos)
    {
        $posReqIni = strrpos($datos, "<Response");
        $posReqFin = strrpos($datos, "</Response>");
        $tamReqFin = strlen("</Response>");
        return substr($datos, $posReqIni, ($posReqFin + $tamReqFin) - $posReqIni);
    }

    /******  Convertir String en Array ******/
    function stringToArray($datosDecod)
    {
        $this->vars_pay = json_decode($datosDecod, true); //(PHP 5 >= 5.2.0)
    }

    function decodeMerchantParameters($datos)
    {
        // Se decodifican los datos Base64
        $decodec = $this->base64_url_decode($datos);
        // Los datos decodificados se pasan al array de datos
        $this->stringToArray($decodec);
        return $decodec;
    }

    function createMerchantSignatureNotif($key, $datos)
    {
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se decodifican los datos Base64
        $decodec = $this->base64_url_decode($datos);
        // Los datos decodificados se pasan al array de datos
        $this->stringToArray($decodec);
        // Se diversifica la clave con el N??mero de Pedido
        $key = $this->encrypt_3DES($this->getOrderNotif(), $key);
        // MAC256 del par??metro Ds_Parameters que env??a Redsys
        $res = $this->mac256($datos, $key);
        // Se codifican los datos Base64
        return $this->base64_url_encode($res);
    }

    /******  Notificaciones SOAP ENTRADA ******/
    function createMerchantSignatureNotifSOAPRequest($key, $datos)
    {
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se obtienen los datos del Request
        $datos = $this->getRequestNotifSOAP($datos);
        // Se diversifica la clave con el N??mero de Pedido
        $key = $this->encrypt_3DES($this->getOrderNotifSOAP($datos), $key);
        // MAC256 del par??metro Ds_Parameters que env??a Redsys
        $res = $this->mac256($datos, $key);
        // Se codifican los datos Base64
        return $this->encodeBase64($res);
    }

    /******  Notificaciones SOAP SALIDA ******/
    function createMerchantSignatureNotifSOAPResponse($key, $datos, $numPedido)
    {
        // Se decodifica la clave Base64
        $key = $this->decodeBase64($key);
        // Se obtienen los datos del Request
        $datos = $this->getResponseNotifSOAP($datos);
        // Se diversifica la clave con el N??mero de Pedido
        $key = $this->encrypt_3DES($numPedido, $key);
        // MAC256 del par??metro Ds_Parameters que env??a Redsys
        $res = $this->mac256($datos, $key);
        // Se codifican los datos Base64
        return $this->encodeBase64($res);
    }
}


class PaymentController extends Controller
{

    function getData(Request $req)
    {
//echo $request->get('name');
        return $req->input('name');

//  return $request->get('name'),
        //return view('paymentfinal', compact('name'));
    }


    public function index($userId, $reason)
    {

        if ($userId != 'nul') {
            $exists = \App\Register::where('userId', $userId)->exists();
            if ($exists == true) {
                $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
                $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
                $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
                $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();
                return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists'));
            }
            if ($exists == false) {
                $user = \App\User::find($userId);
                $email = $user->email;
                $telephone = $user->telephone;
                return view('neoestudio/registerate', compact('userId', 'reason', 'email', 'telephone'));
            }
        }
        if ($userId == 'nul') {

            return view('registers/login', compact('reason'));
        }
        //return view('payments/payment');
    }

    public function indexH($userId)
    {
        $user_data = array();
        if (empty(Session::get('userData')) === false) {
            $user_data = Session::get('userData');
        }
        if (!empty($userId)) {
            $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
            $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
            $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
            $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();
            return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists', 'user_data'));
        }
        //return view('payments/payment');
    }

    public function paymentCallBackSuccess(Request $request, $userId, $amount, $type, $payId)
    {


        $user = \App\User::find($userId);
        if ($payId == "nul") {

            $pay = new \App\Pay;
            $pay->userId = $userId;
            $pay->amount = $amount;
            $pay->type = $type;
            $pay->time = Carbon::now()->toDateTimeString();
            $pay->submitTime = Carbon::now();
            $pay->status = "paid";

            $pay->save();
            // Object is created
            $miObj = new RedsysAPI;
            $decodec = $miObj->decodeMerchantParameters($request->get("Ds_MerchantParameters"));
            $rr = json_decode($decodec);
            $identifier = new \App\Identifier;
            $identifier->identifier = $rr->Ds_Merchant_Identifier;
            $identifier->status = "pending";
            $identifier->userId = $userId;
            $identifier->save();

        }
        if ($payId != "nul") {
            $miObj = new RedsysAPI;
            $decodec = $miObj->decodeMerchantParameters($request->get("Ds_MerchantParameters"));
            $rr = json_decode($decodec);
            $pay = \App\Pay::find($payId);
            $pay->status = "paid";
            $pay->time = Carbon::now()->toDateTimeString();
            $pay->submitTime = Carbon::now();
            $pay->authCode = $rr->Ds_AuthorisationCode;
            $pay->orderNumber = $rr->Ds_Order;

            $pay->save();
        }

        if ($type == "alumno") {
            // Object is created
            $miObj = new RedsysAPI;
            $decodec = $miObj->decodeMerchantParameters($request->get("Ds_MerchantParameters"));
            $rr = json_decode($decodec);
            $identifier = new \App\Identifier;
            $identifier->identifier = $rr->Ds_Merchant_Identifier;
            $identifier->status = "pending";
            $identifier->userId = $userId;
            $identifier->save();
            //end identifier

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
        $date = Carbon::parse($pay->time)->format('d/m/Y');
        if ($pay->type == "books") {
            $pdf = PDF::loadView('tsmOld2', ['randomN' => $randomN, 'total' => $total, 'amount2' => $amount2, 'tax' => $tax, 'date' => $date, 'studentCode' => $studentCode, 'password' => $password, 'type' => $pay->type, 'amount' => $pay->amount, 'time' => $pay->time, 'nameE' => $nameE, 'cpE' => $cpE, 'telephoneE' => $telephoneE, 'addressE' => $addressE, 'townE' => $townE]);
        }
        if ($pay->type != "books") {
            $pdf = PDF::loadView('tsmOld', ['randomN' => $randomN, 'total' => $total, 'amount2' => $amount2, 'tax' => $tax, 'date' => $date, 'studentCode' => $studentCode, 'password' => $password, 'type' => $pay->type, 'amount' => $pay->amount, 'time' => $pay->time, 'nameE' => $nameE, 'cpE' => $cpE, 'telephoneE' => $telephoneE, 'addressE' => $addressE, 'townE' => $townE]);
        }
        $ran = Str::random(6);
        $fileName = "$ran-neoestudioinvoice.pdf";
        $pdf->save("invoices/$fileName");
        $pp = public_path();
        $re = str_replace("/public", "", $pp);
        $path = "$re/invoices/$fileName";
        if ($pay->type == "books") {
            Mail::send('mail2', [], function ($message) use ($path, $email) {
                $message->to($email)->cc(['info@neoestudioguardiacivil.es', 'david@qode.pro'])->subject
                ('Factura de pago');
                $message->from('info@neoestudioguardiacivil.es', 'Neoestudio');

                $message->attach($path);
            });
        }
        if ($pay->type != "books") {
            Mail::send('mail', ['studentCode' => $studentCode, 'password' => $password], function ($message) use ($path, $email) {
                $message->to($email)->cc(['info@neoestudioguardiacivil.es', 'david@qode.pro'])->subject
                ('Factura de pago');
                $message->from('info@neoestudioguardiacivil.es', 'Neoestudio');

                $message->attach($path);
            });
        }
        $pays = \App\Pay::where('userId', $pay->userId)->orderBy('updated_at', 'desc')->get();
        $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
        $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
        $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();
        if ($pay->type != "books") {
            $message = "Pago exitoso. Correo de confirmaci??n enviado
            a su direcci??n de correo electr??nico con c??digo de estudiante y contrase??a";
        }
        if ($pay->type == "books") {
            $message = "Pago exitoso. Correo de confirmaci??n enviado
            a su direcci??n de correo electr??nico";
        }

        //return redirect()->route('heavy',array('userId'=>$userId,'payId'=>$pay->id,'message'=>$message));
        //return redirect('paymentHistory/'.$userId.'/'.$payId.'/'.$payType);
        return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists', 'message', 'pay'));

    }

    public function paymentFailure(Request $request, $userId)
    {

        $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
        $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
        $alumnoConvocadoExists = \App\Pay::where('userId', $userId)->where('type', 'alumnoConvocado')->exists();
        $message2 = "Tu pago no fue exitoso.";
        $pays = \App\Pay::where('userId', $userId)->orderBy('updated_at', 'desc')->get();
        return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists', 'alumnoConvocadoExists', 'message2'));
    }

    public function showAll($type, $userId)
    {


        if ($type == "alumno") {

            $pays = \App\Pay::where('type', 'Alumno')->where('userId', $userId)->orderBy('created_at', 'desc')->get();

            return view('payments.index', compact('pays', 'type'));
        }
        if ($type == "alumnoConvocado") {
            $pays = \App\Pay::where('type', 'Alumno Convocado')->where('userId', $userId)->orderBy('created_at', 'desc')->get();
            return view('payments.index3', compact('pays'));
        }

    }

    public function showPaysI($type)
    {

        if ($type == "books") {
            $pays = \App\Pay::where('type', 'books')->orderBy('created_at', 'desc')->get();
            return view('payments.index2', compact('pays'));
        }
        if ($type == "alumno") {
            $pays = \App\Pay::where('type', 'Alumno')->select('userId')->distinct()->get();

            return view('payments.curi', compact('pays'));
        }
        if ($type == "alumnoConvocado") {
            $pays = \App\Pay::where('type', 'Alumno Convocado')->select('userId')->distinct()->get();
            return view('payments.curi2', compact('pays'));
        }

    }

    public function pay($userId, $amount, $type, $payId)
    {

        $user_data = Session::get('userData');
        $paymentMethods = $user_data->paymentMethods();
        $intent = $user_data->createSetupIntent();

        return view('payments/payment', compact('intent', 'userId', 'amount', 'type', 'payId', 'paymentMethods'));
    }

    public function temario2(Request $request)
    {

        $userId = $request->get('userId');
        $package_id = $request->get('package_id');
        $package_tenure = $request->get('packageTenure');
        $month = Carbon::now()->month;

        $a = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->first();
        $amount = (int)$a->amount;

        if (isset($package_id) && empty($package_id) === false) {
            $b = \App\ServicePackage::where('id', $package_id)->first();
            $amountR = $b->price;
        } else {
            $b = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->first();
            $amountR = (int)$b->amount;
        }


        $number = $request->get('number');


        if ($number == 'once') {
            $month = Carbon::now()->month;
            $amount = $amount;
            $pay = new \App\Pay;
            $pay->amount = $amount;
            $pay->userId = $userId;
            $pay->type = "alumno";
            $pay->status = "pending";
            $pay->paymentType = "once";
            $pay->save();
            $startDate = Carbon::now(); //returns current day
            $firstDay = $startDate->firstOfMonth();
            $pay->deadline = $firstDay->addDays(24)->toDateString();
            $pay->save();
            $pays = \App\Pay::where('userId', $pay->userId)->orderBy('updated_at', 'desc')->get();
            $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
            $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();


            return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists'));

        }
        if ($number == 'recurring') {

            $pay = new \App\Pay;
            $pay->amount = $amountR;
            $pay->userId = $userId;
            $pay->type = "alumno";
            $pay->status = "pending";
            $pay->paymentType = "recurring";
            $pay->save();

            $pay_package = new \App\PayPackage();
            $pay_package->pay_id = $pay->id;
            $pay_package->package_id = $package_id;
            $pay_package->package_tenure = $package_tenure;
            $pay_package->save();

            $pays = \App\Pay::where('userId', $pay->userId)->orderBy('updated_at', 'desc')->get();
            $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
            $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();

            if (isset($package_id) && empty($package_id) === false) {
                return redirect('pay/' . $userId . '/' . $amountR . '/alumno/' . $pay->id);
            } else {
                return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists'));
            }
        }


    }

    public function temario(Request $request)
    {
        $package_payment = array();
        $count = count($request->all());
        if (Session::has('package_payment') && $count <= 0) {
            $package_payment = Session::get('package_payment');
            $userId = $package_payment['userId'];
            $package_id = $package_payment['package_id'];
            $package_tenure = $package_payment['packageTenure'];
        } elseif($count > 0) {
            $userId = $request->get('userId');
            $package_id = $request->get('package_id');
            $package_tenure = $request->get('packageTenure');
        }
        $user_data = array();
        if (empty(Session::get('userData')) === false) {
            $user_data = Session::get('userData');
            $userId = $user_data->id;
        }
        $hasPackage = \App\Pay::where('userId', $userId)->where('status', 'paid')->where('type', 'alumno')->count();
        if ($hasPackage > 0) {
            $pay = \App\Pay::where('userId', $userId)->where('status','paid')->where('type','alumno')->orderBy('id','desc')->first();
            $paid_package_count = \App\PayPackage::where('pay_id', $pay->id)->count();
            if($paid_package_count > 0){
                return redirect('comienza');
            }
        }

        $month = Carbon::now()->month;

        $paymentTypeData = array('price_annual' => 'once', 'price_fractional' => 'recurring', 'price_monthly' => 'recurring');
        $courses = array('Plata' => 'Silver', 'Oro' => 'Gold', 'Diamante' => 'Diamond');

        if (isset($package_id) && empty($package_id) === false) {
            $pacakge_data = ServicePackage::where('id', $package_id)->first();
            $column = 'price_' . $package_tenure;
            if ($package_tenure == "annual") {
                $column = 'price_fractional';
            }
            if ($package_tenure == "fractional") {
                $column = 'price_annual';
            }
            if ($package_tenure == "monthly") {
                $column = 'price_annual';
            }
            $b = \App\PackagePrice::where('package_id', $package_id)->where('price_type', $package_tenure)->select(DB::raw($column))->first();
            $amountR = (float)str_replace('???', '', $b->$column);
            if ($package_tenure == "fractional") {
                $amountR = ($amountR * 2);
            }
            $amount = (int)$amountR;
            $number = $paymentTypeData[$column];
        } else {
            $a = \App\Price::where('studentType', 'Alumno')->where('type', 'once')->first();
            $amount = (int)$a->amount;

            $b = \App\Price::where('studentType', 'Alumno')->where('type', 'recurring')->first();
            $amountR = (int)$b->amount;
            $number = $request->get('number');
        }

        $pay = new \App\Pay;
        if ($number == 'once') {
            $month = Carbon::now()->month;
            $pay->amount = $amount;
            $pay->paymentType = "once";
            $startDate = Carbon::now(); //returns current day
            $firstDay = $startDate->firstOfMonth();
            if (isset($package_id) && empty($package_id) === false) {
                $pay->deadline = $firstDay->addDays(359)->toDateString();
            } else {
                $pay->deadline = $firstDay->addDays(24)->toDateString();
            }
        }
        if ($number == 'recurring') {
            $pay->amount = $amountR;
            $pay->paymentType = "recurring";
        }
        $pay->userId = $userId;
        $pay->type = "alumno";
        $pay->status = "pending";
        $pay->save();

        if (isset($package_id) && empty($package_id) === false) {
            $pay_package = new \App\PayPackage();
            $pay_package->pay_id = $pay->id;
            $pay_package->package_id = $package_id;
            $pay_package->payment_method = $package_tenure;
            $pay_package->course = $courses[$pacakge_data->title];
            $pay_package->amount = $pay->amount;
            $pay_package->save();
        }
        $pays = \App\Pay::where('userId', $pay->userId)->orderBy('updated_at', 'desc')->get();
        $booksExists = \App\Pay::where('userId', $userId)->where('type', 'books')->exists();
        $alumnoExists = \App\Pay::where('userId', $userId)->where('type', 'alumno')->exists();
        if (isset($package_id) && empty($package_id) === false) {
            $payData = array('userId' => $userId, 'amount' => $pay->amount, 'type' => 'alumno', 'payId' => $pay->id, 'package_tenure' => $package_tenure);
            Session::put('payData', $payData);
            return redirect('pay/' . $userId . '/' . $pay->amount . '/alumno/' . $pay->id . '?' . $package_tenure);
        } else {
            return view('payments/pays', compact('pays', 'userId', 'booksExists', 'alumnoExists'));
        }
    }

    public function coursePay(Request $request)
    {
        $product_payment = array();
        if (Session::has('product_payment')) {
            $product_payment = Session::get('product_payment');
            $userId = $product_payment['userId'];
            $product_ids = $product_payment['pids'];
            $shipping = $product_payment['shipping'];
            $shipping_id = $product_payment['shipping_id'];
            $total_quantity = $product_payment['total_quantity'];
            $amount = $product_payment['total_price'];
        } else {
            $userId = $request->get('userId');
            $product_ids = $request->get('pids');
            $shipping = $request->get('shipping');
            $shipping_id = $request->get('shipping_id');
            $total_quantity = $request->get('total_quantity');
            $amount = $request->get('total_price');
        }
        if (isset($shipping) && empty($shipping) === false && $shipping > 0) {
            $amount = ($amount + $shipping);
        }
        $user_data = array();
        if (empty(Session::get('userData')) === false) {
            $user_data = Session::get('userData');
            $userId = $user_data->id;
        }

        $month = Carbon::now()->month;

        $isPay = false;
        if (isset($product_ids) && count($product_ids) > 0) {
            $pay = new \App\Pay;
            $pay->amount = $amount;
            $pay->userId = $userId;
            $pay->type = "books";
            $pay->status = "pending";
            $pay->save();
            foreach ($product_ids AS $product_id => $quantity) {
                if ($quantity > 0) {
                    $prod = Product::where('id', $product_id)->count();
                    if (isset($prod) && $prod > 0) {
                        $isPay = true;
                        $productData = Product::where('id', $product_id)->first();
                        $pay_package = new \App\PayProduct();
                        $pay_package->pay_id = $pay->id;
                        $pay_package->product_id = $product_id;
                        $pay_package->shipping_id = $shipping_id;
                        $pay_package->quantity = $quantity;
                        $pay_package->amount = $productData->price;
                        $pay_package->save();
                    }
                }
            }
            Session::put('product_payment', null);
            if ($isPay) {
                $payData = array('userId' => $userId, 'amount' => $pay->amount, 'type' => 'books', 'payId' => $pay->id, 'package_tenure' => null);
                Session::put('payData', $payData);
                return redirect('pay/' . $userId . '/' . $pay->amount . '/books/' . $pay->id);
            } else {
                return redirect()->back()->with('error', 'Al menos una cantidad de producto puede ser mayor que cero para proceder con el pago, as?? que haga clic en el signo m??s de cualquier producto.');
            }
        } else {
            return redirect()->back()->with('error', 'Al menos una cantidad de producto puede ser mayor que cero para proceder con el pago, as?? que haga clic en el signo m??s de cualquier producto.');
        }
    }

}
