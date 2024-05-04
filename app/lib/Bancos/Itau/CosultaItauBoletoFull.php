<?php

 
/**
 * Classe ConsultarCobrancaSicredi para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class CosultaItauBoletoFull {
 
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $token;
    private $Geratoken;
    private static $database = 'conecatarbanco';
    /**
     * Construtor da classe SicrediBoletoCreate.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key)
    {
        $this->key = $key;
        
        
            // Realize suas operações de banco de dados aqui
            $this->titulos = CobrancaTitulo::find($this->key);
            $this->pessoas = Cliente::find($this->titulos->cliente_id);
            $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
            $this->beneficiario = Beneficiario::find($this->parametros->beneficiario_id);
            $this->Geratoken = new GetTokenItau($this->parametros->id);
            $this->token=  $this->Geratoken->create();

    }

    
    public function GetBusca()
    {

    // 'x-itau-apikey: '. $this->parametros->client_id,
    //             'x-itau-correlationID: '. $this->parametros->client_id_bolecode,
    //             'x-itau-flowID: 1577a65f-5c09-47d9-a660-f6af3389aedc',
    //             'Content-Type: application/json',
    //             'Authorization: Bearer '.$this->token

            $x_itau_correlationID = ClassGenerica::CreateUuid(1);
            $x_itau_flowID = ClassGenerica::CreateUuid(2);

            $id_beneficiario =  $this->parametros->numerocontrato;
            $nosso_numero = $this->titulos->seunumero;
 
            $curl = curl_init();
          
            curl_setopt_array($curl, array(
              CURLOPT_URL =>   $this->parametros->url3.'?id_beneficiario='.$this->parametros->numerocontrato.'&codigo_carteira=109&nosso_numero='.$nosso_numero.'&view=specific',
                  CURLOPT_SSLCERTTYPE => 'P12',
              CURLOPT_SSLCERT => $this->parametros->certificado,
              CURLOPT_SSLCERTPASSWD => $this->parametros->senha,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'x-itau-apikey: '.$this->parametros->client_id,
                'x-itau-correlationID: '.$this->parametros->client_id_bolecode,
                
                'Content-Type: application/json',
                'Authorization: Bearer '.$this->token
              ),
            ));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);


 
$dadosBoleto=$response->data[0]->dado_boleto->dados_individuais_boleto[0];

if($dadosBoleto){
// Construa a mensagem
$mensagem = "Detalhes do Boleto:<br>";
$mensagem .= "Situação Geral do Boleto: {$dadosBoleto->situacao_geral_boleto}<br>";
$mensagem .= "Status de Vencimento: {$dadosBoleto->status_vencimento}<br>";
$mensagem .= "Número Nosso Número: {$dadosBoleto->numero_nosso_numero}<br>";
$mensagem .= "Data de Vencimento: {$dadosBoleto->data_vencimento}<br>";
$mensagem .= "Valor do Título: {$dadosBoleto->valor_titulo}<br>";
$mensagem .= "Texto Seu Número: {$dadosBoleto->texto_seu_numero}<br>";
$mensagem .= "DAC do Título: {$dadosBoleto->dac_titulo}<br>";
$mensagem .= "Código de Barras: {$dadosBoleto->codigo_barras}<br>";
$mensagem .= "Número Linha Digitável: {$dadosBoleto->numero_linha_digitavel}<br>";
$mensagem .= "Data Limite de Pagamento: {$dadosBoleto->data_limite_pagamento}<br>";
 
 // Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', $mensagem);
        // -----

}else{
    
       new TMessage('info', 'sem informações do boleto');
        // -----
    
}
 
 
    }
}
