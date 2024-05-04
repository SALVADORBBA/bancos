<?php

/**
 * Classe MultClassCEF para interação com serviços web da Caixa Econômica Federal.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 */
class MultClassCEF //    IncluirBoleto
{
  // Propriedades da classe  MultClassCEF    ConsultarBoleto
  private $key;
  private $parametros;
  private $titulos;
  private $beneficiario;
  private $pessoas;
  private $GetToken;
  private $token;
  private $meunumero;
  private static $database = 'conecatarbanco';

  /**
   * Construtor da classe MultClassCEF.
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


    $ultimoNumeros = new GeraMeuNumero();
    $this->meunumero = $ultimoNumeros->createCEF($this->beneficiario->id, TSession::getValue('userunitid'), 7);
  }


  public function IncluirBoleto()
  {
    try {
 
if( $this->titulos->status<>5){

      if ($this->parametros->valorabatimento) {
        $abatimento =  CalculosTaxasBanrisul::adicionarModificador($this->titulos->valor, ['tipo' => 'desconto', 'valor' => $this->parametros->valorabatimento]);
        $Valor_abatimento = $abatimento;
      } else {
        $Valor_abatimento = 0;
      }


      $boleto = new BoletoCEF();
      $boleto->setCodigoBeneficiario($this->parametros->numerocontrato);
      $boleto->setUnidade($this->parametros->unidade);
      $boleto->setIdProcesso($this->parametros->numerocontrato);
      $boleto->setCnpj($this->beneficiario->cnpj);
      $boleto->setNossoNumero($this->meunumero->numero);
      $boleto->setNumeroDocumento($this->titulos->identificador ?? $this->titulos->id);
      $boleto->setDataVencimento($this->titulos->data_vencimento);
      $boleto->setValor($this->titulos->valor);
      $boleto->setTipoEspecie('02');
      $boleto->setFlagAceite('N');
      $boleto->setDataEmissao(date('Y-m-d'));
      $boleto->setValorAbatimento($Valor_abatimento);
      $boleto->setNumeroDias($this->parametros->baixar_devolver_prazo);
      $boleto->setCpf($this->pessoas->cpf_cnpj);
      $boleto->setNome($this->pessoas->nome);
      $boleto->setLogradouro($this->pessoas->cobranca_endereco . ' Nº ' . $this->pessoas->cobranca_numero);
      $boleto->setCidade($this->pessoas->cobranca_cidade);
      $boleto->setUf($this->pessoas->cobranca_uf);
      $boleto->setCep($this->pessoas->cobranca_cep);

      $resultado = $boleto->incluirBoleto();





      if ($resultado['COD_RETORNO'] == 0) {

        $objeto = CobrancaTitulo::find($this->titulos->id);
        if ($objeto) {
          $objeto->linhadigitavel = $resultado['LINHA_DIGITAVEL'];
          $objeto->codigobarras = $resultado['CODIGO_BARRAS'];
          $objeto->qrcode = $resultado['qrCodePix'];
          $objeto->user_id = TSession::getValue('userid');
          $objeto->caminho_boleto = $resultado['URL'];
          $objeto->seunumero = $this->meunumero->numero;
          $objeto->status = 5;
          $objeto->store();


          $objeto_up_numero = ControleMeuNumeros::find($this->meunumero->id);
          if ($objeto_up_numero) {
            $objeto_up_numero->status = 'uso';
            $objeto_up_numero->store();
          }

          // Exibir mensagem de sucesso
          $mensagem = "<b>Boleto gerado com sucesso!</b><br>";
          $mensagem .= "Nosso número: {$objeto->seunumero}<br>";
          $mensagem .= "Cliente: {$this->pessoas->nome}<br>";
          $mensagem .= "Banco: {$this->parametros->apelido}<br>";
          $mensagem .= "Valor: {$this->titulos->valor}<br>";
          $mensagem .= "Vencimento: {$this->titulos->data_vencimento}<br>";
          $mensagem .= "Linhas Digitáveis: {$objeto->linhadigitavel}<br>"; // Supondo que digitableLine está dentro de $resultado
          new TMessage('info', $mensagem);
        }
      } else {


        $retorno = $resultado['RETORNO'];

        $mensagem = "<b>Erro ao Gerar Boleto</b><br>";
        $mensagem .= "Mensagem: {$retorno} <br>";

        // Supondo que digitableLine está dentro de $resultado
        new TMessage('info', $mensagem);
      }}else{
          
          
            new TMessage('info', 'Boleto gerado anteriomente');
          
      }
    } catch (Exception $e) {
      // Lidar com erros aqui
      TTransaction::rollback(); // Em caso de erro, faça rollback da transação
    }
  }

  /**
   * Função para alteração de um título existente.
   */
  public function AlterarBoleto()
  {


    try {



      $boleto = new BoletoCEF();

      $boleto->setCodigoBeneficiario($this->parametros->numerocontrato);
      $boleto->setCnpj($this->beneficiario->cnpj);
      $boleto->setNossoNumero($this->titulos->seunumero);
      $boleto->setDataVencimento($this->titulos->data_vencimento); //alterando data de vencimento
      $boleto->setValor($this->titulos->valor);
      $boleto->setTipoEspecie('02');
      $boleto->setFlagAceite('N');
      $boleto->setValorAbatimento('0');
      $boleto->setNumeroDias('30');
      $boleto->setNome($this->pessoas->nome);
      $boleto->setLogradouro($this->pessoas->cobranca_endereco . ' ' . $this->pessoas->cobranca_numero);
      $boleto->setCidade($this->pessoas->cobranca_cidade);
      $boleto->setUf($this->pessoas->cobranca_uf);
      $boleto->setCep($this->pessoas->cobranca_cep);
      $response = $boleto->alterarBoleto();



      return   $response;
    } catch (Exception $e) {
      // Lidar com erros aqui
      TTransaction::rollback(); // Em caso de erro, faça rollback da transação
    }
  }

  /**
   * Função para baixa de um título.
   */
  public function BaixarBoleto()
  {
    try {
      $boleto = new BoletoCEF();
      $boleto->setCodigoBeneficiario($this->parametros->numerocontrato);
      $boleto->setNossoNumero($this->titulos->seunumero);
      $boleto->setCnpj($this->beneficiario->cnpj);
      $response = $boleto->baixaBoleto();;

      if ($response['COD_RETORNO'] == 0) {


        $objeto = CobrancaTitulo::find($this->key);
        if ($objeto) {
          $objeto->status = 4;
          $objeto->databaixa = date('Y-m-d');
          $objeto->horariobaixa = date('H:i:s');
          $objeto->store();
        }
      }


      $mensagem = "<b>Resultado da Baixa</b><br>"

        . "SITUAÇÃO: " . $response['RETORNO'] . "<br>"
        . "NOSSO NUMERO: " . $this->titulos->seunumero . "<br>"
        . "LINHA DIGITAVEL: " . $this->titulos->linhadigitavel;


      new TMessage('info', $mensagem);
    } catch (Exception $e) {
      // Lidar com erros aqui
      TTransaction::rollback(); // Em caso de erro, faça rollback da transação
    }
  }

  /**
   * Função para consulta de um título.
   */
  public function ConsultarBoletos()
  {
    try {

      $boleto = new BoletoCEF();
      $boleto->setCodigoBeneficiario($this->parametros->numerocontrato);
      $boleto->setCnpj($this->beneficiario->cnpj);
      $boleto->setNossoNumero($this->titulos->seunumero);
      $retorno = $boleto->consultarBoleto();
      $mensagem = "<b>Resultado da Busca</b><br>"
        . "RETORNO: " . $retorno['RETORNO'] . "<br>"
        . "DATA VENCIMENTO: " . ClassMaster::data_BR($retorno['DATA_VENCIMENTO']) . "<br>"
        . "DATA EMISSAO: " . $retorno['DATA_EMISSAO'] . "<br>"
        . "NOME: " . $retorno['NOME'] . "<br>"

        . "LINHA DIGITAVEL: " . $retorno['LINHA_DIGITAVEL'];


      new TMessage('info', $mensagem);

      print_r($response);
    } catch (Exception $e) {
      // Lidar com erros aqui
      TTransaction::rollback(); // Em caso de erro, faça rollback da transação
    }
  }
}
