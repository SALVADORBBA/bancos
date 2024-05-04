<?php

/**
 * Classe GetTokenBradesco para obtenção de token de autenticação do GetTokenBradesco.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class GetTokenBradesco {
    private $key;
    private $parametros;
    private static $database = 'conecatarbanco';
    /**
     * Construtor da classe GetTokenBradesco.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key) {
        $this->key = $key;
        
           // Buscar os parâmetros do banco de dados com base na chave.
        $this->parametros = ParametrosBancos::find($this->key);
    }

    /**
     * Função para criar e obter um token de autenticação do GetTokenBradesco.
     *
     * @return string - O token de acesso obtido.
     */
    public function create() {
   

     
  
 
    }
}
