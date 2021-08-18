<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\RedsysApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\mughees;
use Illuminate\Support\Facades\Auth;
use wapmorgan\MediaFile\MediaFile;
use wapmorgan\Mp3Info\Mp3Info;
use Carbon\Carbon;
use Mail;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
//use Importer;
//use File;
use App\User;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

$GLOBALS["REDSYS_API_PATH"]=realpath(dirname(__FILE__));
    $GLOBALS["REDSYS_LOG_ENABLED"]=true;

    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/message/RESTOperationMessage.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/message/RESTAuthenticationRequestMessage.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/RESTService.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/Impl/RESTInitialRequestService.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/Impl/RESTAuthenticationRequestService.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/Impl/RESTOperationService.php";
    include_once $GLOBALS["REDSYS_API_PATH"].'/Utils/RESTLogger.php';
    include_once $GLOBALS["REDSYS_API_PATH"].'/Constants/RESTConstants.php';
class recuring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:recuring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now=Carbon::now()->toDateTimeString();
        $exists=\App\Pay::where('process','auto')->where('status','pending')->exists();
        if($exists==true){
            $pays=\App\Pay::where('process','auto')->where('status','pending')->get();
            
            foreach ($pays as $key => $pay) {
                if(!empty($pay)){
                    $userId=$pay->userId;
                    $identifierE=\App\Identifier::where('userId',$userId)->exists();
                    if($identifierE==true){
                        $identifier=\App\Identifier::where('userId',$userId)->first();

                        if(!empty($identifier->identifier)){
                            
                            if(Carbon::parse($now)->gte(Carbon::parse($pay->scheduleTime))){
                                
                                $orderID = substr( str_shuffle( str_repeat( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 10 ) ), 0, 12 );
                                $request = new \RESTOperationMessage();
                                
                                        
                                // Operation mandatory data
                                $request->setAmount($pay->amount); // i.e. 1,23 (decimal point depends on currency code)
                                $request->setCurrency("978"); // ISO-4217 numeric currency code
                                $request->setMerchant("351565320");
                                $request->setTerminal("001");
                                $request->setOrder($orderID);
                                $request->setTransactionType(\RESTConstants::$AUTHORIZATION);
                                

                                //Reference information
                                $request->useReference($identifier->identifier);
                                
                                // Other optional parameters example can be added by "addParameter" method
                                $request->addParameter("DS_MERCHANT_PRODUCTDESCRIPTION", "Prueba de pago con DirectPayment y referencia");

                                //Method for a direct payment request (without authentication)
                                $request->useDirectPayment();   

                                //Printing SendMessage
                                //echo "<h1>Mensaje a enviar</h1>";
                                //var_dump($request);

                                // Service setting (Signature, Environment, type of payment)
                                $signatureKey = "I8c7RLGs35xGlPYuu95SYweaFHf + eHwA";
                                $service = new \RESTOperationService($signatureKey, \RESTConstants::$ENV_SANDBOX);

                                $response = $service->sendOperation($request);

                                // Response analysis
                                //echo "<h1>Respuesta recibida</h1>";
                                //var_dump($response->getResult());

                                switch ($response->getResult()) {
                                    case \RESTConstants::$RESP_LITERAL_OK:
                                        $pay->status="paid";
                                        $pay->response="ok";
                                        $pay->save();
                                        $uss=\App\User::find($pay->userId);
                                        if($uss->field1x=="Bloquear"){
                                            $uss->field1x="Desbloquear";
                                            $uss->save();
                                        }
                                        //echo "<h1>Operation was OK</h1>";
                                    break;
                                    
                                    case \RESTConstants::$RESP_LITERAL_AUT:
                                            $pay->status="pending";
                                            $pay->response="aut";
                                            $pay->save();
                                        //echo "<h1>Operation requires authentication</h1>";
                                    break;
                                    
                                    default:
                                        $pay->status="pending";
                                        $pay->response="not";
                                        $pay->save();
                                        //echo "<h1>Operation was not OK</h1>";
                                    break;
                                }
                            }
                        }
                    }
                return "done";
				}
            }
            
        }
       
    }
}
