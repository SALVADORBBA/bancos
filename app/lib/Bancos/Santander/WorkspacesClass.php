<?php

class WorkspacesClass  
{
    private $key;
    private $parametros;
     private $token;
      private $GetToken;
      
      private  $work_id;
    /**
     * Construtor da classe GetTokenSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key,$work_id=null) {
        $this->key = $key;
         $this->work_id = $work_id;
        // Make sure ParametrosItau class and find method are defined
        $this->parametros = ParametrosBancos::find($this->key);
        
          
     $gera= new GetTokenSantander($this->key);
     
     $this->token= $gera->GetToken();
    }
 
    /**
     * Arquivo: GetTokenItau
     * Autor: Rubens do Santos
     * Contato: salvadorbba@gmail.com
     * Descrição: Descrição breve do propósito deste arquivo.
     *
     * @return string|false O token de acesso se a autenticação for bem-sucedida, caso contrário, uma mensagem de erro ou false em caso de falha.
     */
    public function works() {
      
 
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://trust-sandbox.api.santander.com.br/collection_bill_management/v2/workspaces',
                CURLOPT_SSLCERTTYPE => 'P12',
                CURLOPT_SSLCERT => $this->parametros->certificado,
                CURLOPT_SSLCERTPASSWD =>  $this->parametros->senha,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                'X-Application-Key: LtpG1UvxpEDTmhinxSSI2RQ2wIG7wbAp',
                'Authorization: Bearer '. $this->token
                 ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
                    $response= json_decode($response);
foreach ($response->content as $listagem) {
    // Verifica se o registro já existe no banco de dados
 

    $existingRecord = WorkspacesSantander::where('id_remoto', '=', $listagem->id)->first();

    if (!$existingRecord) {
        // O registro não existe, então podemos inseri-lo
        $objeto = new WorkspacesSantander();
        $objeto->id_remoto = $listagem->id;
        $objeto->status = $listagem->status;
        $objeto->type = $listagem->type;
        $objeto->description = $listagem->description;
        $objeto->covenant_code = $listagem->covenants[0]->code;
        $objeto->bank_slip_billing_webhook_active = $listagem->bankSlipBillingWebhookActive;
        $objeto->pix_billing_webhook_active = $listagem->pixBillingWebhookActive;
        $objeto->parametros_bancos_id = $this->key;
        
              $objeto->webhookurl = $listagem->webhookURL ?? null;
        $objeto->store();

        $resultado[] = $objeto;
    } else {
        // O registro já existe, você pode lidar com isso conforme necessário
        // Por exemplo, você pode atualizar o registro existente ou apenas ignorá-lo
        // Exemplo de atualização: $existingRecord->update([...]);
    }
}

      
               return  $resultado; 

    
    } 
    
    
    
    
    
    
    
    
   public function create() {
      

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://trust-sandbox.api.santander.com.br/collection_bill_management/v2/workspaces',
      CURLOPT_SSLCERTTYPE => 'P12',
                CURLOPT_SSLCERT => $this->parametros->certificado,
                CURLOPT_SSLCERTPASSWD =>  $this->parametros->senha,
                CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "type": "BILLING",
    "covenants": [
        {
            "code": 3867207
        }
    ],
    "description": "DeveloperAPI",
    "bankSlipBillingWebhookActive": true,
    "pixBillingWebhookActive": true,
    "webhookURL": "https://developerapi.com.br/webhooks/public/api/santander"
}


',
  CURLOPT_HTTPHEADER => array(
    'X-Application-Key: LtpG1UvxpEDTmhinxSSI2RQ2wIG7wbAp',
    'Content-Type: application/json',
       'Authorization: Bearer '. $this->token
  ),
));

$response = curl_exec($curl);

 
   

     curl_close($curl);
    $response= json_decode($response);
 
    $objeto = WorkspacesSantander::find($this->work_id );
    
    $objeto->id_remoto = $response->id;
    $objeto->type = $response->type;
    $objeto->description = $response->description;
    $objeto->covenant_code = $response->covenants[0]->code;
    $objeto->bank_slip_billing_webhook_active = $response->bankSlipBillingWebhookActive;
    $objeto->pix_billing_webhook_active = $response->pixBillingWebhookActive;
    $objeto->parametros_bancos_id = $this->key;
    
    $objeto->webhookurl = $response->webhookURL ?? null;
    $objeto->store();


   }
    
}