<?php

 
/**
 * Classe ConsultarCobrancaSicredi para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */  
class BaixaBoletoSicredi { ///  BaixaBoletoSicredi::baixar
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
            $this->getToken = new GetTokenSicredi($this->parametros->id);
            $this->token = $this->getToken->create();
 
            
    }

    /**
     * Função para consultar cobrança no Sicredi.
     *
     * @return mixed - Retorna a resposta da API Sicredi ou exibe uma mensagem de erro.
     */
    public function baixar() {
 
    $url = $this->parametros->url2.'/'. $this->titulos->seunumero.'/baixa';

    $headers = [
            'x-api-key: ' . $this->parametros->client_id,
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json',
            'cooperativa: ' . $this->parametros->cooperativa,
            'posto: ' . $this->parametros->posto,
            'codigoBeneficiario: '.$this->parametros->codigobeneficiario
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS => '{}',
        CURLOPT_HTTPHEADER => $headers,
    ]);

    $response = curl_exec($curl);

    curl_close($curl);
$response = json_decode($response);
            $message = "Baixa realizada com sucesso!<br>";
            $message .= "ID da Transação: {$response->transactionId}<br>";
            $message .= "Data do Movimento: {$response->dataMovimento}<br>";
            $message .= "Código do Beneficiário: {$response->codigoBeneficiario}<br>";
            $message .= "Nosso Número: {$response->nossoNumero}<br>";
            $message .= "Cooperativa: {$response->cooperativa}<br>";
            $message .= "Posto: {$response->posto}<br>";
            $message .= "Status do Comando: {$response->statusComando}<br>";
            $message .= "Data e Hora do Registro: {$response->dataHoraRegistro}<br>";
            $message .= "Tipo de Mensagem: {$response->tipoMensagem}<br>";
            
             
            new TMessage('info', $message);
              


   
   
   
}
 
 
 
    
}