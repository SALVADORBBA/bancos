<?php

class GetTokenSantander  
{
    private $key;
    private $parametros;
 
    /**
     * Construtor da classe GetTokenSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
        $this->key = $key;
        // Make sure ParametrosItau class and find method are defined
        $this->parametros = ParametrosBancos::find($this->key);
    }
 
    /**
     * Arquivo: GetTokenItau
     * Autor: Rubens do Santos
     * Contato: salvadorbba@gmail.com
     * Descrição: Descrição breve do propósito deste arquivo.
     *
     * @return string|false O token de acesso se a autenticação for bem-sucedida, caso contrário, uma mensagem de erro ou false em caso de falha.
     */
    public function GetToken() {
      
 

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL =>  $this->parametros->url1,
            CURLOPT_SSLCERTTYPE => 'P12',
            CURLOPT_SSLCERT => $this->parametros->certificado,
            CURLOPT_SSLCERTPASSWD =>  $this->parametros->senha,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id='.$this->parametros->client_id.'&client_secret='.$this->parametros->client_secret.'&grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
          
          
          $response= json_decode($response);
          
          
          return  $response->access_token;
          
          

}
    
}
