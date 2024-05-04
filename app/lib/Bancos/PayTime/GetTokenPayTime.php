<?php

use Adianti\Database\TTransaction;
use Adianti\Database\TRepository;

class GetTokenPOSControle
{
    private $key; // Chave usada para identificar o emitente
    private $token; // Armazena o token JWT
    private $expiration_time; // Armazena o tempo de expiração do token
    private static $database = 'erp_nuvem'; // Nome do banco de dados

    public function __construct($key)
    {
        $this->key = $key;
        $this->token = null;
        $this->expiration_time = null;
    }

    /**
     * Arquivo: GetTokenPOSControle
     * Autor: Rubens do Santos
     * Contato: salvadorbba@gmail.com
     * Descrição: Descrição breve do propósito deste arquivo.
     *
     * @return string|false O token de acesso se a autenticação for bem-sucedida, caso contrário, uma mensagem de erro ou false em caso de falha.
     */
    public function create()
    {
        try {
            TTransaction::open(self::$database); // Abre uma transação com o banco de dados

            // Consulta o banco de dados para verificar se já existe um token
            $emitente = Emitente::find($this->key);

            // Verifica se o token existente ainda é válido
            if ($emitente->token && strtotime($emitente->data_token) > time()) {
                // Se ainda é válido, retorna o token existente
                $tokens= new stdClass();
                $tokens->codigo  =  200; // Código de sucesso
                $tokens->data_token   =$emitente->data_token; // Data de expiração do token
                $tokens->token=$emitente->token; // Token JWT
                $this->token =  $tokens;
                $tokens->origem  =  'Origem Banco de Dados'; // Origem do token (banco de dados)
                $this->expiration_time = strtotime($emitente->data_token);
            } else {
                // Se o token expirou ou não existe, gera um novo token
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $emitente->curlopt_url, // URL para solicitar o token
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'username=' . $emitente->username . '&password=' . $emitente->password, // Dados de autenticação
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Ocp-Apim-Subscription-Key: ' . $emitente->subscription_key // Chave de assinatura da API
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $response = json_decode($response);
        
                // Salva o token JWT no banco de dados
                $emitente->token = $response->jwt;
                $emitente->data_token = date('Y-m-d H:i:s', time() + 45 * 60); // Adiciona 45 minutos à data atual
                $emitente->store(); // Salva no banco de dados

                $tokens= new stdClass();
                $tokens->codigo  =  201; // Código de sucesso na criação do token
                $tokens->data_token   = $emitente->data_token; // Data de expiração do novo token
                $tokens->token = $response->jwt; // Novo token JWT
                $this->token =  $tokens;
                $tokens->origem =  'Origem API Pos-Controle'; // Origem do token (API Pos-Controle)
                $this->expiration_time = time() + 45 * 60; // Adiciona 45 minutos ao tempo atual
            }

            TTransaction::close(); // Fecha a transação com o banco de dados

            return $this->token; // Retorna o token JWT
        } catch (Exception $e) {
            // Se ocorrer algum erro, rollback na transação e relança a exceção
            TTransaction::rollback();
            throw $e;
        }
    }
}
