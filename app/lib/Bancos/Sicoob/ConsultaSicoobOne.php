<?php

/**
 * Classe ConsultarCobrancaSicredi para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class ConsultaSicoobOne {
    private $key;
    private $titulos;
    private $parametros;
    private $token;
    private $getToken;
  
    /**
     * Construtor da classe ConsultarCobrancaSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
        $this->key = $key;
       
        // Realize suas operações de banco de dados aqui
        $this->titulos = CobrancaTitulo::find($this->key);
        $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
  
    }

    /**
     * Função para consultar cobrança no Sicredi.
     *
     * @return mixed - Retorna a resposta da API Sicredi ou exibe uma mensagem de erro.
     */
    public function search() {

 
// Define the parameters as an associative array
$params = array(
    'numeroContrato' => 25546454,
    'modalidade' => 1,
    'linhaDigitavel' => 'string',
    'codigoBarras' => 'string',
    'nossoNumero' => 2588658
);

// Convert the array to a JSON string
$jsonParams = json_encode($params);

// Now, you can use $jsonParams in your cURL request

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox.sicoob.com.br/sicoob/sandbox/cobranca-bancaria/v2/boletos?' . http_build_query($params),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer 1301865f-c6bc-38f3-9f49-666dbcfc59c3',
    'Accept: application/json',
    'client_id: 9b5e603e428cc477a2841e2683c92d21',
  ),
));

$response = curl_exec($curl);

curl_close($curl);

// Convert JSON response to stdClass
$resultObj = json_decode($response);

 
 
// Assuming $resultObj contains the stdClass object with the data

$message = "Número do Contrato: " . $resultObj->numeroContrato . "<br>";
$message .= "Modalidade: " . $resultObj->modalidade . "<br>";
$message .= "Número da Conta Corrente: " . $resultObj->numeroContaCorrente . "<br>";
$message .= "Espécie do Documento: " . $resultObj->especieDocumento . "<br>";
$message .= "Data de Emissão: " . $resultObj->dataEmissao . "<br>";
$message .= "Nosso Número: " . $resultObj->nossoNumero . "<br>";
$message .= "Seu Número: " . $resultObj->seuNumero . "<br>";
$message .= "Identificação do Boleto da Empresa: " . $resultObj->identificacaoBoletoEmpresa . "<br>";
$message .= "Código de Barras: " . $resultObj->codigoBarras .  "<br>";
$message .= "Linha Digitavel: " . $resultObj->linhaDigitavel .  "<br>";
$message .= "Identificação da Emissão do Boleto: " . $resultObj->identificacaoEmissaoBoleto . "<br>";
$message .= "Identificação da Distribuição do Boleto: " . $resultObj->identificacaoDistribuicaoBoleto .  "<br>";
$message .= "Valor: " . $resultObj->valor .  "<br>";
$message .= "Data de Vencimento: " . $resultObj->dataVencimento .  "<br>";
$message .= "Data Limite de Pagamento: " . $resultObj->dataLimitePagamento .  "<br>";
$message .= "Valor do Abatimento: " . $resultObj->valorAbatimento .  "<br>";

 
 
 // Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', $message);
        // -----



}
    
}






