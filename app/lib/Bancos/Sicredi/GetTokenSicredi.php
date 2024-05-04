<?php

/**
 * Classe GetTokenSicredi para obtenção de token de autenticação do Sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class GetTokenSicredi {
    private $key;
    private $parametros;
    private static $database = 'conecatarbanco';
    /**
     * Construtor da classe GetTokenSicredi.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
        $this->key = $key;
    }

    /**
     * Função para criar e obter um token de autenticação do Sicredi.
     *
     * @return string - O token de acesso obtido.
     */
    public function create() {
   

        // Buscar os parâmetros do banco de dados com base na chave.
        $this->parametros = ParametrosBancos::find($this->key);
  
        // // Extrair informações dos parâmetros obtidos.
        // $client_id = $this->parametros->client_id;
        // $username = $this->parametros->username;
        // $password = $this->parametros->password;
        // $scope = $this->parametros->scope;
        // $grant_type = "password";

        // Compor a URL com os parâmetros necessários.
        $url_Composicao = "username={$this->parametros->username}&password={$this->parametros->password}&scope={$this->parametros->scope}&grant_type=password";
 
        // Inicializar uma requisição CURL.
        $curl = curl_init();

        // Configurar as opções da requisição CURL.
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->parametros->url1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $url_Composicao,
            CURLOPT_HTTPHEADER => array(
                'ContentType: application/x-www-form-urlencoded',
                'x-api-key: ' . $this->parametros->client_id,
                'context: COBRANCA'
            ),
        ));

        // Executar a requisição CURL e obter a resposta.
        $response = curl_exec($curl);

        // Encerrar a requisição CURL.
        curl_close($curl);

        // Decodificar a resposta JSON.
        $response = json_decode($response);

        // Retornar o token de acesso obtido.
        return  $response->access_token;
    }
}
