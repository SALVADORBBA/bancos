<?php

class WorkspacesSantanderForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'WorkspacesSantander';
    private static $primaryKey = 'id';
    private static $formName = 'form_WorkspacesSantanderForm';

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
        $this->form->setFormTitle("Cadastro de workspaces santander");

        $criteria_parametros_bancos_id = new TCriteria();

        $id = new TEntry('id');
        $status = new TEntry('status');
        $type = new TEntry('type');
        $description = new TEntry('description');
        $covenant_code = new TEntry('covenant_code');
        $bank_slip_billing_webhook_active = new TRadioGroup('bank_slip_billing_webhook_active');
        $pix_billing_webhook_active = new TRadioGroup('pix_billing_webhook_active');
        $id_remoto = new TEntry('id_remoto');
        $parametros_bancos_id = new TDBCombo('parametros_bancos_id', 'conecatarbanco', 'ParametrosBancos', 'id', '{apelido}','id asc' , $criteria_parametros_bancos_id );
        $webhookurl = new TEntry('webhookurl');

        $status->addValidation("Status", new TRequiredValidator()); 
        $type->addValidation("Type", new TRequiredValidator()); 
        $description->addValidation("Description", new TRequiredValidator()); 
        $covenant_code->addValidation("Covenant code", new TRequiredValidator()); 
        $parametros_bancos_id->addValidation("Parametros bancos id", new TRequiredValidator()); 

        $id->setEditable(false);
        $parametros_bancos_id->enableSearch();
        $pix_billing_webhook_active->addItems(["1"=>"Sim","2"=>"Não"]);
        $bank_slip_billing_webhook_active->addItems(["1"=>"Sim","2"=>"Não"]);

        $pix_billing_webhook_active->setLayout('horizontal');
        $bank_slip_billing_webhook_active->setLayout('horizontal');

        $pix_billing_webhook_active->setBooleanMode();
        $bank_slip_billing_webhook_active->setBooleanMode();

        $type->setMaxLength(10);
        $status->setMaxLength(10);
        $id_remoto->setMaxLength(255);
        $description->setMaxLength(255);
        $covenant_code->setMaxLength(36);

        $id->setSize(100);
        $type->setSize('100%');
        $status->setSize('100%');
        $id_remoto->setSize('100%');
        $webhookurl->setSize('100%');
        $description->setSize('100%');
        $covenant_code->setSize('100%');
        $parametros_bancos_id->setSize('100%');
        $pix_billing_webhook_active->setSize(80);
        $bank_slip_billing_webhook_active->setSize(80);

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Status:", '#ff0000', '14px', null, '100%'),$status],[new TLabel("Type:", '#ff0000', '14px', null, '100%'),$type],[new TLabel("Description:", '#ff0000', '14px', null, '100%'),$description]);
        $row1->layout = [' col-sm-2',' col-sm-3',' col-sm-3',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Covenant code:", '#ff0000', '14px', null, '100%'),$covenant_code],[new TLabel("Bank slip billing webhook active:", null, '14px', null, '100%'),$bank_slip_billing_webhook_active],[new TLabel("Pix billing webhook active:", null, '14px', null, '100%'),$pix_billing_webhook_active]);
        $row2->layout = [' col-sm-3',' col-sm-5',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Id remoto:", null, '14px', null, '100%'),$id_remoto],[new TLabel("Parametros bancos id:", '#ff0000', '14px', null, '100%'),$parametros_bancos_id],[new TLabel("Webhookurl:", null, '14px', null, '100%'),$webhookurl]);
        $row3->layout = ['col-sm-6','col-sm-6',' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['WorkspacesSantanderList', 'onShow']), 'fas:arrow-left #000000');
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

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new WorkspacesSantander(); // create an empty object 

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
            TApplication::loadPage('WorkspacesSantanderList', 'onShow', $loadPageParam); 

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

                $object = new WorkspacesSantander($key); // instantiates the Active Record 

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

