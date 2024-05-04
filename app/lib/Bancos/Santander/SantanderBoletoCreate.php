<?php

/**
 * Classe SantanderBoletoCreate  boleto sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 * Construtor da classe SantanderBoletoCreate.
 *
 * @param string $key - A chave para buscar os parâmetros no banco de dados.
 */
class SantanderBoletoCreate
{
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $Workspaces;
      private $GetToken;
        private $token;
        private static $database = 'conecatarbanco';
    /**
     * Construtor da classe SantanderBoletoCreate.
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
  
 
      $this->Workspaces = WorkspacesSantander::find($this->parametros->workspaces_santander_id);
     $gera= new GetTokenSantander($this->titulos->parametros_bancos_id);
     
     $this->token= $gera->GetToken();
    }

    /**
     * Função para criar um boleto Sicredi.
     */
    public function Getcreate()
    {
   
 
              try{
                $curl = curl_init();
                
                // Create stdClass object
                $data = new stdClass();
                $data->workspace_id =$this->Workspaces->id_remoto;
                $data->environment = "Referente boleto nº: ". $this->key;
                $data->nsuCode = $this->key.$this->parametros->id;
                $data->nsuDate =  $this->titulos->data_vencimento;
                $data->covenantCode = $this->parametros->numerocontrato;
                $data->bankNumber = $this->parametros->numerocontacorrente;
                $data->clientNumber = $this->parametros->agencia ;
                $data->dueDate =  $this->titulos->data_vencimento;
                $data->issueDate =  $this->titulos->data_vencimento;
                $data->participantCode = "Gerado via API";
                $data->nominalValue = 1.00;
                
                // Payer information
                $data->payer = new stdClass();
                $data->payer->name = $this->pessoas->nome;
                $data->payer->documentType = "CPF";
                $data->payer->documentNumber =$this->pessoas->cpf_cnpj;
                $data->payer->address =  $this->pessoas->cobranca_endereco;
                $data->payer->neighborhood =  $this->pessoas->cobranca_bairro;
                $data->payer->city = $this->pessoas->cobranca_cidade;
                $data->payer->state =  $this->pessoas->cobranca_uf;
                $data->payer->zipCode = $this->pessoas->cobranca_cep;
              
            
                // Beneficiary information
                $data->beneficiary = new stdClass();
                $data->beneficiary->name = $this->beneficiario->nome;
                $data->beneficiary->documentType = "CNPJ";
                $data->beneficiary->documentNumber =  $this->beneficiario->cnpj;
                
                $data->documentKind = "DUPLICATA_MERCANTIL";
                $data->deductionValue = $this->titulos->valor;
                $data->paymentType = "REGISTRO";
                $data->writeOffQuantityDays = "3000";
                
                
 DD($this->token);
 
 EXIT;
                
                $data->messages = [$this->parametros->info1 ?? null,  $this->parametros->info2 ?? null,   $this->parametros->info3 ?? null];
                
                // Convert to JSON
                $jsonData = json_encode($data);
                
     
                curl_setopt_array($curl, array(
                 CURLOPT_URL => $this->parametros->ur2.'/'.$this->Workspaces->id_remoto.'/bank_slips',
                 CURLOPT_SSLCERTTYPE => 'P12',
                CURLOPT_SSLCERT => $this->parametros->certificado,
                CURLOPT_SSLCERTPASSWD =>  $this->parametros->senha,
                CURLOPT_RETURNTRANSFER => true,
              
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $jsonData,
                    CURLOPT_HTTPHEADER => array(
                        'X-Application-Key: '.$this->parametros->client_id,
                        'Content-Type: application/json',
                             'Authorization: Bearer '. $this->token
                    ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
               $response= json_decode($response);
   
 
        
        
            if(isset($response->digitableLine)){
        $objeto = CobrancaTitulo::find($this->titulos->id);
        if ($objeto) {
            $objeto->linhadigitavel =$response->digitableLine;
            $objeto->codigobarras =$response->barcode;
            $objeto->qrcode = $response->qrCodePix;
            $objeto->user_id= TSession::getValue('userid');
            $objeto->txid = $response->qrCodeUrl;
            $objeto->seunumero = $response->nsuCode;
            $objeto->status = 5;
            $objeto->store();
            
 

         // Código gerado pelo snippet: "Exibir mensagem"
        $mensagem = "<b>Boleto gerado com sucesso!</b><br>";
        $mensagem .= "Nosso número: {$objeto->seunumero}<br>";
        $mensagem .= "Cliente: {$this->pessoas->nome}<br>";
        $mensagem .= "Banco: {$this->parametros->apelido}<br>";
        $mensagem .= "Valor: {$this->titulos->valor}<br>";
        $mensagem .= "Vencimento: {$this->titulos->data_vencimento}<br>";
        $mensagem .= "Linhas Digitáveis: {$response->digitableLine}<br>";
        new TMessage('info', $mensagem);
        
//dd($response);

        }
        
        
        
            }

         // Feche a transação (a conexão será fechada automaticamente)
} catch (Exception $e) {
    // Lide com erros aqui
    TTransaction::rollback(); // Em caso de erro, faça rollback da transação
}
    }
}