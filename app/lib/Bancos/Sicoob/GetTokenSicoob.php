<?php
 
class GetTokenSicoob  
{
 
 
    public static function create($key)
    {

     $empresa = ParametrosBancos::find($key);

    

   
        // return $empresa->client_id;
        $curl = curl_init();

        curl_setopt_array($curl, array(

            CURLOPT_URL => $empresa->url1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=cobranca_boletos_baixa%20cobranca_boletos_consultar%20cobranca_boletos_pagador%20cobranca_pagadores%20cobranca_boletos_incluir&client_id=' . $empresa->client_id,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',

            ),


            CURLOPT_SSLCERTTYPE => 'P12',
            CURLOPT_SSLCERT =>  $empresa->certificado,
            CURLOPT_SSLCERTPASSWD => $empresa->senha,

        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
        return  $response->access_token;
    }
}