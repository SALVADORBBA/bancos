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
class BancoBrasilBoletoCreate

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
          
            $this->Geratoken = new GetTokenBancoBrasil($this->parametros->id);
            $this->token=  $this->Geratoken->create();
            
                  
       
    }

    /**
     * Função para criar um boleto Sicredi.
     */
    public function Getcreate()
    {
     
 try{
    
 
     

            $dados = new stdClass();
            $dados->numeroConvenio = $this->parametros->numeroconvenio; //long
            $dados->dataVencimento = ClassGenerica::CVDataBB($this->titulos->data_vencimento); ///Qualquer data maior ou igual que a data de emissão, no formato “dd.mm.aaaa”.
            $dados->valorOriginal = $this->titulos->valor;
            $dados->numeroCarteira = $this->parametros->carteira;
            $dados->numeroVariacaoCarteira = $this->parametros->numerovariacaocarteira;
          //  $dados->codigoModalidade =  $this->titulos->modalidade;
            $dados->dataEmissao = ClassGenerica::CVDataBB(date('Y-m-d'));
            
        if(!isset($this->titulos->data_vencimento)){
            
            // Código gerado pelo snippet: "Exibir mensagem"
                new TMessage('info', "Boleto sem Data de Vencimento");
                // -----
                return;

        }
        
                    $ultimoNumeros = new ControleMeuNumeroServices();
                    $ultimoNumero = $ultimoNumeros->create($this->beneficiario->id, TSession::getValue('userunitid'),7);
                    $numero_agregado = str_pad( $ultimoNumero->numero, 9, '0', STR_PAD_LEFT);
   
 
            if ( $this->titulos->abatimento == 1) {
                $dados->valorAbatimento = $this->titulos->valorabatimento; //Define o valor a ser concedido como abatimento.
            } else {
                unset($dados->valorAbatimento);
            }
            if ( $this->titulos->numerodiasprotesto == 1) {
                $dados->quantidadeDiasProtesto = $this->titulos->numerodiasprotesto;

                /**
                 * Quantidade de dias após a data de vencimento do boleto para iniciar
                 * o processo de cobrança através de protesto. (3 a 5 dias úteis ou 6 a 29, 35, 40 ou 45 dias corridos)
                 */
            } else {
                unset($dados->quantidadeDiasProtesto);
            }

            if ( $this->titulos->numerodiasnegativacao === 1) {
                $dados->quantidadeDiasNegativacao =  $this->titulos->numerodiasnegativacao;
                $dados->orgaoNegativador =  $this->titulos->orgaonegativador;

            } else {

                unset($dados->quantidadeDiasNegativacao);
                unset($dados->orgaoNegativador);

            } 
 
            $dados->indicadorAceiteTituloVencido =  $this->parametros->indicadoraceitetitulovencido; //Indicador de que o boleto pode ou não ser recebido após o vencimento.
            $dados->numeroDiasLimiteRecebimento =  $this->parametros->numerodiaslimiterecebimento; //Quantidade de dias corridos para recebimento após o vencimento.
            $dados->codigoAceite =    $this->parametros->codigoaceite;
            $dados->codigoTipoTitulo = 2; //Código para identificar o tipo de boleto de cobrança. Verifique os domínios possíveis no swagger.
            $dados->descricaoTipoTitulo = $this->parametros->tipos_documentos; ///string
            $dados->indicadorPermissaoRecebimentoParcial = "N"; //Código para identificação da autorização de pagamento parcial do boleto.    S ou N
            $dados->numeroTituloBeneficiario = $numero_agregado;
            //Número de identificação do boleto (equivalente ao SEU NÚMERO), no formato String, limitado a 15 caracteres, podendo aceitar letras (maiúsculas).

            $numeroConvenio = $this->parametros->numeroconvenio;
            $numeroControle = $dados->numeroTituloBeneficiario;

            $mensagemBloquetoOcorrencia =
            ClassGenerica::limitarTexto( $this->titulos->mens1, 55)
            . ClassGenerica::limitarTexto( $this->titulos->mens2, 55)
            . ClassGenerica::limitarTexto( $this->titulos->mens3, 55);

            $dados->campoUtilizacaoBeneficiario = 0;

            ////sumerico importante cuidado ao manipular
            $dados->numeroTituloCliente = (string) "000{$numeroConvenio}1{$numero_agregado}";
            $dados->mensagemBloquetoOcorrencia = $mensagemBloquetoOcorrencia;

            $dados->desconto = new stdClass();
            $dados->desconto->tipo = (int)  $this->titulos->tipodesconto;

            $dados->segundoDesconto = new stdClass();
            if ($dados->desconto->tipo == 1) {
                $dados->desconto->dataExpiracao = date('d.m.Y', strtotime('-' .  $this->titulos->diasparadesconto_primeiro . ' days', strtotime( $this->titulos->data_vencimento)));
                $dados->desconto->valor =  $this->titulos->valorprimeirodesconto;

                if ($dados->desconto->tipo == 1) {
                    if ( $this->titulos->valorSegundoDesconto >= 1) {
                        $dados->segundoDesconto->dataExpiracao = date('d.m.Y', strtotime('-' .  $this->titulos->diasparadesconto_segundo . ' days', strtotime( $this->titulos->data_vencimento)));
                        $dados->segundoDesconto->valor =  $this->titulos->valorSegundoDesconto;
                    }
                    if ( $this->titulos->diasparadesconto_terceiro >= 1 &&  $this->titulos->valorSegundoDesconto >= 1) {
                        $dados->terceiroDesconto = new stdClass();
                        $dados->terceiroDesconto->dataExpiracao = date('d.m.Y', strtotime('-' .  $this->titulos->diasparadesconto_terceiro . ' days', strtotime( $this->titulos->data_vencimento)));
                        $dados->terceiroDesconto->valor =  $this->titulos->valorTerceiroDesconto;
                    } else {

                        unset($dados->terceiroDesconto->dataExpiracao);
                        unset($dados->terceiroDesconto->valor);

                    }
                } else {
                    unset($dados->desconto->dataExpiracao);
                    unset($dados->desconto->valor);
                    unset($dados->segundoDesconto);
                }

                if ($dados->desconto->tipo == 2) {
                    $dados->desconto->dataExpiracao = date('d.m.Y', strtotime('-' .  $this->titulos->diasparadesconto_primeiro . ' days', strtotime( $this->titulos->data_vencimento)));
                    $dados->desconto->porcentagem =  $this->titulos->valorprimeirodesconto;
                    $dados->segundoDesconto->dataExpiracao = date('d.m.Y', strtotime('-' .  $this->titulos->diasparadesconto_segundo . ' days', strtotime( $this->titulos->data_vencimento)));
                    $dados->segundoDesconto->porcentagem =  $this->titulos->valorSegundoDesconto;

                    if ( $this->titulos->diasparadesconto_terceiro >= 1 &&  $this->titulos->valorSegundoDesconto >= 1) {
                        $dados->terceiroDesconto = new stdClass();
                        $dados->terceiroDesconto->dataExpiracao = date('d.m.Y', strtotime('-' .  $this->titulos->diasparadesconto_terceiro . ' days', strtotime( $this->titulos->data_vencimento)));
                        $dados->terceiroDesconto->porcentagem =  $this->titulos->valorTerceiroDesconto;
                    }
                } else {
                    unset($dados->desconto->dataExpiracao);
                    unset($dados->desconto->porcentagem);
                    unset($dados->segundoDesconto);
                    unset($dados->desconto->tipo);
                }
            }
            
      
            $dados->jurosMora = new stdClass();
            $dados->jurosMora->tipo = (int)  $this->titulos->tipojurosmora;
            if ( $this->titulos->tipojurosmora == 1) {

                $dados->jurosMora->valor =  $this->titulos->valorjurosmora;

            } else {
                unset($dados->jurosMora->valor);

            }

            if ( $this->titulos->tipojurosmora == 2) {

                $dados->jurosMora->porcentagem =  $this->titulos->valorjurosmora;

            } else {
                unset($dados->jurosMora->valor);

            }

            $dados->multa = new stdClass();
            $dados->multa->tipo =  $this->titulos->tipomulta;
            if ($dados->multa->tipo == 1) {

                $dados->multa->data = date('d.m.Y', strtotime('+' .  $this->titulos->diasmultas . ' days', strtotime( $this->titulos->data_vencimento)));
                $dados->multa->valor =  $this->titulos->valormulta;

            } else {
                unset($dados->multa->data);
                unset($dados->multa->porcentagem);

            }
            if ($dados->multa->tipo == 2) {

                $dados->multa->data = date('d.m.Y', strtotime('+' .  $this->titulos->diasmultas . ' days', strtotime( $this->titulos->data_vencimento)));
                $dados->multa->porcentagem =  $this->titulos->valormulta;

            } else {
                unset($dados->multa->data);
                unset($dados->multa->porcentagem);

            }

            $dados->pagador = new stdClass();

            if (strlen($this->pessoas->cpf_cnpj) === 11) {
                $dados->pagador->tipoInscricao = 1; //Domínio: 1 - Pessoa física; 2 - Pessoa Jurídica

            } else {
                $dados->pagador->tipoInscricao = 2; // Domínio: 1 - Pessoa física; 2 - Pessoa Jurídica
            }
 
        
            $dados->pagador->numeroInscricao =  $this->pessoas->cpf_cnpj;
            $dados->pagador->nome =   $this->pessoas->nome;
            $dados->pagador->endereco =   $this->pessoas->cobranca_endereco;
            $dados->pagador->cep =  $this->pessoas->cobranca_cep;
            $dados->pagador->cidade =  $this->pessoas->cobranca_cidade;
            $dados->pagador->bairro =   $this->pessoas->cobranca_bairro;
            $dados->pagador->uf =  $this->pessoas->cobranca_uf;
            $dados->pagador->telefone =   $this->pessoas->telefone;
 
            $dados->beneficiarioFinal = new stdClass();

            if (strlen($this->beneficiario->cnpj) === 14) {
                $dados->beneficiarioFinal->tipoInscricao = 2; // Domínio: 1 - Pessoa física; 2 - Pessoa Jurídica

            } else {
                $dados->beneficiarioFinal->tipoInscricao = 1; //Domínio: 1 - Pessoa física; 2 - Pessoa Jurídica

            }
            $dados->beneficiarioFinal->numeroInscricao =  $this->beneficiario->cnpj;
            $dados->beneficiarioFinal->nome =   $this->beneficiario->nome;

            $dados->indicadorPix = "S";
 
            $json = json_encode($dados);

            $curl = curl_init();
//dd($this->parametros->url2.'?gw-dev-app-key=' .  $this->parametros->gw_dev_app_key); exit;
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->parametros->url2.'?gw-dev-app-key=' .  $this->parametros->gw_dev_app_key,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $json,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer ' . $this->token,

                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response);
            
            

   
          $responseObj =$response;

if (isset($responseObj->erros) && is_array($responseObj->erros) && count($responseObj->erros) > 0) {
    $mensagens = [];

    // Iterar sobre os erros e adicionar números de índice
    foreach ($responseObj->erros as $indice => $erro) {
        // Personalize a mensagem conforme necessário
        $mensagemErro = sprintf("<b>Erro:  %d</b><br> <b>Código: </b> %s <br> <b>Ocorrência: </b> %s <h5><b> %s</h5> ",
            $indice + 1, // Adicionando 1 para começar do índice 1
            $erro->codigo,
            $erro->ocorrencia,
            $erro->mensagem,
            $erro->versao
        );

        $mensagens[] = $mensagemErro;
    }

    $mensagemFinal = "<b>Foram encontrados os seguintes erros:</b><br> " . implode("<br>", $mensagens);


if($responseObj->erros){
    // Agora você pode exibir $mensagemFinal onde necessário no Adianti Framework
 
    
    // Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', $mensagemFinal);
        // -----

 
    
    
}
    
    
    
    
    
} else {
    // Caso não haja erros, exiba uma mensagem padrão ou tome outra ação adequada.
  
                
                $Cobranca = CobrancaTitulo::find($this->key);
                if ($Cobranca) {
                $Cobranca->status = 5;
                $Cobranca->seunumero = $response->numero;
                $Cobranca->url_bb = $response->qrCode->url;
                $Cobranca->txid = $response->qrCode->txId;
                $Cobranca->emv = $response->qrCode->emv;
                $Cobranca->linhadigitavel = $response->linhaDigitavel;
                $Cobranca->codigobarras = $response->codigoBarraNumerico;
                $Cobranca->modelo = 2;
                $Cobranca->save();
                }
                
                
                
            $objeto_up_numero = ControleMeuNumeros::find($ultimoNumero->id);
            if ($objeto_up_numero) {
            $objeto_up_numero->status = 'uso';
            $objeto_up_numero->store();
            }
    
    $mensagem='<b>Boleto Banco do Brasil</b> <br>'.$Cobranca->linhadigitavel.' <br><b>Numero:</b> '. $Cobranca->seunumero.'<br> <h5>Gerado com sucesso!<h5>';
        // Exibir a mensagem
    new TMessage('info', $mensagem);
    
    
    //dd( $response );
}
         // Feche a transação (a conexão será fechada automaticamente)
} catch (Exception $e) {
    // Lide com erros aqui
    TTransaction::rollback(); // Em caso de erro, faça rollback da transação
}
    }
}
