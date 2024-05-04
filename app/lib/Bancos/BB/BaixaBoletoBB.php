<?php

/**
 * Classe ConsultaBoletoBB para consulta de cobrança no ConsultaBoletoBB.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class BaixaBoletoBB {
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
    public function dow() {
 


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $this->parametros->url2.'/'. $this->titulos->seunumero.'/baixar?gw-dev-app-key='.$this->parametros->gw_dev_app_key,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
   "numeroConvenio":'. $this->parametros->numeroconvenio.'
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer '. $this->token,
    
  ),
));
 
 
        $response = curl_exec($curl);

        curl_close($curl);
 $response=json_decode( $response);
 

 
          $responseObj =$response;
          
 

if (isset($responseObj->errors) && is_array($responseObj->errors) && count($responseObj->errors) > 0) {
    $mensagens = [];

    // Iterar sobre os erros e adicionar números de índice
    foreach ($responseObj->errors as $indice => $erro) {
        // Personalize a mensagem conforme necessário
        $mensagemErro = sprintf("<b>Erro:  %d</b><br> <b>Código: </b> %s <br> <b>Ocorrência: </b> %s <h5><b> %s</h5> ",
            $indice + 1, // Adicionando 1 para começar do índice 1
            $erro->code, // Alterando para a propriedade correta
            $erro->message,
            $erro->occurrence
            // Removendo $erro->versao se não for necessário
        );

        $mensagens[] = $mensagemErro;
    }

    $mensagemFinal = "<b>Foram encontrados os seguintes erros:</b><br> " . implode("<br>", $mensagens);

    if (!empty($responseObj->errors)) {
        // Agora você pode exibir $mensagemFinal onde necessário no Adianti Framework
        // Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', $mensagemFinal);
        // -----
    }
   
}
 
              $Cobranca = CobrancaTitulo::find($this->key);
                if ($Cobranca) {
                $Cobranca->status = 5;
  
        $Cobranca->databaixa = $response->dataBaixa;
        $Cobranca->horariobaixa = $response->horarioBaixa;
                $Cobranca->data_baixa = $response->dataBaixa;
    $Cobranca->status = 4;
                $Cobranca->save();
                }
                
    $mensagemFinal = "Solicitação de Baixa enviada!";
// Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', $mensagemFinal);
        // -----


}
    
}






