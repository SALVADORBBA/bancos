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
class SicoobBoletoCreate
{
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $rateio;
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
  
       
 
    $this->rateio = RateioSicoob::where('parametros_bancos_id', '=', $this->titulos->parametros_bancos_id)->get();

    }

    /**
     * Função para criar um boleto Sicredi.
     */
    public function Getcreate()
    {
 
 
 
                $ultimoNumeros = new ControleMeuNumeroServices();
                $ultimoNumero = $ultimoNumeros->create($this->beneficiario->id, TSession::getValue('userunitid'),1);
                
            //   $ultimoNumero = $meunumero->numero;
                
                $TokenSicredi =GetTokenSicoob::create($this->parametros->id);
                
                        // Criar um novo objeto stdClass
                // Criar um novo objeto stdClass
             
 
            $headers = new stdClass();
            $headers->Accept = 'application/json';
            $headers->Content_Type = 'application/json';
            if(  $this->parametros->ambiente==2){
            
            
            $headers->Authorization = 'Bearer 1301865f-c6bc-38f3-9f49-666dbcfc59c3';
            $headers->client_id = '9b5e603e428cc477a2841e2683c92d21';
            }else{
            
            
            $headers->Authorization = 'Bearer '.$TokenSicredi ;
            $headers->client_id =$this->parametros->client_id;
            
            }


                // Criar um objeto stdClass com os dados do boleto
                        $boletoData = new stdClass();
                        $boletoData->numeroContrato =  (int) $this->parametros->numerocontrato;
                        $boletoData->modalidade = 1;
                        $boletoData->numeroContaCorrente = (int)  $this->parametros->numerocontacorrente;
                        $boletoData->especieDocumento = "DM";
                        $boletoData->dataEmissao =ClassGenerica::gerarData(date('Y-m-d H:i:s'),'-03:00');
                        //$boletoData->nossoNumero = 2588658;
                        $boletoData->seuNumero =  $ultimoNumero->numero;
                        $boletoData->identificacaoBoletoEmpresa =$this->parametros->identificacaoboletoempresa;
                         
                        $boletoData->identificacaoEmissaoBoleto = 2;// Código de identificação de emissão do boleto. 1: Banco Emite, 2: Cliente Emite
                        $boletoData->identificacaoDistribuicaoBoleto = 2;// Código de identificação de distribuição do boleto. 1: Banco Distribui, 2: Cliente Distribui
                        $boletoData->valor = (double) $this->titulos->valor;

                    $boletoData->dataVencimento = ClassGenerica::gerarData(($this->titulos->data_vencimento),'-03:00');
                    $boletoData->dataLimitePagamento =  ClassGenerica::gerarData(date('Y-m-d', strtotime('+' .$this->parametros->numerodiaslimiterecebimento . ' days', strtotime($this->titulos->data_vencimento))),'-03:00');
                    $boletoData->valorAbatimento = 1;
           
                $boletoData->tipoDesconto = (int) $this->parametros->tipodesconto;
                 if( $this->parametros->tipodesconto<>0){
                    
               
                    $boletoData->dataPrimeiroDesconto =ClassGenerica::gerarData(date('Y-m-d', strtotime('-' . $this->parametros->diasparadesconto_primeiro .
            ' days', strtotime($this->titulos->data_vencimento))),'-03:00');
                    $boletoData->valorPrimeiroDesconto =  (double) $this->parametros->valorprimeirodesconto;;
           }
           
           
          
                    $boletoData->tipoMulta = (int) $this->parametros->tipomulta;;
   if ($boletoData->tipoMulta <> 0) {
            // Se houver multa, adicione os dias de multa à data de vencimento
            $boletoData->dataMulta = ClassGenerica::gerarData(date('Y-m-d', strtotime('+' . $this->parametros->diasmultas . ' days', strtotime($this->titulos->data_vencimento))),'-03:00');
            $boletoData->valorMulta =  (double) $this->parametros->valormulta;
            }
          $boletoData->tipoJurosMora = (int) $this->parametros->tipojurosmora;
                // Tipo de juros de mora. Informar os valores listados abaixo.
                // 1 Valor Fixo
                // 2 Taxa Mensal
                // 3 Isento
                if ($boletoData->tipoJurosMora <> 3) {
                    $boletoData->dataJurosMora = ClassGenerica::gerarData(date('Y-m-d', strtotime('+' .$this->parametros->diasjurosmora . ' days', strtotime($this->titulos->data_vencimento))),'-03:00');

                    $boletoData->valorJurosMora = (double) $this->parametros->valorjurosmora;
                }
          
                    $boletoData->numeroParcela = 1;
                    $boletoData->aceite = true;
                    $boletoData->codigoNegativacao = 2;
                    $boletoData->numeroDiasNegativacao = 60;
                    $boletoData->codigoProtesto = 1;
                    $boletoData->numeroDiasProtesto = 30;
                    
        $boletoData->pagador = new stdClass();
                $boletoData->pagador->numeroCpfCnpj = $this->pessoas->cpf_cnpj;
                $boletoData->pagador->nome = $this->pessoas->nome;
                $boletoData->pagador->endereco = $this->pessoas->cobranca_endereco;
                $boletoData->pagador->bairro = $this->pessoas->cobranca_bairro;
                $boletoData->pagador->cidade = $this->pessoas->cobranca_cidade;
                $boletoData->pagador->cep = $this->pessoas->cobranca_cep;
                $boletoData->pagador->uf = $this->pessoas->cobranca_cidade;
                $boletoData->pagador->email = [$this->pessoas->email];
                $boletoData->mensagensInstrucao = new stdClass();
                $boletoData->mensagensInstrucao->tipoInstrucao = 1;
                $boletoData->mensagensInstrucao->mensagens = [
                    $this->parametros->info1,
                    $this->parametros->mens1,
                    $this->parametros->mens2,
                    $this->parametros->mens3,
                    $this->parametros->mens4
                ];

              
                    $boletoData->gerarPdf = false;
 
 
                
                        // Agora, $boletoData->rateioCreditos contém todos os objetos criados no loop foreach
                        $boletoData->codigoCadastrarPIX = 1;
                        $boletoData->numeroContratoCobranca = 1;
                                   
                    $jsonData = json_encode(array($boletoData));
                    
                    
             
 
                $headersArray = json_decode(json_encode($headers), true);
                 
                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL =>$this->parametros->url2,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>$jsonData,
                  CURLOPT_HTTPHEADER => array(
                'Content-Type: '.$headers->Content_Type ,
                'Authorization:'.$headers->Authorization  ,
                'Accept: '.$headers->Accept ,
                'client_id: '.$headers->client_id,)
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                 $response= json_decode($response);
                 
                 
                 
                $Cobranca = CobrancaTitulo::find($this->key);
                if ($Cobranca) {
                $Cobranca->status = 5;
                $Cobranca->seunumero =    $boletoData->seuNumero ;
                $Cobranca->nossonumero =$response->resultado[0]->boleto->nossoNumero ?? null;
                $Cobranca->qrcode= $response->resultado[0]->boleto->qrCode ?? null;
                $Cobranca->txid = $response->resultado[0]->qrCode->txId ?? null;
                $Cobranca->emv = $response->resultado[0]->boleto->pdfBoleto ?? null;
                $Cobranca->linhadigitavel = $response->resultado[0]->linhaDigitavel  ?? null;
                $Cobranca->codigobarras = $response->resultado[0]->codigoBarraNumerico  ?? null;
       
                $Cobranca->save();
                }
                
                
                
            $objeto_up_numero = ControleMeuNumeros::find($ultimoNumero->id);
            if ($objeto_up_numero) {
            $objeto_up_numero->status = 'uso';
            $objeto_up_numero->store();
            }
    
  $mensagem='<b>Boleto Banco do Sicoob</b> <br>'.    $boletoData->seuNumero .' <br><b>Numero:</b> '. $Cobranca->seunumero.'<br> <h5>Gerado com sucesso!<h5>';
                
              new TMessage('info', $mensagem);                
    }
}
