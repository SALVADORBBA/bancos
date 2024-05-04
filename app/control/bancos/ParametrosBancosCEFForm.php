<?php

class ParametrosBancosCEFForm extends TPage
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
        $this->form->setFormTitle("Cadastro de parametros bancos CEF");

        $criteria_beneficiario_id = new TCriteria();
        $criteria_banco_id = new TCriteria();

        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{nome} {nome}','id asc' , $criteria_beneficiario_id );
        $banco_id = new TDBCombo('banco_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_banco_id );
        $apelido = new TEntry('apelido');
        $status = new TRadioGroup('status');
        $versao = new TEntry('versao');
        $unidade = new TEntry('unidade');
        $sistema_origem = new TEntry('sistema_origem');
        $numerocontrato = new TEntry('numerocontrato');
        $carteira = new TEntry('carteira');
        $tipomulta = new TCombo('tipomulta');
        $diasmultas = new TEntry('diasmultas');
        $valormulta = new TEntry('valormulta');
        $tipojurosmora = new TCombo('tipojurosmora');
        $valorjurosmora = new TEntry('valorjurosmora');
        $baixar_devolver_prazo = new TEntry('baixar_devolver_prazo');
        $valorsegundodesconto = new TNumeric('valorsegundodesconto', '2', ',', '.' );
        $diasparadesconto_terceiro = new TEntry('diasparadesconto_terceiro');
        $dataterceirodesconto = new TDate('dataterceirodesconto');
        $valorTerceiroDesconto = new TNumeric('valorTerceiroDesconto', '2', ',', '.' );
        $info1 = new TEntry('info1');
        $info2 = new TEntry('info2');
        $mens1 = new TEntry('mens1');
        $mens2 = new TEntry('mens2');
        $mens3 = new TEntry('mens3');
        $mens4 = new TEntry('mens4');
        $autenticacao = new TEntry('autenticacao');
        $username = new TEntry('username');
        $url1 = new TEntry('url1');
        $url2 = new TEntry('url2');
        $url3 = new TEntry('url3');
        $url4 = new TEntry('url4');

        $beneficiario_id->addValidation("Beneficiario id", new TRequiredValidator()); 
        $banco_id->addValidation("Banco id", new TRequiredValidator()); 
        $versao->addValidation("Numerocontacorrente", new TRequiredValidator()); 

        $id->setEditable(false);
        $status->setLayout('horizontal');
        $status->setUseButton();
        $dataterceirodesconto->setMask('dd/mm/yyyy');
        $dataterceirodesconto->setDatabaseMask('yyyy-mm-dd');
        $status->addItems(["1"=>"ATIVO","2"=>"INATIVO"]);
        $tipomulta->addItems(["1"=>"SIM APLICAR","0"=>"NÃO APLICAR"]);
        $tipojurosmora->addItems(["1"=>"SIM APLICAR","0"=>"NÃO APLICAR"]);

        $banco_id->enableSearch();
        $tipomulta->enableSearch();
        $tipojurosmora->enableSearch();
        $beneficiario_id->enableSearch();

        $versao->setValue('3.0');
        $apelido->setValue('NULL');
        $diasmultas->setValue('5');
        $carteira->setValue('NULL');
        $autenticacao->setValue('NULL');
        $system_unit_id->setValue('NULL');
        $sistema_origem->setValue('SIGCB');

        $info1->setMaxLength(80);
        $info2->setMaxLength(80);
        $mens1->setMaxLength(80);
        $mens2->setMaxLength(80);
        $mens3->setMaxLength(80);
        $mens4->setMaxLength(80);
        $apelido->setMaxLength(20);
        $unidade->setMaxLength(10);
        $carteira->setMaxLength(50);
        $autenticacao->setMaxLength(255);
        $diasparadesconto_terceiro->setMaxLength(255);

        $id->setSize(70);
        $url1->setSize('100%');
        $url2->setSize('100%');
        $url3->setSize('100%');
        $url4->setSize('100%');
        $info1->setSize('100%');
        $info2->setSize('100%');
        $mens1->setSize('100%');
        $mens2->setSize('100%');
        $mens3->setSize('100%');
        $mens4->setSize('100%');
        $status->setSize('100%');
        $versao->setSize('100%');
        $apelido->setSize('100%');
        $unidade->setSize('100%');
        $banco_id->setSize('100%');
        $carteira->setSize('100%');
        $username->setSize('100%');
        $tipomulta->setSize('100%');
        $diasmultas->setSize('100%');
        $valormulta->setSize('100%');
        $system_unit_id->setSize(200);
        $autenticacao->setSize('100%');
        $tipojurosmora->setSize('100%');
        $sistema_origem->setSize('100%');
        $numerocontrato->setSize('100%');
        $valorjurosmora->setSize('100%');
        $beneficiario_id->setSize('100%');
        $dataterceirodesconto->setSize(110);
        $valorsegundodesconto->setSize('100%');
        $baixar_devolver_prazo->setSize('100%');
        $valorTerceiroDesconto->setSize('100%');
        $diasparadesconto_terceiro->setSize('100%');


        $this->form->appendPage("1-PRINCIPAL");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("CÓDIGO:", null, '14px', null, '100%'),$id,$system_unit_id],[new TLabel("BENEFICIÁRIO: ", '#000000', '14px', 'B', '100%'),$beneficiario_id],[new TLabel("BANCO:", '#000000', '14px', 'B', '100%'),$banco_id],[new TLabel("Apelido:", null, '14px', null, '100%'),$apelido],[new TLabel("Status:", null, '14px', null, '100%'),$status]);
        $row1->layout = [' col-sm-1',' col-sm-4',' col-sm-3',' col-sm-2',' col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("VERSÃO", '#ff0000', '14px', null, '100%'),$versao],[new TLabel("UNIDADE:", null, '14px', null, '100%'),$unidade],[new TLabel("ORIGEM:", null, '14px', null, '100%'),$sistema_origem],[new TLabel("CÓDIGO BENEFICIARIO:", null, '14px', null),$numerocontrato],[new TLabel("CARTEIRA:", null, '14px', 'B', '100%'),$carteira]);
        $row2->layout = ['col-sm-2','col-sm-2','col-sm-2',' col-sm-3',' col-sm-3'];

        $this->form->appendPage("2-COBRANÇA");
        $row3 = $this->form->addFields([new TLabel("MULTA:", null, '14px', null, '100%'),$tipomulta],[new TLabel("DIAS APLICAR MULTA:", null, '14px', null, '100%'),$diasmultas],[new TLabel("VALOR:", null, '14px', null, '100%'),$valormulta],[new TLabel("JUROS:", null, '14px', null, '100%'),$tipojurosmora],[new TLabel("VALOR:", null, '14px', null),$valorjurosmora],[new TLabel("DEVOLVER DIAS: ", null, '14px', null),$baixar_devolver_prazo]);
        $row3->layout = [' col-sm-2','col-sm-2',' col-sm-2',' col-sm-2','col-sm-2','col-sm-2'];

        $row4 = $this->form->addFields([new TLabel("Valorsegundodesconto:", null, '14px', null, '100%'),$valorsegundodesconto],[new TLabel("Diasparadesconto terceiro:", null, '14px', null, '100%'),$diasparadesconto_terceiro]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Dataterceirodesconto:", null, '14px', null, '100%'),$dataterceirodesconto],[new TLabel("ValorTerceiroDesconto:", null, '14px', null, '100%'),$valorTerceiroDesconto]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("3-INSTRUÇÕES");
        $row6 = $this->form->addFields([new TLabel("INFORMAÇÕES-1:", null, '14px', null, '100%'),$info1],[new TLabel("INFORMAÇÕES-2:", null, '14px', null, '100%'),$info2]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->form->addFields([new TLabel("MENSAGEM -1:", null, '14px', null, '100%'),$mens1],[new TLabel("MENSAGEM -2: ", null, '14px', null, '100%'),$mens2]);
        $row7->layout = ['col-sm-6','col-sm-6'];

        $row8 = $this->form->addFields([new TLabel("MENSAGEM -3:", null, '14px', null, '100%'),$mens3],[new TLabel("MENSAGEM -4:", null, '14px', null, '100%'),$mens4]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("4-CONFIGURAÇÕES BOLETOS");
        $row9 = $this->form->addFields([new TLabel(new TImage('fas:user-secret #FF5722')."AUTENTICACAÇÃO", '#FF5722', '14px', 'B', '100%'),$autenticacao],[new TLabel(new TImage('fas:user-friends #009688')."USUARIO DE SERVICO:", '#009688', '14px', 'B', '100%'),$username],[new TLabel("URL TOKEN:", null, '14px', 'B'),$url1],[new TLabel("URL AÇÕES DO BOLETO:", null, '14px', 'B'),$url2],[new TLabel("SOAPENV:", null, '14px', 'B'),$url3],[new TLabel("XML EXT:", null, '14px', 'B'),$url4]);
        $row9->layout = ['col-sm-8','col-sm-4',' col-sm-12',' col-sm-12',' col-sm-12',' col-sm-12'];

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
            $container->add(TBreadCrumb::create(["Bancos","Cadastro de parametros bancos CEF"]));
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

