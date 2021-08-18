<?php

if(!class_exists('RESTInitialRequestService')){
	$GLOBALS["REDSYS_API_PATH"]="/home/neoestudio0/www/app/Console/Commands";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Service/RESTService.php";
	include_once $GLOBALS["REDSYS_API_PATH"]."/Model/message/RESTInitialRequestMessage.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/message/RESTResponseMessage.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/element/RESTOperationElement.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/RESTRequestInterface.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Model/RESTResponseInterface.php";
	include_once $GLOBALS["REDSYS_API_PATH"]."/Utils/RESTSignatureUtils.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Constants/RESTConstants.php";
    include_once $GLOBALS["REDSYS_API_PATH"]."/Utils/RESTLogger.php";

    class RESTInitialRequestService extends RESTService{
		function __construct($signatureKey, $env){
			parent::__construct($signatureKey, $env, RESTConstants::$INICIA);
        }
        
        public function createRequestMessage($message){
			$req=new RESTInitialRequestMessage();
			$req->setDatosEntrada($message);
		
			$tagDE=$message->toJson();
			
			$signatureUtils=new RESTSignatureUtils();
			$localSignature=$signatureUtils->createMerchantSignature($this->getSignatureKey(), $req->getDatosEntradaB64());
			$req->setSignature($localSignature);

			return $req;
        }

        public function createResponseMessage($trataPeticionResponse){
			$response = $this->unMarshallResponseMessage($trataPeticionResponse);
			RESTLogger::debug("Received ".RESTLogger::beautifyXML($response->toXml()));
			$paramsB64=json_decode($trataPeticionResponse,true)["Ds_MerchantParameters"];
			
			$transType = $response->getTransactionType();
			if(!$this->checkSignature($paramsB64, $response->getOperation()->getSignature()))
			{
				RESTLogger::error("Received JSON '".$trataPeticionResponse."'");
				$response->setResult(RESTConstants::$RESP_LITERAL_KO);
            }
            else{
                if ($response->getOperation()->getResponseCode() == null && $response->getOperation()->getPsd2() != null && $response->getOperation()->getPsd2() == RESTConstants::$RESPONSE_PSD2_TRUE) {
                    $response->setResult(RESTConstants::$RESP_LITERAL_AUT);
                    RESTLogger::info("Operation needs authentication");
                }else if ($response->getOperation()->getResponseCode() == null && $response->getOperation()->getPsd2() != null && $response->getOperation()->getPsd2() == RESTConstants::$RESPONSE_PSD2_FALSE) {
                    $response->setResult(RESTConstants::$RESP_LITERAL_OK);
                    RESTLogger::info("Operation finished successfully");
                }
                else{
                    $response->setResult(RESTConstants::$RESP_LITERAL_KO);
                    RESTLogger::info("Operation finished with errors");
                }
            }
			return $response;
        }
        
        public function unMarshallResponseMessage($message){
			$response=new RESTResponseMessage();
			
			$varArray=json_decode($message,true);
			
			$operacion=new RESTOperationElement();
			$operacion->parseJson(base64_decode($varArray["Ds_MerchantParameters"]));
			$operacion->setSignature($varArray["Ds_Signature"]);
			
			$response->setOperation($operacion);
			
			return $response;
        }
	}
}