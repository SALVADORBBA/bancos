<?php

class BeneficiarioForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'Beneficiario';
    private static $primaryKey = 'id';
    private static $formName = 'form_BeneficiarioForm';

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
        $this->form->setFormTitle("Cadastro de beneficiario");


        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $data_nascimento = new THidden('data_nascimento');
        $cnpj = new TEntry('cnpj');
        $tipo_pessoa = new TCombo('tipo_pessoa');
        $nome = new TEntry('nome');
        $insc_estadual = new TEntry('insc_estadual');
        $cep = new TEntry('cep');
        $endereco = new TEntry('endereco');
        $numero = new TEntry('numero');
        $complemento = new TEntry('complemento');
        $bairro = new TEntry('bairro');
        $cidade = new TEntry('cidade');
        $cmun = new TEntry('cmun');
        $estado = new TEntry('estado');
        $cuf = new TEntry('cuf');
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');
        $instancename = new TEntry('instancename');
        $apikey = new TEntry('apikey');
        $rotaexterna = new TEntry('rotaexterna');
        $urlexterna = new TEntry('urlexterna');

        $cnpj->setExitAction(new TAction([$this,'ONBuscaCNPJ']));

        $tipo_pessoa->addValidation("Tipo pessoa", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 

        $id->setEditable(false);
        $tipo_pessoa->addItems(["1"=>"PF","2"=>"PJ"]);
        $tipo_pessoa->setDefaultOption(false);
        $tipo_pessoa->enableSearch();
        $tipo_pessoa->setValue('2');
        $system_unit_id->setValue(TSession::getValue("userunitid"));

        $cep->setMaxLength(8);
        $cnpj->setMaxLength(14);
        $nome->setMaxLength(255);
        $estado->setMaxLength(2);
        $email->setMaxLength(255);
        $cidade->setMaxLength(100);
        $telefone->setMaxLength(15);
        $endereco->setMaxLength(255);
        $insc_estadual->setMaxLength(20);

        $id->setSize(100);
        $cep->setSize('100%');
        $cuf->setSize('100%');
        $cnpj->setSize('100%');
        $nome->setSize('100%');
        $cmun->setSize('100%');
        $email->setSize('100%');
        $numero->setSize('100%');
        $bairro->setSize('100%');
        $cidade->setSize('100%');
        $estado->setSize('100%');
        $apikey->setSize('100%');
        $endereco->setSize('100%');
        $telefone->setSize('100%');
        $urlexterna->setSize('100%');
        $system_unit_id->setSize(200);
        $tipo_pessoa->setSize('100%');
        $complemento->setSize('100%');
        $rotaexterna->setSize('100%');
        $data_nascimento->setSize(200);
        $instancename->setSize('100%');
        $insc_estadual->setSize('100%');


        $this->form->appendPage("Principal");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id,$system_unit_id,$data_nascimento],[new TLabel("CPF / CNPJ:", null, '14px', null, '100%'),$cnpj],[new TLabel("Tipo pessoa:", '#ff0000', '14px', null, '100%'),$tipo_pessoa],[new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$nome],[new TLabel("IE / RG:", null, '14px', null, '100%'),$insc_estadual]);
        $row1->layout = [' col-sm-2',' col-sm-2',' col-sm-2',' col-sm-4',' col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("Cep:", null, '14px', null, '100%'),$cep],[new TLabel("Endereco:", null, '14px', null, '100%'),$endereco],[new TLabel("MÚMERO", null, '14px', null),$numero],[new TLabel("Complemento:", null, '14px', null),$complemento],[new TLabel("BAIRRO:", null, '14px', null),$bairro],[new TLabel("Cidade:", null, '14px', null, '100%'),$cidade],[new TLabel("IBGE:", null, '14px', null),$cmun],[new TLabel("Estado:", null, '14px', null, '100%'),$estado],[new TLabel("CUF:", null, '14px', null),$cuf]);
        $row2->layout = ['col-sm-2','col-sm-5','col-sm-2','col-sm-3',' col-sm-2',' col-sm-4','col-sm-2',' col-sm-2','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("Telefone:", null, '14px', null, '100%'),$telefone],[new TLabel("Email:", null, '14px', null, '100%'),$email]);
        $row3->layout = [' col-sm-3',' col-sm-9'];

        $this->form->appendPage("Configuações");
        $row4 = $this->form->addFields([new TLabel("instancename", null, '14px', null),$instancename],[new TLabel("apikey", null, '14px', null),$apikey],[new TLabel("rotaexterna", null, '14px', null),$rotaexterna],[new TLabel("urlexterna", null, '14px', null),$urlexterna]);
        $row4->layout = [' col-sm-6',' col-sm-6',' col-sm-6',' col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['BeneficiarioList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=BeneficiarioForm]');
        $style->width = '70% !important';   
        $style->show(true);

    }

    public static function ONBuscaCNPJ($param = null) 
    {
        try 
        {
        $resposta=consultarCNPJIE::Busca($param['cnpj']);

            $dados_empresa = new stdClass();
            $dados_empresa->nome = $resposta->razao_social;

            $dados_empresa->endereco = $resposta->estabelecimento->logradouro;
            $dados_empresa->numero = $resposta->estabelecimento->numero;

            $dados_empresa->cidade = $resposta->estabelecimento->cidade->nome;

            $dados_empresa->cidade = $resposta->estabelecimento->cidade->nome;
            $dados_empresa->estado = $resposta->estabelecimento->estado->sigla;
            $dados_empresa->cep =  $resposta->estabelecimento->cep;

       $dados_empresa->numero = $resposta->estabelecimento->numero;
$dados_empresa->complemento = $resposta->estabelecimento->complemento;
$dados_empresa->bairro = $resposta->estabelecimento->bairro;

$dados_empresa->cmun =  $resposta->estabelecimento->cidade->ibge_id;
$dados_empresa->cuf =  $resposta->estabelecimento->estado->ibge_id;

$dados_empresa->email = $resposta->estabelecimento->email;

$dados_empresa->insc_estadual = $resposta->estabelecimento->inscricoes_estaduais[0]->inscricao_estadual;
        TForm::sendData(self::$formName, $dados_empresa);
        // -----

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Beneficiario(); // create an empty object 

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
            TApplication::loadPage('BeneficiarioList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 

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

                $object = new Beneficiario($key); // instantiates the Active Record 

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

