<?php

class ParametrosBancosBBForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'ParametrosBancos';
    private static $primaryKey = 'id';
    private static $formName = 'form_ParametrosBancosForm';

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
        $this->form->setFormTitle("Cadastro de parametros bancos BB");

        $criteria_beneficiario_id = new TCriteria();
        $criteria_banco_id = new TCriteria();

        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{nome} {nome}','id asc' , $criteria_beneficiario_id );
        $banco_id = new TDBCombo('banco_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_banco_id );
        $apelido = new TEntry('apelido');
        $status = new TRadioGroup('status');
        $numerocontacorrente = new TEntry('numerocontacorrente');
        $digito_conta = new TEntry('digito_conta');
        $agencia = new TEntry('agencia');
        $digito_agencia = new TEntry('digito_agencia');
        $numeroconvenio = new TEntry('numeroconvenio');
        $carteira = new TEntry('carteira');
        $numerovariacaocarteira = new TEntry('numerovariacaocarteira');
        $indicadoraceitetitulovencido = new TCombo('indicadoraceitetitulovencido');
        $numerodiaslimiterecebimento = new TEntry('numerodiaslimiterecebimento');
        $codigoaceite = new TEntry('codigoaceite');
        $tipos_documentos = new TCombo('tipos_documentos');
        $identificacaoemissaoboleto = new TEntry('identificacaoemissaoboleto');
        $identificacaodistribuicaoboleto = new TEntry('identificacaodistribuicaoboleto');
        $tipodesconto = new TEntry('tipodesconto');
        $diasparadesconto_primeiro = new TEntry('diasparadesconto_primeiro');
        $valorprimeirodesconto = new TNumeric('valorprimeirodesconto', '2', ',', '.' );
        $dataprimeirodesconto = new TDate('dataprimeirodesconto');
        $diasparadesconto_segundo = new TEntry('diasparadesconto_segundo');
        $datasegundodesconto = new TDate('datasegundodesconto');
        $valorsegundodesconto = new TNumeric('valorsegundodesconto', '2', ',', '.' );
        $diasparadesconto_terceiro = new TEntry('diasparadesconto_terceiro');
        $dataterceirodesconto = new TDate('dataterceirodesconto');
        $valorTerceiroDesconto = new TNumeric('valorTerceiroDesconto', '2', ',', '.' );
        $tipomulta = new TEntry('tipomulta');
        $tipojurosmora = new TEntry('tipojurosmora');
        $diasmultas = new TEntry('diasmultas');
        $valormulta = new TEntry('valormulta');
        $diasjurosmora = new TEntry('diasjurosmora');
        $valorjurosmora = new TEntry('valorjurosmora');
        $info1 = new TEntry('info1');
        $info2 = new TEntry('info2');
        $mens1 = new TEntry('mens1');
        $mens2 = new TEntry('mens2');
        $mens3 = new TEntry('mens3');
        $mens4 = new TEntry('mens4');
        $gw_dev_app_key = new TText('gw_dev_app_key');
        $authorization = new TText('authorization');
        $username = new TEntry('username');
        $password = new TEntry('password');
        $url1 = new TEntry('url1');
        $url2 = new TEntry('url2');

        $beneficiario_id->addValidation("Beneficiario id", new TRequiredValidator()); 
        $banco_id->addValidation("Banco id", new TRequiredValidator()); 
        $tipos_documentos->addValidation("TIPO DOCUMENTO", new TRequiredValidator()); 

        $id->setEditable(false);
        $status->setLayout('horizontal');
        $status->setUseButton();
        $status->addItems(["1"=>"ATIVO","2"=>"INATIVO"]);
        $tipos_documentos->addItems(["DM"=>"DUPLICATA MERCANTIL "]);
        $indicadoraceitetitulovencido->addItems(["S"=>"SIM","N"=>"NÂO"]);

        $datasegundodesconto->setMask('dd/mm/yyyy');
        $dataprimeirodesconto->setMask('dd/mm/yyyy');
        $dataterceirodesconto->setMask('dd/mm/yyyy');

        $datasegundodesconto->setDatabaseMask('yyyy-mm-dd');
        $dataprimeirodesconto->setDatabaseMask('yyyy-mm-dd');
        $dataterceirodesconto->setDatabaseMask('yyyy-mm-dd');

        $banco_id->enableSearch();
        $beneficiario_id->enableSearch();
        $tipos_documentos->enableSearch();
        $indicadoraceitetitulovencido->enableSearch();

        $apelido->setValue('NULL');
        $diasmultas->setValue('5');
        $username->setValue('NULL');
        $codigoaceite->setValue('A');
        $digito_conta->setValue('SIGCB');
        $system_unit_id->setValue('NULL');
        $digito_agencia->setValue('NULL');
        $diasparadesconto_primeiro->setValue('1');

        $info1->setMaxLength(80);
        $info2->setMaxLength(80);
        $mens1->setMaxLength(80);
        $mens2->setMaxLength(80);
        $mens3->setMaxLength(80);
        $mens4->setMaxLength(80);
        $apelido->setMaxLength(20);
        $tipomulta->setMaxLength(50);
        $username->setMaxLength(255);
        $tipodesconto->setMaxLength(50);
        $tipojurosmora->setMaxLength(50);
        $digito_agencia->setMaxLength(50);
        $numerocontacorrente->setMaxLength(10);
        $diasparadesconto_terceiro->setMaxLength(255);
        $identificacaoemissaoboleto->setMaxLength(100);
        $identificacaodistribuicaoboleto->setMaxLength(100);

        $id->setSize(70);
        $url1->setSize('100%');
        $url2->setSize('100%');
        $info1->setSize('100%');
        $info2->setSize('100%');
        $mens1->setSize('100%');
        $mens2->setSize('100%');
        $mens3->setSize('100%');
        $mens4->setSize('100%');
        $status->setSize('100%');
        $apelido->setSize('100%');
        $agencia->setSize('100%');
        $banco_id->setSize('100%');
        $carteira->setSize('100%');
        $username->setSize('100%');
        $password->setSize('100%');
        $tipomulta->setSize('100%');
        $diasmultas->setSize('100%');
        $valormulta->setSize('100%');
        $system_unit_id->setSize(200);
        $digito_conta->setSize('100%');
        $codigoaceite->setSize('100%');
        $tipodesconto->setSize('100%');
        $tipojurosmora->setSize('100%');
        $diasjurosmora->setSize('100%');
        $digito_agencia->setSize('100%');
        $numeroconvenio->setSize('100%');
        $valorjurosmora->setSize('100%');
        $beneficiario_id->setSize('100%');
        $tipos_documentos->setSize('100%');
        $datasegundodesconto->setSize(110);
        $dataprimeirodesconto->setSize(110);
        $dataterceirodesconto->setSize(110);
        $authorization->setSize('100%', 200);
        $numerocontacorrente->setSize('100%');
        $gw_dev_app_key->setSize('100%', 200);
        $valorsegundodesconto->setSize('100%');
        $valorprimeirodesconto->setSize('100%');
        $valorTerceiroDesconto->setSize('100%');
        $numerovariacaocarteira->setSize('100%');
        $diasparadesconto_segundo->setSize('100%');
        $diasparadesconto_primeiro->setSize('100%');
        $diasparadesconto_terceiro->setSize('100%');
        $identificacaoemissaoboleto->setSize('100%');
        $numerodiaslimiterecebimento->setSize('100%');
        $indicadoraceitetitulovencido->setSize('100%');
        $identificacaodistribuicaoboleto->setSize('100%');

        $this->form->appendPage("1-PRINCIPAL");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("CÓDIGO:", null, '14px', null, '100%'),$id,$system_unit_id],[new TLabel("BENEFICIÁRIO: ", '#000000', '14px', 'B', '100%'),$beneficiario_id],[new TLabel("BANCO:", '#000000', '14px', 'B', '100%'),$banco_id],[new TLabel("Apelido:", null, '14px', null, '100%'),$apelido],[new TLabel("Status:", null, '14px', null, '100%'),$status]);
        $row1->layout = [' col-sm-1',' col-sm-4',' col-sm-3',' col-sm-2',' col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("CONTA CORRENTE: ", null, '14px', null, '100%'),$numerocontacorrente],[new TLabel("DIGITO: ", null, '14px', null, '100%'),$digito_conta],[new TLabel("AGÊNCIA ", null, '14px', null),$agencia],[new TLabel("DIGITO:", null, '14px', null, '100%'),$digito_agencia],[new TLabel("NUMERO CONVÊNIO:", null, '14px', null),$numeroconvenio],[new TLabel("CARTEIRA:", null, '14px', null),$carteira],[new TLabel("VARIAÇÃO CARTEIRA: ", null, '14px', null),$numerovariacaocarteira],[new TLabel("COBRANÇA VENCIDA:", null, '14px', null),$indicadoraceitetitulovencido],[new TLabel("DIAS: ", null, '14px', null),$numerodiaslimiterecebimento],[new TLabel("CODIGO ACEITE:", null, '14px', null),$codigoaceite],[new TLabel("TIPO DOCUMENTO:", null, '14px', null),$tipos_documentos]);
        $row2->layout = [' col-sm-3','col-sm-2',' col-sm-3','col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        $this->form->appendPage("2-COBRANÇA");
        $row3 = $this->form->addFields([new TLabel("Identificacaoemissaoboleto:", null, '14px', null, '100%'),$identificacaoemissaoboleto],[new TLabel("Identificacaodistribuicaoboleto:", null, '14px', null, '100%'),$identificacaodistribuicaoboleto]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Tipodesconto:", null, '14px', null, '100%'),$tipodesconto],[new TLabel("Diasparadesconto primeiro:", null, '14px', null, '100%'),$diasparadesconto_primeiro]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Valorprimeirodesconto:", null, '14px', null, '100%'),$valorprimeirodesconto],[new TLabel("Dataprimeirodesconto:", null, '14px', null, '100%'),$dataprimeirodesconto]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->form->addFields([new TLabel("Diasparadesconto segundo:", null, '14px', null, '100%'),$diasparadesconto_segundo],[new TLabel("Datasegundodesconto:", null, '14px', null, '100%'),$datasegundodesconto]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->form->addFields([new TLabel("Valorsegundodesconto:", null, '14px', null, '100%'),$valorsegundodesconto],[new TLabel("Diasparadesconto terceiro:", null, '14px', null, '100%'),$diasparadesconto_terceiro]);
        $row7->layout = ['col-sm-6','col-sm-6'];

        $row8 = $this->form->addFields([new TLabel("Dataterceirodesconto:", null, '14px', null, '100%'),$dataterceirodesconto],[new TLabel("ValorTerceiroDesconto:", null, '14px', null, '100%'),$valorTerceiroDesconto]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $row9 = $this->form->addFields([new TLabel("Tipomulta:", null, '14px', null, '100%'),$tipomulta],[new TLabel("Tipojurosmora:", null, '14px', null, '100%'),$tipojurosmora]);
        $row9->layout = ['col-sm-6','col-sm-6'];

        $row10 = $this->form->addFields([new TLabel("Diasmultas:", null, '14px', null, '100%'),$diasmultas],[new TLabel("Valormulta:", null, '14px', null, '100%'),$valormulta]);
        $row10->layout = ['col-sm-6','col-sm-6'];

        $row11 = $this->form->addFields([new TLabel("Diasjurosmora:", null, '14px', null, '100%'),$diasjurosmora],[new TLabel("Valorjurosmora:", null, '14px', null, '100%'),$valorjurosmora]);
        $row11->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("3-INSTRUÇÕES");
        $row12 = $this->form->addFields([new TLabel("INFORMAÇÕES-1:", null, '14px', null, '100%'),$info1],[new TLabel("INFORMAÇÕES-2:", null, '14px', null, '100%'),$info2]);
        $row12->layout = ['col-sm-6','col-sm-6'];

        $row13 = $this->form->addFields([new TLabel("MENSAGEM -1:", null, '14px', null, '100%'),$mens1],[new TLabel("MENSAGEM -2: ", null, '14px', null, '100%'),$mens2]);
        $row13->layout = ['col-sm-6','col-sm-6'];

        $row14 = $this->form->addFields([new TLabel("MENSAGEM -3:", null, '14px', null, '100%'),$mens3],[new TLabel("MENSAGEM -4:", null, '14px', null, '100%'),$mens4]);
        $row14->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("4-CONFIGURAÇÕES BOLETOS");
        $row15 = $this->form->addFields([new TLabel("APP KEY:", null, '14px', null),$gw_dev_app_key],[new TLabel("TOKEN FIXO:", null, '14px', null),$authorization]);
        $row15->layout = [' col-sm-6',' col-sm-6'];

        $row16 = $this->form->addFields([new TLabel(new TImage('fas:user-friends #009688')."LOGIN: ", '#009688', '14px', 'B', '100%'),$username],[new TLabel(new TImage('fas:user-secret #FF5722')."SENHA: ", '#FF5722', '14px', 'B', '100%'),$password]);
        $row16->layout = [' col-sm-8',' col-sm-4'];

        $row17 = $this->form->addFields([new TLabel("URL TOKEN: ", null, '14px', 'B'),$url1]);
        $row17->layout = [' col-sm-12'];

        $row18 = $this->form->addFields([new TLabel("URL AÇÕES BOLETO:", null, '14px', 'B'),$url2]);
        $row18->layout = [' col-sm-12'];

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
            $container->add(TBreadCrumb::create(["Bancos","Cadastro de parametros bancos BB"]));
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

            $object->store(); // save the object 

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

