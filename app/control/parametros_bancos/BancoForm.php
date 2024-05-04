<?php

class BancoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'Banco';
    private static $primaryKey = 'id';
    private static $formName = 'form_BancoForm';

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
        $this->form->setFormTitle("Cadastro de banco");


        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $numero = new TEntry('numero');
        $descricao = new TEntry('descricao');
        $apelido = new TEntry('apelido');
        $logo = new TFile('logo');
        $status = new TRadioGroup('status');
        $manuais_documento = new TMultiFile('manuais_documento');


        $id->setEditable(false);
        $logo->enableImageGallery('200', NULL);
        $status->addItems(["1"=>"ATIVO","2"=>"INATIVO"]);
        $status->setLayout('horizontal');
        $status->setUseButton();
        $manuais_documento->setAllowedExtensions(["pdf","doc","docx"]);
        $status->setValue('2');
        $system_unit_id->setValue(TSession::getValue("userunitid"));

        $logo->enableFileHandling();
        $manuais_documento->enableFileHandling();

        $numero->setMaxLength(255);
        $apelido->setMaxLength(100);
        $descricao->setMaxLength(255);

        $id->setSize(100);
        $logo->setSize('100%');
        $numero->setSize('100%');
        $status->setSize('100%');
        $apelido->setSize('100%');
        $descricao->setSize('100%');
        $system_unit_id->setSize(200);
        $manuais_documento->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id,$system_unit_id],[new TLabel("Numero:", null, '14px', null, '100%'),$numero],[new TLabel("Descrição: ", null, '14px', null, '100%'),$descricao],[new TLabel("Apelido:", null, '14px', null, '100%'),$apelido]);
        $row1->layout = [' col-sm-2',' col-sm-2',' col-sm-5',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Logo:", null, '14px', null, '100%'),$logo],[new TLabel("Status:", null, '14px', null, '100%'),$status]);
        $row2->layout = [' col-sm-8',' col-sm-4'];

        $row3 = $this->form->addContent([new TFormSeparator("ARQUIVO E MANUAIS", '#4CAF50', '18', '#009688')]);
        $row4 = $this->form->addFields([$manuais_documento]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['BancoList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new Banco(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $logo_dir = 'logo/bancos';
            $manuais_documento_dir = 'manuais'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'logo', $logo_dir);
            $files_manuais_documento = $this->saveFiles($object, $data, 'manuais_documento', $manuais_documento_dir, 'ManualIntegracao', 'arquivo', 'banco_id');
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
            TApplication::loadPage('BancoList', 'onShow', $loadPageParam); 

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

                $object = new Banco($key); // instantiates the Active Record 

                                $object->manuais_documento  = ManualIntegracao::where('banco_id', '=', $object->id)->getIndexedArray('id','arquivo');

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

