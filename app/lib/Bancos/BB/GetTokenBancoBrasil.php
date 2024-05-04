<?php

/**
 * Classe GetTokenBancoBrasil para obtenção ou renovação de tokens de acesso no Banco do Brasil.
 */
class GetTokenBancoBrasil
{
    private $key;
    private $parametros;

    /**
    * Construtor da classe GetTokenBancoBrasil.
    * Autor: Rubens dos Santos
    * Email: salvadorbba@gmail.com
    * Celular: (12) 99675-8056
    * Construtor da classe SicrediBoletoCreate.
    * @param string $key - A chave para buscar os parâmetros no banco de dados.
    */
    public function __construct($key)
    {
        $this->key = $key;
        // Certifique-se de que a classe ParametrosBancos e o método find estão definidos
        $this->parametros = ParametrosBancos::find($this->key);
    }

    /**
     * Obtém ou renova o token de acesso.
     *
     * @return string|null O token de acesso se a autenticação for bem-sucedida, caso contrário, null em caso de falha.
     */
    public function create()
    {
        // Inicia a sessão, se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            TSession::start();
        }

        // Verificar se já existe uma sessão ativa
        if (TSession::getValue('token') && TSession::getValue('expiracao') > time()) {
            // Ainda há uma sessão ativa, retornar o token existente
            return TSession::getValue('token');
        } else {
            // Verificar se o token expirou ou está prestes a expirar (10 segundos de margem)
            if (TSession::getValue('expiracao') > time() - 10) {
                // Token ainda é válido ou está prestes a expirar, retornar o token existente
                return TSession::getValue('token');
            } else {
                $curl = curl_init();
 
                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  $this->parametros->url1.'?gw-dev-app-key=' . $this->parametros->gw_dev_app_key,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=cobrancas.boletos-info%20cobrancas.boletos-requisicao',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $this->parametros->authorization,
                        'Content-Type: application/x-www-form-urlencoded',
                    ),
                ));

                $response = curl_exec($curl);

                // Validação do retorno
                $response = json_decode($response);
                curl_close($curl);

                if (isset($response->access_token)) {
                    // Atualiza as variáveis de sessão
                    TSession::setValue('token', $response->access_token);
                    TSession::setValue('expiracao', time() + ($response->expires_in - 600)); // Definir expiração em 10 minutos

                    return $response->access_token;
                } else {
                    // Não foi possível obter o token
                    return null;
                }
            }
        }
    }
}
