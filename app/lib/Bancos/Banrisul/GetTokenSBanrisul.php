<?php

class GetTokenSBanrisul
{
    private $key;
    private $parametros;
 
    /**
     * Construtor da classe GetTokenSBanrisul.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
        $this->key = $key;
        // Make sure ParametrosItau class and find method are defined
        $this->parametros = ParametrosBancos::find($this->key);
    }
  
    /**
     * Arquivo: GetTokenSBanrisul
     * Autor: Rubens do Santos
     * Contato: salvadorbba@gmail.com
     * Descrição: Descrição breve do propósito deste arquivo.
     *
     * @return string|false O token de acesso se a autenticação for bem-sucedida, caso contrário, uma mensagem de erro ou false em caso de falha.
     */
    public function create() {
      
 
        // URL de autenticação OAuth 2.0
        $authUrl =$this->parametros->url1;

        // Dados da solicitação para autenticação
        $data = array(
            'grant_type' => 'client_credentials',
            'client_id' =>  $this->parametros->client_id,
            'client_secret' => $this->parametros->client_secret,
            'scope' => 'boletos', // Adicione o escopo aqui
        );

        // Inicializar a sessão cURL para a autenticação
        $curl = curl_init();

        // Configurações da solicitação cURL para autenticação
        curl_setopt_array($curl, array(
            CURLOPT_URL => $authUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));

        // Executar a solicitação cURL para obter o token de acesso
        $response = curl_exec($curl);

        $response = json_decode($response);
    
 
        return $response->access_token; // Retorna o token de acesso obtido.
        

    }
}
