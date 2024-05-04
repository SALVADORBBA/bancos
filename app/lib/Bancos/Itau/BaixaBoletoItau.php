<?php

 
/**
 * Classe ConsultarCobrancaSicredi para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */  
class BaixaBoletoItau { ///  BaixaBoletoSicredi::baixar
    private $key;
    private $titulos;
    private $parametros;
    private $token;
    private $getToken;
    private $someValue;
    /**
     * Construtor da classe ConsultarCobrancaSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
            $this->key = $key;
          
             $this->titulos = CobrancaTitulo::find($this->key);
 
           $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
        $this->Geratoken = new GetTokenItau($this->parametros->id);
        $this->token=  $this->Geratoken->create();
 
            
    }

    public function baixar() {

        $x_itau_correlationID = ClassGenerica::CreateUuid(1);
        $x_itau_flowID = ClassGenerica::CreateUuid(2);
        $id_boleto =   $this->parametros->numerocontrato.$this->parametros->carteira .$this->titulos->seunumero;
 

        $url = $this->parametros->url2.'/' . $id_boleto . '/baixa';
 
        $headers = [
            'x-itau-apikey: ' .$this->parametros->client_id,
            'x-itau-correlationID: ' . $x_itau_correlationID,
            'x-itau-flowID: ' . $x_itau_flowID,
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token,
        ];

 

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSLCERTTYPE => 'P12',
            CURLOPT_SSLCERT =>  $this->parametros->certificado,
            CURLOPT_SSLCERTPASSWD => $this->parametros->senha,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS => '{}',
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
 
        
    
     
     
     $mensagem= 'Código: '.$response->codigo.'<br> Mensagem: '.  $response->campos[0]->mensagem;
     
    
        new TMessage('info', $mensagem);
  


        
}
}
        
        
        
        
        
        
        
        