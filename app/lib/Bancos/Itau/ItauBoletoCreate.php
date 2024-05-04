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
class ItauBoletoCreate

{
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $token;
    private $Geratoken;
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
          
            $this->Geratoken = new GetTokenItau($this->parametros->id);
            $this->token=  $this->Geratoken->create();

    }

    /**
     * Função para criar um boleto Sicredi.
     */
    public function Getcreate()
    {
     
 try{
     
 

        $ultimoNumeros = new ControleMeuNumeroServices();
        $ultimoNumero = $ultimoNumeros->create($this->beneficiario->id, TSession::getValue('userunitid'),4);
 
        $meunumero = $ultimoNumero->numero+1;
        
 
        $data = new stdClass();

        $data->data = new stdClass();
        $data->data->etapa_processo_boleto =  $this->parametros->etapa_processo_boleto;
        $data->data->codigo_canal_operacao = "API";

        $data->data->beneficiario = new stdClass();
        $data->data->beneficiario->id_beneficiario =  $this->parametros->numerocontrato;

        $data->data->dado_boleto = new stdClass();
        $data->data->dado_boleto->descricao_instrumento_cobranca = "boleto";
        $data->data->dado_boleto->tipo_boleto = "a vista";
        $data->data->dado_boleto->codigo_carteira =   $this->parametros->carteira; /// carteira
        $data->data->dado_boleto->valor_total_titulo = ClassGenerica::formatarValorItau($this->titulos->valor);


        $data->data->dado_boleto->codigo_especie = "01";
        $data->data->dado_boleto->valor_abatimento =  ClassGenerica::formatarValorItau("000");
        $data->data->dado_boleto->data_emissao = date('Y-m-d');
        $data->data->dado_boleto->indicador_pagamento_parcial = true;
        $data->data->dado_boleto->quantidade_maximo_parcial = 0;




        $data->data->dado_boleto->pagador = new stdClass();
        $data->data->dado_boleto->pagador->pessoa = new stdClass();
        $data->data->dado_boleto->pagador->pessoa->nome_pessoa =  $this->pessoas->nome;
        $data->data->dado_boleto->pagador->pessoa->tipo_pessoa = new stdClass();
        if (strlen($this->pessoas->cpf_cnpj) === 14) {
            $data->data->dado_boleto->pagador->pessoa->tipo_pessoa->codigo_tipo_pessoa = "J";
            $data->data->dado_boleto->pagador->pessoa->tipo_pessoa->numero_cadastro_nacional_pessoa_juridica =  $this->pessoas->cpf_cnpj;
        } else {
            $data->data->dado_boleto->pagador->pessoa->tipo_pessoa->codigo_tipo_pessoa = "F";
            $data->data->dado_boleto->pagador->pessoa->tipo_pessoa->numero_cadastro_pessoa_fisica = $this->pessoas->cpf_cnpj;
        }



        $endereco = ClassGenerica::limitarTexto($this->pessoas->cobranca_endereco, 38) .', '. ClassGenerica::limitarTexto( $this->pessoas->cobranca_numero, 5);

        $data->data->dado_boleto->pagador->endereco = new stdClass();
        $data->data->dado_boleto->pagador->endereco->nome_logradouro = $endereco;
        $data->data->dado_boleto->pagador->endereco->nome_bairro = $this->pessoas->cobranca_bairro;
        $data->data->dado_boleto->pagador->endereco->nome_cidade =  $this->pessoas->cobranca_cidade;
        $data->data->dado_boleto->pagador->endereco->sigla_UF =  $this->pessoas->cobranca_uf;
        $data->data->dado_boleto->pagador->endereco->numero_CEP =  $this->pessoas->cobranca_cep;
 

        $data->data->dado_boleto->dados_individuais_boleto = array();
        $dados_individuais_boleto = new stdClass();
        $dados_individuais_boleto->numero_nosso_numero =  $meunumero;
        $dados_individuais_boleto->data_vencimento =$this->titulos->data_vencimento;
        $dados_individuais_boleto->valor_titulo = ClassGenerica::formatarValorItau($this->titulos->valor);
        $dados_individuais_boleto->texto_uso_beneficiario = "2";
        $dados_individuais_boleto->texto_seu_numero = "2";
        $data->data->dado_boleto->dados_individuais_boleto[] = $dados_individuais_boleto;


        $data->data->dado_boleto->instrucao_cobranca = array();
        $instrucao_cobranca = new stdClass();
        $instrucao_cobranca->codigo_instrucao_cobranca = "4";

        $data->data->dado_boleto->desconto_expresso = false;


        $x_itau_correlationID = ClassGenerica::CreateUuid(1);
        $x_itau_flowID = ClassGenerica::CreateUuid(2);
   dd($data);
   
   exit;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->parametros->url2,
            CURLOPT_SSLCERTTYPE => 'P12',
            CURLOPT_SSLCERT => $this->parametros->certificado,
            CURLOPT_SSLCERTPASSWD => $this->parametros->senha,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'x-itau-apikey: ' . $this->parametros->client_id,
                'x-itau-correlationID: ' .   $x_itau_correlationID,
                'x-itau-flowID: ' . $x_itau_flowID,
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->token,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
                 
                 if($response->codigo>=400){
                 
                   $titulo='Titulo: '.$response->mensagem;
                   $codigo=' Código: '.$response->codigo.'<hr>';
                    foreach( $response->campos as $lista){
                   
                    $mensagem .= "<br>Local: " .'<b>'. $lista->campo .  "</b><br>";
                    $mensagem .= "  Mensagem: " .'<b>'.  $lista->mensagem .  "</b><br>";
                 
                     
                     
                     
                 }
                 
 
  
            new TMessage('erro', $codigo.''. $titulo.' <br>'.$mensagem);
            
            return;
            }
            

 
 
        if (isset($response->data->dado_boleto->dados_individuais_boleto[0]->numero_linha_digitavel)) {
            $resultado = $response->data->dado_boleto->dados_individuais_boleto[0];
      
      
      
        $objeto_up_numero = ControleMeuNumeros::find($ultimoNumero->id);
        if ($objeto_up_numero) {
            $objeto_up_numero->status = 'uso';
            $objeto_up_numero->store();
        }


            ################Salvar o evento no banco de dados####################
            $evento = new EventosBoletos();
            // Preencher os campos do evento
            $evento->linhadigitavel = $resultado->numero_linha_digitavel;
            $evento->codigobarras = $resultado->codigo_barras;
            $evento->parametros_bancos_id =  $this->parametros->id;
            $evento->cobranca_titulo_id = $this->key;
            $evento->seunumero =$meunumero;
            $evento->numerocarteira = 109;
            $evento->numerocontratocobranca = $data->data->beneficiario->id_beneficiario;
            $evento->mensagem = 'Boleto Gerado com sucesso enviado para Banco do Itau';
            $evento->codigo = 200;

            $evento->save();

            $mensagemPadrao = $evento->mensagem;
            $Cobranca = CobrancaTitulo::find( $this->titulos->id);
            if ($Cobranca) {
                $Cobranca->status = 5;
                $Cobranca->seunumero = $meunumero;
                $Cobranca->linhadigitavel = $resultado->numero_linha_digitavel;
                $Cobranca->codigobarras =  $resultado->codigo_barras;
                $Cobranca->modelo = 1;
                $Cobranca->numero_generico_1 = $x_itau_correlationID;
                $Cobranca->numero_generico_2 =  $x_itau_flowID;
                $Cobranca->ambiente_emissao =    $data->data->etapa_processo_boleto;
                $Cobranca->save();
            }

 
 
        new TMessage('info',     $evento->mensagem);
    


        }
 

   
          
         // Feche a transação (a conexão será fechada automaticamente)
} catch (Exception $e) {
    // Lide com erros aqui
    TTransaction::rollback(); // Em caso de erro, faça rollback da transação
}
    }
}
