<?php

class ClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'Cliente';
    private static $primaryKey = 'id';
    private static $formName = 'form_ClienteForm';

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
        $this->form->setFormTitle("Cadastro de cliente");

        $criteria_beneficiario_id = new TCriteria();
        $criteria_paises_codigos = new TCriteria();

        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $cpf_cnpj = new TEntry('cpf_cnpj');
        $insc_estadual = new TEntry('insc_estadual');
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{cnpj} -  {nome}','id asc' , $criteria_beneficiario_id );
        $razao_social = new TEntry('razao_social');
        $nome = new TEntry('nome');
        $status = new TRadioGroup('status');
        $email = new TEntry('email');
        $fone = new TEntry('fone');
        $paises_codigos = new TDBCombo('paises_codigos', 'conecatarbanco', 'PaisesCodigos', 'fone', ' {fone}  - {nome}','id asc' , $criteria_paises_codigos );
        $number = new TEntry('number');
        $cobranca_cep = new TEntry('cobranca_cep');
        $cobranca_endereco = new TEntry('cobranca_endereco');
        $cobranca_numero = new TEntry('cobranca_numero');
        $cobranca_complemento = new TEntry('cobranca_complemento');
        $cobranca_bairro = new TEntry('cobranca_bairro');
        $cobranca_cidade = new TEntry('cobranca_cidade');
        $cobranca_cmun = new TEntry('cobranca_cmun');
        $cobranca_uf = new TEntry('cobranca_uf');
        $cobranca_cuf = new TEntry('cobranca_cuf');
        $observacoes = new TText('observacoes');
        $cobranca_lat = new TEntry('cobranca_lat');
        $cobranca_lng = new TEntry('cobranca_lng');

        $cobranca_cep->setExitAction(new TAction([$this,'onBuscarCep']));

        $beneficiario_id->addValidation("Beneficiario id", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 

        $id->setEditable(false);
        $status->addItems(["1"=>"Ativo","2"=>"Inativo"]);
        $status->setLayout('horizontal');
        $status->setUseButton();
        $number->setMask('(99)99999-9999');
        $paises_codigos->setValue('55');
        $system_unit_id->setValue(TSession::getValue("userunitid"));

        $paises_codigos->enableSearch();
        $beneficiario_id->enableSearch();

        $cpf_cnpj->setMaxLength(20);
        $cobranca_lat->setMaxLength(30);
        $cobranca_lng->setMaxLength(30);

        $id->setSize(100);
        $status->setSize(80);
        $nome->setSize('100%');
        $fone->setSize('100%');
        $email->setSize('100%');
        $number->setSize('100%');
        $cpf_cnpj->setSize('100%');
        $system_unit_id->setSize(200);
        $cobranca_uf->setSize('100%');
        $razao_social->setSize('100%');
        $cobranca_cep->setSize('100%');
        $cobranca_cuf->setSize('100%');
        $cobranca_lat->setSize('100%');
        $cobranca_lng->setSize('100%');
        $insc_estadual->setSize('100%');
        $cobranca_cmun->setSize('100%');
        $paises_codigos->setSize('100%');
        $beneficiario_id->setSize('100%');
        $cobranca_numero->setSize('100%');
        $cobranca_bairro->setSize('100%');
        $cobranca_cidade->setSize('100%');
        $observacoes->setSize('100%', 110);
        $cobranca_endereco->setSize('100%');
        $cobranca_complemento->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id,$system_unit_id],[new TLabel("CPF /CNPJ:", null, '14px', null, '100%'),$cpf_cnpj],[new TLabel("RG /IE", null, '14px', null, '100%'),$insc_estadual],[new TLabel("BENEFICIÁRIO: ", '#000000', '14px', null, '100%'),$beneficiario_id],[new TLabel("RAZÃO SOCIAL", null, '14px', null, '100%'),$razao_social],[new TLabel("FANTASIA:", '#ff0000', '14px', null, '100%'),$nome],[new TLabel("STATUS: ", '#000000', '14px', null, '100%'),$status]);
        $row1->layout = ['col-sm-2','col-sm-3','col-sm-2','col-sm-5',' col-sm-5',' col-sm-4',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Email:", null, '14px', null, '100%'),$email],[new TLabel("Fone:", null, '14px', null, '100%'),$fone],[new TLabel("Paias:", null, '14px', null),$paises_codigos],[new TLabel(new TImage('fas:comment #009688')."WhatsApp", '#009688', '14px', 'B'),$number]);
        $row2->layout = [' col-sm-6',' col-sm-2','col-sm-2','col-sm-2'];

        $row3 = $this->form->addContent([new TFormSeparator("ENDEREÇO", '#4CAF50', '18', '#009688')]);
        $row4 = $this->form->addFields([new TLabel(new TImage('fas:map-marker #8BC34A')."CEP:", '#8BC34A', '14px', 'B', '100%'),$cobranca_cep],[new TLabel("ENDEREÇO: ", null, '14px', null, '100%'),$cobranca_endereco],[new TLabel("NÚMERO:", null, '14px', null),$cobranca_numero],[new TLabel("COMPLEMENTO:", null, '14px', null),$cobranca_complemento],[new TLabel("BAIRRO:", null, '14px', null, '100%'),$cobranca_bairro],[new TLabel("CIDADE:", null, '14px', null, '100%'),$cobranca_cidade],[new TLabel("IBGE: ", null, '14px', null),$cobranca_cmun],[new TLabel("UF:", null, '14px', null, '100%'),$cobranca_uf],[new TLabel("CUF:", null, '14px', null),$cobranca_cuf]);
        $row4->layout = ['col-sm-2','col-sm-4','col-sm-2',' col-sm-4',' col-sm-3',' col-sm-3','col-sm-2',' col-sm-2','col-sm-2'];

        $row5 = $this->form->addFields([new TLabel(new TImage('fas:info-circle #3F51B5')."OBSERVAÇÃO DO CLIENTE:", '#3F51B5', '14px', 'B', '100%'),$observacoes],[new TLabel(new TImage('fas:map-marked #4CAF50')."LATITUDE:", '#4CAF50', '14px', 'B', '100%'),$cobranca_lat,new TLabel(new TImage('fas:map-marked-alt #03A9F4')."LONGITUDE:", '#03A9F4', '14px', 'B', '100%'),$cobranca_lng]);
        $row5->layout = [' col-sm-10','col-sm-2'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ClienteList', 'onShow']), 'fas:arrow-left #000000');
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

        $style = new TStyle('right-panel > .container-part[page-name=ClienteForm]');
        $style->width = '65% !important';   
        $style->show(true);

    }

    public static function onBuscarCep($param = null) 
    {
        try 
        {
        $Endereco= consultarCEP::CEP($param['cobranca_cep']);

          $object = new stdClass();
            $object->cobranca_endereco=  $Endereco->address;
            $object->cobranca_bairro=  $Endereco->district;
            $object->cobranca_uf=  $Endereco->state;
            $object->cobranca_cidade=  $Endereco->city;
            $object->cobranca_cuf=  substr($Endereco->city_ibge,0,2);
            $object->cobranca_lat=  $Endereco->lat;
            $object->cobranca_lng=  $Endereco->lng;

            $object->cobranca_cmun=  $Endereco->city_ibge;

        $object->system_unit_id = 'insira o novo valor aqui';

        TForm::sendData(self::$formName, $object);
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

            $object = new Cliente(); // create an empty object 

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
            TApplication::loadPage('ClienteList', 'onShow', $loadPageParam); 

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

                $object = new Cliente($key); // instantiates the Active Record 

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

