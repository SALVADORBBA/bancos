<?php

 
/**
 * Classe ConsultaCobrancaBanrisul para consulta de cobrança no Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class ConsultaCobrancaBanrisul {
    private $key;
    private $titulos;
    private $parametros;
    private $GetToken;
    private $token;
 
    /**
     * Construtor da classe ConsultaCobrancaBanrisul.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
            $this->key = $key;
            
            
            
            $this->titulos = CobrancaTitulo::find($this->key);
            $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
            $gera= new GetTokenSBanrisul($this->titulos->parametros_bancos_id);
            $this->token= $gera->create();
 
            
    }

    /**
     * Função para consultar cobrança no ConsultaCobrancaBanrisul.
     *
     * @return mixed - Retorna a resposta da API ConsultaCobrancaBanrisul ou exibe uma mensagem de erro.
     */
    public function search() {

 
 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apidev.banrisul.com.br/cobranca/v1/boletos/'.$this->titulos->linhadigitavel.'?tipo_id=LINHA_DIGITAVEL',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'accept: application/json',
    'bergs-beneficiario: '. $this->parametros->numerocontrato,
    'Authorization: Bearer '. $this->token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 $response=json_decode($response);
 
 
         // Código gerado pelo snippet: "Exibir mensagem"
        $mensagem = "<b>Boleto gerado com sucesso!</b><br>";
        $mensagem .= "Nosso número: {$response->titulo->nosso_numero}<br>";
        $mensagem .= "Cliente: {$response->titulo->pagador->nome}<br>";
   
        $mensagem .= "Valor: {$response->titulo->valor_nominal}<br>";
        $mensagem .= "Vencimento: {$response->titulo->data_vencimento}<br>";
        $mensagem .= "Linhas Digitáveis: {$response->titulo->linha_digitavel}<br>";
        new TMessage('info', $mensagem);

    }
    
}






