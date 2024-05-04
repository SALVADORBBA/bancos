<?php

class SendWhatsAppFiles
{
    public static function sendPDF($params)
    {
        
        
  
        $apiUrl = $params->rotaExterna;
        $apiKey =$params->apiKey;

        $requestData = new stdClass();
        $requestData->instanceName = $params->instanceName;
        $requestData->url_externa = $params->urlExterna;
        $requestData->codigo_pais = $params->codigoPais;
        $requestData->number =  $params->codigoPais.$params->number;
        $requestData->mediatype = $params->mediaType;
        $requestData->fileName = $params->fileName;
        $requestData->caption = $params->caption;
        $requestData->media = $params->media;

        $jsonRequestData = json_encode($requestData);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonRequestData,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'apikey: ' . $apiKey
            ],
        ]);

        $response = curl_exec($curl);
 
   if(isset($response)){
       
        $message = "Mensagem enviada com sucesso '.  $requestData->fileName. '<br>";
        $message .= "Número:  {$requestData->number}";
        TToast::show("success",$message, "bottomLeft", "");

   }else{
       
       return false;
       
   }
    }
}

 
