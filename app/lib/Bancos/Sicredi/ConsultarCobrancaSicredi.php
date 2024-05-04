<?php

/**
 * Classe ConsultarCobrancaSicredi para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class ConsultarCobrancaSicredi {
    private $key;
    private $titulos;
    private $parametros;
    private $token;
    private $getToken;
    private $tipo;
    /**
     * Construtor da classe ConsultarCobrancaSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key,$tipo=null) {
        $this->key = $key;
        $this->tipo= $tipo;
        // Realize suas operações de banco de dados aqui
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
    public function search() {
        $url =  $this->parametros->url2;
        $method = 'GET';
        $data = $payload;
        $headers = [
            'x-api-key: ' . $this->parametros->client_id,
            'Authorization: Bearer ' .  $this->token,
            'Content-Type: application/json',
            'cooperativa: ' . $this->parametros->cooperativa,
            'posto: ' . $this->parametros->posto,
        ];

        $queryParams = http_build_query([
            'cooperativa' => $this->parametros->cooperativa,
            'posto' => $this->parametros->posto,
            'codigoBeneficiario' => '12345',
            'nossoNumero' => $this->titulos->seunumero,
        ]);

        $fullUrl = $url . '?' . $queryParams;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $fullUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        if (isset($response->linhaDigitavel)) {
            
            if( $this->tipo==1){
            // Sucesso na consulta
          $abstracao=    $response;
// Assuming $resultObj contains the stdClass object with the data

        $message = "Linha Digitável: " . $abstracao->linhaDigitavel . "<br>";
        $message .= "Código de Barras: " . $abstracao->codigoBarras . "<br>";
        $message .= "Carteira: " . $abstracao->carteira . "<br>";
        $message .= "Seu Número: " . $abstracao->seuNumero . "<br>";
        $message .= "Nosso Número: " . $abstracao->nossoNumero . "<br>";
        
        // Accessing the 'pagador' property which is an object
        $message .= "Pagador:<br>";
        $message .= "  Nome: " . $abstracao->pagador->nome . "<br>";
        $message .= "  CPF/CNPJ: " . $abstracao->pagador->documento . "<br>";
        $message .= "  Endereço: " . $abstracao->pagador->endereco . "<br>";
        
        $message .= "Data de Emissão: " . $abstracao->dataEmissao . "<br>";
        $message .= "Data de Vencimento: " . $abstracao->dataVencimento . "<br>";
        $message .= "Valor Nominal: " . $abstracao->valorNominal . "<br>";
        $message .= "Situação: " . $abstracao->situacao . "<br>";
        
         
 // Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', $message);
       
            }else{
            
            $abstracao = new stdClass();

foreach ($response as $key => $value) {
    if (is_object($value)) {
        foreach ($value as $nestedKey => $nestedValue) {
            $abstracao->{$key . '_' . $nestedKey} = $nestedValue;
        }
    } else {
        $abstracao->{$key} = $value;
    }
}

 
 
   return $abstracao;

            }      
            
        } else {
            // Erro na consulta
            $error = $response->error;
            $code = $response->code;
            $message = $response->message;

            // Construir a mensagem de erro
            $mensagem = "<b>Erro! {$error}</b><br>";
            $mensagem .= "Code: {$code}<br>";
            $mensagem .= "Mensagem: {$message}<br>";

            // Exibir a mensagem de erro
            new TMessage('info', $mensagem);
        }
    }
}
