<?php

/**
 * Classe SantanderBoletoCreate  boleto sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 * Construtor da classe SantanderBoletoCreate.
 *
 * @param string $key - A chave para buscar os parâmetros no banco de dados.
 */
class BradescoBoletoCreate

{
    private $key;
    private $parametros;
    private $titulos;
    private $beneficiario;
    private $pessoas;
    private $cidades;
    private $estado;
    private $payload;
    private $Workspaces;
    private $GetToken;
    private $token;
    private static $database = 'conecatarbanco';
    /**
     * Construtor da classe SantanderBoletoCreate.
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
  
 
      $this->Workspaces = WorkspacesSantander::find($this->parametros->workspaces_santander_id);
      $gera= new GetTokenSantander($this->titulos->parametros_bancos_id);
     
     $this->token= $gera->GetToken();
    }

    /**
     * Função para criar um boleto Sicredi.
     */
    public function Getcreate()
    {



                $formatter = new FormatterClass(); /// estancia 

                    $data = new stdClass();
                    
                    $data->ctitloCobrCdent = "00000004076";
                    $data->registrarTitulo = "1";
                    $data->codUsuario = "UUUSUARIO";
                    $data->nroCpfCnpjBenef = "024018467";
                    $data->filCpfCnpjBenef = "0001";
                    $data->digCpfCnpjBenef = "27";
                    $data->tipoAcesso = "1";
                    $data->cpssoaJuridContr = "2269651";
                    $data->ctpoContrNegoc = "48";
                    $data->nseqContrNegoc = "2170272";
                    $data->cidtfdProdCobr = "0";
                    $data->cnegocCobr = "0";
                    $data->filler = "";
                    $data->codigoBanco = "237";
                    $data->eNseqContrNegoc = "2170272";
                    $data->tipoRegistro = "001";
                    $data->cprodtServcOper = "00000000";
                    $data->ctitloCliCdent = "CTITLO-CLI-CDENT";
                    $data->demisTitloCobr = "10.02.2022";
                    $data->dvctoTitloCobr = "10.06.2022";
                    $data->cidtfdTpoVcto = "0";
                    $data->cindcdEconmMoeda = "00006";
                    $data->vnmnalTitloCobr = "00000000000100000";
                    $data->qmoedaNegocTitlo = "00000000000100000";
                    $data->cespceTitloCobr = "10";
                    $data->cindcdAceitSacdo = "N";
                    $data->ctpoProteTitlo = "00";
                    $data->ctpoPrzProte = "07";
                    $data->ctpoProteDecurs = "00";
                    $data->ctpoPrzDecurs = "07";
                    $data->cctrlPartcTitlo = "CCTRL-PARTC-TITLO";
                    $data->cformaEmisPplta = "01";
                    $data->cindcdPgtoParcial = "N";
                    $data->qtdePgtoParcial = "000";
                    $data->filler1 = "";
                    $data->ptxJuroVcto = "0";
                    $data->vdiaJuroMora = "";
                    $data->qdiaInicJuro = "0";
                    $data->pmultaAplicVcto = "0";
                    $data->vmultaAtrsoPgto = "0.00";
                    $data->qdiaInicMulta = "0";
                    $data->pdescBonifPgto01 = "0";
                    $data->vdescBonifPgto01 = "0.00";
                    $data->dlimDescBonif1 = "";
                    $data->pdescBonifPgto02 = "0";
                    $data->vdescBonifPgto02 = "0.00";
                    $data->dlimDescBonif2 = "";
                    $data->pdescBonifPgto03 = "0";
                    $data->vdescBonifPgto03 = "0.00";
                    $data->dlimDescBonif3 = "";
                    $data->ctpoPrzCobr = "0";
                    $data->pdescBonifPgto = "0";
                    $data->vdescBonifPgto = "0.00";
                    $data->dlimBonifPgto = "";
                    $data->vabtmtTitloCobr = "0.00";
                    $data->viofPgtoTitlo = "0.00";
                    $data->filler2 = "";
                    $data->isacdoTitloCobr = $this->pessoas->nome;
                    $data->elogdrSacdoTitlo = $this->pessoas->cobranca_endereco;
                    $data->enroLogdrSacdo = $this->pessoas->cobranca_endereco;
                    $data->ecomplLogdrSacdo = $this->pessoas->cobranca_complemento;
                    $data->ccepSacdoTitlo = $this->pessoas->cobranca_cep;
                    $data->ccomplCepSacdo = $this->pessoas->cobranca_numero;
                    $data->ebairoLogdrSacdo =$this->pessoas->cobranca_bairro;
                    $data->imunSacdoTitlo =$this->pessoas->cobranca_cidade;
                    $data->csglUfSacdo = $this->pessoas->cobranca_uf;
                    $data->indCpfCnpjSacdo = "1";
                    $data->nroCpfCnpjSacdo = $formatter->formatCpfCnpj($this->pessoas->cpf_cnpj);
                    $data->renderEletrSacdo = $this->pessoas->email;
                 
                    $data->cdddFoneSacdo = "011";
                    $data->cfoneSacdoTitlo = "00989414444";
                    $data->bancoDeb = "000";
                    $data->agenciaDeb = "00000";
                    $data->agenciaDebDv = "0";
                    $data->contaDeb = "0000000000000";
                    $data->bancoCentProt = "237";
                    $data->agenciaDvCentPr = "4152";
                    $data->isacdrAvalsTitlo = "";
                    $data->elogdrSacdrAvals = "";
                    $data->enroLogdrSacdr = "";
                    $data->ecomplLogdrSacdr = "";
                    $data->ccepSacdrTitlo = "0";
                    $data->ccomplCepSacdr = "0";
                    $data->ebairoLogdrSacdr = "";
                    $data->imunSacdrAvals = "";
                    $data->csglUfSacdr = "";
                    $data->indCpfCnpjSacdr = "0";
                    $data->nroCpfCnpjSacdr = "0.00";
                    $data->renderEletrSacdr = "";
                    $data->cdddFoneSacdr = "0";
                    $data->cfoneSacdrTitlo = "0.00";
                    $data->filler3 = "";
                    $data->fase = "1";
                    $data->cindcdCobrMisto = "S";
                    $data->ialiasAdsaoCta = "";
                    $data->iconcPgtoSpi = "";
                    $data->caliasAdsaoCta = "";
                    $data->ilinkGeracQrcd = "";
                    $data->wqrcdPdraoMercd = "";
                    $data->validadeAposVencimento = "0";
                    $data->filler4 = "";
                    
   
                    
                    return $data;

 
                
                
                
               
              
}
    
    
}




