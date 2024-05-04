<?php



 /**
  * 
  */
 class consultarCNPJIE
 {
     
     /**
      * 
      */             //  consultarCNPJIE::Busca
     public static function Busca($cnpj)
     {
 
    $cnpj= ClassMaster::TrataDoc($cnpj);
    
 
 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://publica.cnpj.ws/cnpj/'.$cnpj,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
 
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 
   $response = json_decode($response);


if($response->status==400 && $response->status==429){
    
    // Código gerado pelo snippet: "Mensagem Toast"
        TToast::show("info", "Excedido o limite máximo de 3 consultas por minuto.", "center", "");
        // -----


    
}else{
    return $response;}

     }
 }
