<?php

class ParametrosBancosSicoobForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'ParametrosBancos';
    private static $primaryKey = 'id';
    private static $formName = 'form_ParametrosBancosForm';

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de parametros bancos Sicoob");

        $criteria_beneficiario_id = new TCriteria();
        $criteria_banco_id = new TCriteria();

        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{nome} {nome}','id asc' , $criteria_beneficiario_id );
        $banco_id = new TDBCombo('banco_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_banco_id );
        $apelido = new TEntry('apelido');
        $status = new TRadioGroup('status');
        $etapa_processo_boleto = new TCombo('etapa_processo_boleto');
        $numerocontacorrente = new TEntry('numerocontacorrente');
        $digito_conta = new TEntry('digito_conta');
        $agencia = new TEntry('agencia');
        $digito_agencia = new TEntry('digito_agencia');
        $numerocontrato = new TEntry('numerocontrato');
        $identificacaoboletoempresa = new TEntry('identificacaoboletoempresa');
        $observacao = new TText('observacao');
        $tipodesconto = new TCombo('tipodesconto');
        $diasparadesconto_primeiro = new TEntry('diasparadesconto_primeiro');
        $valorprimeirodesconto = new TEntry('valorprimeirodesconto');
        $numerodiaslimiterecebimento = new TEntry('numerodiaslimiterecebimento');
        $tipomulta = new TCombo('tipomulta');
        $diasmultas = new TEntry('diasmultas');
        $valormulta = new TEntry('valormulta');
        $tipojurosmora = new TCombo('tipojurosmora');
        $diasjurosmora = new TEntry('diasjurosmora');
        $valorjurosmora = new TEntry('valorjurosmora');
        $info1 = new TEntry('info1');
        $mens1 = new TEntry('mens1');
        $mens2 = new TEntry('mens2');
        $mens3 = new TEntry('mens3');
        $mens4 = new TEntry('mens4');
        $client_id = new TText('client_id');
        $client_secret = new TText('client_secret');
        $username = new TEntry('username');
        $password = new TEntry('password');
        $certificado = new TFile('certificado');
        $senha = new TPassword('senha');
        $client_id_bolecode = new TText('client_id_bolecode');
        $client_secret_bolecode = new TText('client_secret_bolecode');
        $certificados_pix = new TFile('certificados_pix');
        $senha_certificado_pix = new TPassword('senha_certificado_pix');
        $tipo_chave_pix = new TCombo('tipo_chave_pix');
        $chave_pix = new TEntry('chave_pix');
        $url1 = new TEntry('url1');
        $url2 = new TEntry('url2');

        $beneficiario_id->addValidation("Beneficiario id", new TRequiredValidator()); 
        $banco_id->addValidation("Banco id", new TRequiredValidator()); 
        $etapa_processo_boleto->addValidation("AMBIENTE", new TRequiredValidator()); 
        $numerocontacorrente->addValidation("Numerocontacorrente", new TRequiredValidator()); 

        $status->setLayout('horizontal');
        $status->setUseButton();
        $certificado->setAllowedExtensions(["pfx"]);
        $certificado->enableFileHandling();
        $certificados_pix->enableFileHandling();

        $id->setEditable(false);
        $banco_id->setEditable(false);
        $etapa_processo_boleto->setEditable(false);

        $status->addItems(["1"=>"ATIVO","2"=>"INATIVO"]);
        $tipomulta->addItems(["0"=>"Isento","1"=>"Valor Fixo","2"=>"Percentual"]);
        $tipojurosmora->addItems(["0"=>"Isento","1"=>"Valor Fixo","2"=>"Percentual"]);
        $etapa_processo_boleto->addItems(["validacao"=>"HOMOLOGAÇÃO","efetivacao"=>"PRODUÇÃO"]);
        $tipo_chave_pix->addItems(["CELULAR"=>"CELULAR","CPF/CNPJ"=>"CPF/CNPJ","E-MAIL"=>"E-MAIL","CHAVE ALEATORIA"=>"CHAVE ALEATORIA"]);
        $tipodesconto->addItems(["0"=>"Sem Desconto","1"=>"Valor Fixo Até a Data Informada","2"=>"Percentual até a data informada","3"=>"Valor por antecipação dia corrido","4"=>"Valor por antecipação dia útil","5"=>"Percentual por antecipação dia corrido","6"=>"Percentual por antecipação dia útil"]);

        $banco_id->enableSearch();
        $tipomulta->enableSearch();
        $tipodesconto->enableSearch();
        $tipojurosmora->enableSearch();
        $tipo_chave_pix->enableSearch();
        $beneficiario_id->enableSearch();
        $etapa_processo_boleto->enableSearch();

        $info1->setMaxLength(80);
        $mens2->setMaxLength(80);
        $mens3->setMaxLength(80);
        $mens4->setMaxLength(80);
        $senha->setMaxLength(255);
        $apelido->setMaxLength(20);
        $digito_conta->setMaxLength(10);
        $numerocontacorrente->setMaxLength(100);
        $identificacaoboletoempresa->setMaxLength(50);

        $banco_id->setValue('1');
        $apelido->setValue('NULL');
        $agencia->setValue('6789');
        $diasmultas->setValue('5');
        $client_id->setValue('NULL');
        $digito_agencia->setValue('3');
        $system_unit_id->setValue('NULL');
        $diasparadesconto_primeiro->setValue('1');
        $etapa_processo_boleto->setValue('validacao');
        $identificacaoboletoempresa->setValue('NULL');

        $id->setSize(70);
        $url1->setSize('100%');
        $url2->setSize('100%');
        $info1->setSize('100%');
        $mens1->setSize('100%');
        $mens2->setSize('100%');
        $mens3->setSize('100%');
        $mens4->setSize('100%');
        $senha->setSize('100%');
        $status->setSize('100%');
        $apelido->setSize('100%');
        $agencia->setSize('100%');
        $banco_id->setSize('100%');
        $username->setSize('100%');
        $password->setSize('100%');
        $tipomulta->setSize('100%');
        $chave_pix->setSize('100%');
        $diasmultas->setSize('100%');
        $valormulta->setSize('100%');
        $system_unit_id->setSize(200);
        $certificado->setSize('100%');
        $digito_conta->setSize('100%');
        $tipodesconto->setSize('100%');
        $tipojurosmora->setSize('100%');
        $diasjurosmora->setSize('100%');
        $client_id->setSize('100%', 70);
        $digito_agencia->setSize('100%');
        $numerocontrato->setSize('100%');
        $valorjurosmora->setSize('100%');
        $tipo_chave_pix->setSize('100%');
        $beneficiario_id->setSize('100%');
        $observacao->setSize('100%', 300);
        $certificados_pix->setSize('100%');
        $client_secret->setSize('100%', 70);
        $numerocontacorrente->setSize('100%');
        $etapa_processo_boleto->setSize('100%');
        $valorprimeirodesconto->setSize('100%');
        $senha_certificado_pix->setSize('100%');
        $client_id_bolecode->setSize('100%', 70);
        $diasparadesconto_primeiro->setSize('100%');
        $identificacaoboletoempresa->setSize('100%');
        $client_secret_bolecode->setSize('100%', 70);
        $numerodiaslimiterecebimento->setSize('100%');


        $this->form->appendPage("1-PRINCIPAL");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("CÓDIGO:", null, '14px', null, '100%'),$id,$system_unit_id],[new TLabel("BENEFICIÁRIO: ", '#000000', '14px', 'B', '100%'),$beneficiario_id],[new TLabel("BANCO:", '#000000', '14px', 'B', '100%'),$banco_id],[new TLabel("Apelido:", null, '14px', null, '100%'),$apelido],[new TLabel("Status:", null, '14px', null, '100%'),$status],[new TLabel(new TImage('fas:info-circle #F44336')."AMBIENTE ATENÇÃO:", '#F44336', '14px', 'B', '100%'),$etapa_processo_boleto]);
        $row1->layout = ['col-sm-1',' col-sm-6',' col-sm-5',' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Conta corrente: ", '#000000', '14px', null, '100%'),$numerocontacorrente],[new TLabel("Digito conta:", null, '14px', null, '100%'),$digito_conta],[new TLabel("Agencia:", null, '14px', null, '100%'),$agencia],[new TLabel("Digito agencia:", null, '14px', null, '100%'),$digito_agencia],[new TLabel("Contrato", null, '14px', null),$numerocontrato],[new TLabel("INDENTIFIÇÃO BOLETO: ", null, '14px', 'B', '100%'),$identificacaoboletoempresa]);
        $row2->layout = [' col-sm-2','col-sm-2',' col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        $row3 = $this->form->addFields([$observacao]);
        $row3->layout = [' col-sm-12'];

        $this->form->appendPage("2-COBRANÇA");
        $row4 = $this->form->addFields([new TLabel("TIPO DESCONTO:", null, '14px', null, '100%'),$tipodesconto],[new TLabel("DIAS  DESCONTO: ", null, '14px', null, '100%'),$diasparadesconto_primeiro],[new TLabel("VALOR:", null, '14px', null),$valorprimeirodesconto],[new TLabel("LIMITE RECIBIMENTO:", null, '14px', null),$numerodiaslimiterecebimento]);
        $row4->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row5 = $this->form->addFields([new TLabel("TIPO MULTA", null, '14px', null, '100%'),$tipomulta],[new TLabel("DIAS MULTA:", null, '14px', null, '100%'),$diasmultas],[new TLabel("VALOR: ", null, '14px', null, '100%'),$valormulta]);
        $row5->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row6 = $this->form->addFields([new TLabel("TIPO JUROS: ", null, '14px', null),$tipojurosmora],[new TLabel("DIAS APLICA JUROS:", null, '14px', null),$diasjurosmora],[new TLabel("VALOR:", null, '14px', null),$valorjurosmora]);
        $row6->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $this->form->appendPage("3-INSTRUÇÕES");
        $row7 = $this->form->addFields([new TLabel("MENSAGEM PRINCIPAL: ", null, '14px', null, '100%'),$info1]);
        $row7->layout = [' col-sm-12'];

        $row8 = $this->form->addFields([new TLabel("Mens1: ", null, '14px', null),$mens1],[new TLabel("Mens2:", null, '14px', null, '100%'),$mens2],[new TLabel("Mens3:", null, '14px', null, '100%'),$mens3],[new TLabel("Mens4:", null, '14px', null, '100%'),$mens4]);
        $row8->layout = [' col-sm-6','col-sm-6','col-sm-6','col-sm-6'];

        $this->form->appendPage("4-CONFIGURAÇÕES BOLETOS");
        $row9 = $this->form->addContent([new TFormSeparator("DADOS BOLETO CONVECIONAL:", '#2196F3', '18', '#4CAF50')]);
        $row10 = $this->form->addFields([new TLabel(new TImage('fas:user-secret #FF5722')."CLIENT ID BOLETO:", '#FF5722', '14px', 'B', '100%'),$client_id],[new TLabel(" Client Secret BOLETO:", null, '14px', null),$client_secret],[new TLabel(new TImage('fas:user-friends #009688')."LOGIN:", '#009688', '14px', 'B', '100%'),$username],[new TLabel(new TImage('fas:keyboard #E91E63')."SENHA::", '#E91E63', '14px', 'B', '100%'),$password],[new TLabel("Certificado A1 boleto convecional: ", '#FF5722', '14px', 'BI'),$certificado],[new TLabel("Senha certificado:", '#FF5722', '14px', 'BI'),$senha]);
        $row10->layout = ['col-sm-6','col-sm-6',' col-sm-6',' col-sm-6',' col-sm-10',' col-sm-2'];

        $row11 = $this->form->addContent([new TFormSeparator("DADOS BOLETO BOLECODE:", '#FFC107', '18', '#8BC34A')]);
        $row12 = $this->form->addFields([new TLabel("Client ID PIX: ", null, '14px', 'B'),$client_id_bolecode],[new TLabel("Client Secret PIX:", null, '14px', 'B'),$client_secret_bolecode],[new TLabel("CERTIFICADO PIX: ", null, '14px', 'B'),$certificados_pix],[new TLabel("Senha certificado pix:", null, '14px', 'B'),$senha_certificado_pix],[new TLabel("Tipo chave pix:", null, '14px', 'B'),$tipo_chave_pix],[new TLabel("Chave pix:", null, '14px', 'B', '100%'),$chave_pix],[new TLabel("URL TOKEN:", null, '14px', 'B'),$url1],[new TLabel("URL AÇÕES DO BOLETO:", null, '14px', 'B'),$url2]);
        $row12->layout = ['col-sm-6','col-sm-6','col-sm-4','col-sm-2','col-sm-2','col-sm-4',' col-sm-12',' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ParametrosBancosList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Bancos","Cadastro de parametros bancos Sicoob"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new ParametrosBancos(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $certificado_dir = 'certificados/normal';
            $certificados_pix_dir = 'certificados/pix'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'certificado', $certificado_dir);
            $this->saveFile($object, $data, 'certificados_pix', $certificados_pix_dir);
            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('ParametrosBancosList', 'onShow', $loadPageParam); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new ParametrosBancos($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

