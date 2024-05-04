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
  // Propriedades da classe  
  private $key;
 
  /**
   * Construtor da classe MultClassCEF.
   *
   * @param string $key - A chave para buscar os parâmetros no banco de dados.
   */
  public function __construct($key)
  {
    $this->key = $key;

  
  }


  public function IncluirBoleto()
  {
    try {
 
 

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
      
      
 
     return   $response;
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
     
    } catch (Exception $e) {
      // Lidar com erros aqui
      TTransaction::rollback(); // Em caso de erro, faça rollback da transação
    }
  }
}
