<?php

/**
 * Classe ConsultaBoletoBB para consulta de cobrança no ConsultaBoletoBB.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class ConsultaBoletoBB {
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
       
            $this->Geratoken = new GetTokenBancoBrasil($this->parametros->id);
            $this->token=  $this->Geratoken->create();
            
    }

    /**
     * Função para consultar cobrança no Sicredi.
     *
     * @return mixed - Retorna a resposta da API Sicredi ou exibe uma mensagem de erro.
     */
    public function search() {
  
 
 $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>$this->parametros->url2. '/'.$this->titulos->seunumero.'?gw-dev-app-key=d27b977902ffabb01365e17df0050d56b9e1a5b8&numeroConvenio=3128557',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer '. $this->token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
 $response=json_decode( $response);
 
 $resultObj= $response;
 
 
// Additional data from the array
$message .= "Código da Linha Digitável: " . $resultObj->codigoLinhaDigitavel . "<br>";
$message .= "Código de Aceite do Título de Cobrança: " . $resultObj->codigoAceiteTituloCobranca . "<br>";
$message .= "Valor Original do Título de Cobrança: " . $resultObj->valorOriginalTituloCobranca . "<br>";
$message .= "Valor Atual do Título de Cobrança: " . $resultObj->valorAtualTituloCobranca . "<br>";
$message .= "Data de Baixa Automática do Título: " . $resultObj->dataBaixaAutomaticoTitulo . "<br>";
$message .= "Nome do Sacado de Cobrança: " . $resultObj->nomeSacadoCobranca . "<br>";
$message .= "Texto do Código de Barras do Título de Cobrança: " . $resultObj->textoCodigoBarrasTituloCobranca . "<br>";

// ... add more fields as needed

// Código gerado pelo snippet: "Exibir mensagem"
new TMessage('info', $message);
// -----



}
    
}






