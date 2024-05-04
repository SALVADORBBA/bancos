<?php

 
/**
 * Classe ConsultarCobrancaSicredi para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class ConsultaLiquidadosporDia {
    private $key;
    private $titulos;
    private $parametros;
    private $token;
    private $getToken;
    private $dia;
    /**
     * Construtor da classe ConsultarCobrancaSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key,$dia) {
            $this->key = $key;
            $this->dia = $dia;
            // Realize suas operações de banco de dados aqui
            $this->parametros = ParametrosBancos::find($this->key);
            
            $this->getToken = new GetTokenSicredi($this->parametros->id);
            $this->token = $this->getToken->create();
 
            
    }

    /**
     * Função para consultar cobrança no Sicredi.
     *
     * @return mixed - Retorna a resposta da API Sicredi ou exibe uma mensagem de erro.
     */
    public function search() {
   
 
   
   $url =  $this->parametros->url2.'/liquidados/dia';
$parameters = [
    'codigoBeneficiario' => $this->parametros->codigobeneficiario,
    'dia' =>  $this->dia,
    'cpfCnpjBeneficiario' =>  $this->parametros->cpfcnpjbeneficiario
];

$queryString = http_build_query($parameters);
$fullUrl = $url . '?' . $queryString;

$method = 'GET';
$headers = [
    'x-api-key: ' . $this->parametros->client_id,
    'Authorization: Bearer ' . $this->token,
    'Content-Type: application/json',
    'cooperativa: ' . $this->parametros->cooperativa,
    'posto: ' . $this->parametros->posto,
];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $fullUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $method,
    CURLOPT_HTTPHEADER => $headers,
));

$response = curl_exec($curl);

curl_close($curl);
  $response = json_decode($response);
   return $response->items;
 
    }
}
