<?php

/**
 * Classe SicrediBoletoCreate  boleto sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 * Construtor da classe SicrediBoletoCreate.
 *
 * @param string $key - A chave para buscar os parâmetros no banco de dados.
 */
class SicrediBoletoCreate
{
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $view;
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
  
 
    }

    /**
     * Função para criar um boleto Sicredi.
     */
    public function Getcreate()
    {
     
 
            // if($this->titulos->status!=1){
             
            
            // $mensagem = "<b>Erro de Duplicidade</b><br>";
            // $mensagem .= "<strong>Código:</strong> 401<br>";
            // $mensagem .= "<strong>Referencia ".$this->titulos->linhadigitavel." </strong><br>";
            // $mensagem .= "<strong>Mensagem:</strong> Já existe um título gerado anteriormente com essas informações.<br>";
            // // Exibir a mensagem
            // new TMessage('info', $mensagem);
            //  return ;   
            // }

        $ultimoNumeros = new GeraMeuNumero();
        $meunumero = $ultimoNumeros->create($this->beneficiario->id, TSession::getValue('userunitid'),3);

        $ultimoNumero = $meunumero->numero;
 
        $getToken = new GetTokenSicredi($this->parametros->id);
        $TokenSicredi = $getToken->create();

 

        // Criar um objeto stdClass para armazenar os dados do boleto.
        $boletoObj = new stdClass();
        // Dados do beneficiário
        $boletoObj->beneficiarioFinal = new stdClass();
        $boletoObj->beneficiarioFinal->documento = ClassMaster::cleandoc($this->beneficiario->cnpj);
        $boletoObj->beneficiarioFinal->tipoPessoa = "PESSOA_JURIDICA";
        $boletoObj->beneficiarioFinal->nome = ClassMaster::limitarTexto($this->beneficiario->nome, 40);
        $boletoObj->beneficiarioFinal->logradouro = ClassMaster::limitarTexto($this->beneficiario->endereco, 40);
        $boletoObj->beneficiarioFinal->complemento = $this->beneficiario->complemento;
        $boletoObj->beneficiarioFinal->numeroEndereco = $this->beneficiario->numero;
        $boletoObj->beneficiarioFinal->cidade = $this->beneficiario->cidade;
        $boletoObj->beneficiarioFinal->uf = ClassMaster::cleandoc($this->beneficiario->estado);
        $boletoObj->beneficiarioFinal->cep = ClassMaster::cleandoc($this->beneficiario->cep);




        // Dados do título
        $boletoObj->codigoBeneficiario = $this->parametros->numerocontrato;
        $boletoObj->dataVencimento = $this->titulos->data_vencimento; // YYYY-MM-DD
        $boletoObj->especieDocumento = 'DUPLICATA_MERCANTIL_INDICACAO';
        $boletoObj->tipoCobranca = "HIBRIDO";
        $boletoObj->nossoNumero = null;
        $boletoObj->seuNumero =  $ultimoNumero;
        $boletoObj->valor = number_format($this->titulos->valor, 2, '.', ''); 
 
        // Dados do pagador cpf_cnpj
        $boletoObj->pagador = new stdClass();
        $boletoObj->pagador->cep = $this->pessoas->cobranca_cep;
        $boletoObj->pagador->cidade =  $this->pessoas->cobranca_cidade;
        $boletoObj->pagador->documento = ClassMaster::cleandoc($this->pessoas->cpf_cnpj);
        $boletoObj->pagador->nome = ClassMaster::limitarTexto($this->pessoas->nome, 40);
        $boletoObj->pagador->tipoPessoa = ClassMaster::tipodoc($this->pessoas->cpf_cnpj);
        $boletoObj->pagador->endereco = ClassMaster::limitarTexto($this->pessoas->cobranca_endereco, 40);
        $boletoObj->pagador->uf =$this->pessoas->cobranca_uf;

        // Lidar com descontos, juros e multas
        if ($this->parametros->tipodesconto != '0') {
            $boletoObj->tipoDesconto = $this->parametros->tipodesconto;
            $boletoObj->valorDesconto1 = $this->parametros->valorprimeirodesconto;
            $boletoObj->dataDesconto1 = ClassMaster::calcularDataFutura($this->parametros->diasparadesconto_primeiro, $this->titulos->data_vencimento);

            if (isset($this->parametros->valorsegundodesconto) && $this->parametros->valorsegundodesconto) {
                $boletoObj->valorDesconto2 = $this->parametros->valorsegundodesconto;
                $boletoObj->dataDesconto2 = ClassMaster::calcularDataFutura($this->parametros->diasparadesconto_segundo, $this->titulos->data_vencimento);
            } else {
                unset($boletoObj->valorDesconto2);
                unset($boletoObj->dataDesconto2);
            }

            if (isset($this->parametros->valorTerceiroDesconto) && $this->parametros->valorTerceiroDesconto) {
                $boletoObj->valorDesconto3 = $this->parametros->valorTerceiroDesconto;
                $boletoObj->dataDesconto3 = ClassMaster::calcularDataFutura($this->parametros->diasparadesconto_terceiro, $this->titulos->data_vencimento);
            } else {
                unset($boletoObj->valorDesconto3);
                unset($boletoObj->dataDesconto3);
            }
        } else {
            unset($boletoObj->tipoDesconto);
            unset($boletoObj->valorDesconto1);
            unset($boletoObj->dataDesconto1);
        }

        if ($this->parametros->tipojurosmora == 0) {
            unset($boletoObj->tipoJuros);
            unset($boletoObj->juros);
        } else {
            $boletoObj->tipoJuros = $this->parametros->tipojurosmora;
            $boletoObj->juros = $this->parametros->valorjurosmora;
        }

        if ($this->parametros->tipomulta == 1) {
            $boletoObj->multa = $this->parametros->valormulta;
        } else {
            unset($boletoObj->multa);
        }

 $informativos = [
    ClassMaster::limitarTexto($this->parametros->info1, 80) ?? "",
    ClassMaster::limitarTexto($this->parametros->info2, 80) ?? "",
    ClassMaster::limitarTexto($this->parametros->info3, 80) ?? "",
    ClassMaster::limitarTexto($this->parametros->info4, 80) ?? "",
];

if ($this->titulos->identificador) {
    $informativos[] = ClassMaster::limitarTexto($this->parametros->info5, 69) . ' ' . ClassMaster::limitarTexto($this->titulos->identificador, 10) ?? "";
}

$boletoObj->informativos = $informativos;


        $boletoObj->mensagens = [
            ClassMaster::limitarTexto($this->parametros->mens1, 80) ?? "",
            ClassMaster::limitarTexto($this->parametros->mens2, 80) ?? "",
            ClassMaster::limitarTexto($this->parametros->mens3, 80) ?? "",
            ClassMaster::limitarTexto($this->parametros->mens4, 80) ?? "",
        ];



 
        $payload = json_encode($boletoObj);

 
     try {
         //aqui enviar o payload para Banco 
      
        $url =$this->parametros->url2;
        $method = 'POST';
        $data = $payload;
        $headers = [
            'x-api-key: ' . $this->parametros->client_id,  /// client_id fornecido pelo banco
            'Authorization: Bearer ' . $TokenSicredi, ///token gerado pelo sistema
            'Content-Type: application/json',
            'cooperativa: ' . $this->parametros->cooperativa, /// numero da cooperativa
            'posto: ' . $this->parametros->posto,/// numero do posto
        ];

 
        $responseData =  HttpClient::sendRequest($url, $method, $data, $headers); /// enviando para banco
 
 
        if(isset($responseData['linhaDigitavel'])){
        $objeto = CobrancaTitulo::find($this->titulos->id);
        if ($objeto) {
            $objeto->linhadigitavel = $responseData['linhaDigitavel'];
            $objeto->codigobarras = $responseData['codigoBarras'];
            $objeto->qrcode = $responseData['qrCode'];
            
            
             $objeto->user_id= TSession::getValue('userid');
             $objeto->txid = $responseData['txid'];
             $objeto->seunumero =$ultimoNumero;
            $objeto->status = 5;
            $objeto->store();
        }

        $objeto_up_numero = ControleMeuNumeros::find($meunumero->id);
        if ($objeto_up_numero) {
            $objeto_up_numero->status = 'uso';
            $objeto_up_numero->store();
        }
        $valor=ClassMaster::modeda_string($boletoObj->valor);
        $data=ClassMaster::data_BR($boletoObj->dataVencimento);
        
         // Código gerado pelo snippet: "Exibir mensagem"
        $mensagem = "<b>Boleto gerado com sucesso!</b><br>";
        $mensagem .= "Nosso número: {$objeto->seunumero}<br>";
        $mensagem .= "Cliente: {$this->pessoas->nome}<br>";
        $mensagem .= "Banco: {$this->parametros->apelido}<br>";
        $mensagem .= "Valor: {$valor}<br>";
        $mensagem .= "Vencimento: {$data}<br>";
        $mensagem .= "Linhas Digitáveis: {$objeto->linhadigitavel}<br>";
        new TMessage('info', $mensagem);
        




        }else{
            
 
 $response= explode("Erro HTTP 400:",  $responseData['error']);
 

   $errorData=json_decode($response[1]);
 
   $error = $errorData->error ;
    $code = $errorData->code ;
    $message = $errorData->message ;

    // Construir a mensagem
    $mensagem = "<b>Erro! {$error}</b><br>";
    $mensagem .= "Code: {$code}<br>";
    $mensagem .= "Mensagem: {$message}<br>";

    // Exibir a mensagem
    new TMessage('info', $mensagem);
 
      
            
        }

         
         // Feche a transação (a conexão será fechada automaticamente)
} catch (Exception $e) {
    // Lide com erros aqui
    TTransaction::rollback(); // Em caso de erro, faça rollback da transação
}
    }
}
