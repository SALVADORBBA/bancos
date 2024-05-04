<?php

class LayoutBancosForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'LayoutBancos';
    private static $primaryKey = 'id';
    private static $formName = 'form_MillLayoutBancosForm';

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
        $this->form->setFormTitle("Cadastro de mill layout bancos");

        $criteria_bancos_modulos_id = new TCriteria();

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $bancos_modulos_id = new TDBCombo('bancos_modulos_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_bancos_modulos_id );
        $status = new TRadioGroup('status');
        $codigo_layout = new TEntry('codigo_layout');
        $tipo_layout = new TCombo('tipo_layout');
        $nome_arquivo_php = new TEntry('nome_arquivo_php');
        $nome_arquivo_css = new TEntry('nome_arquivo_css');
        $logomarca = new TFile('logomarca');
        $imagem_layout = new TFile('imagem_layout');

        $status->addValidation("Status", new TRequiredValidator()); 
        $logomarca->addValidation("logo", new TRequiredValidator()); 

        $id->setEditable(false);
        $status->setLayout('horizontal');
        $status->setUseButton();
        $status->setBreakItems(2);
        $nome->setMaxLength(255);
        $codigo_layout->setMaxLength(255);

        $tipo_layout->enableSearch();
        $bancos_modulos_id->enableSearch();

        $status->addItems(["1"=>"Liberado","2"=>"Bloqueado  "]);
        $tipo_layout->addItems(["Normal"=>"Normal","Hibrido"=>"Hibrido"]);

        $logomarca->enableFileHandling();
        $imagem_layout->enableFileHandling();

        $logomarca->enableImageGallery('150', NULL);
        $imagem_layout->enableImageGallery('600', NULL);

        $nome->setValue('NULL');
        $tipo_layout->setValue('NULL');
        $codigo_layout->setValue('NULL');
        $bancos_modulos_id->setValue('NULL');

        $id->setSize(100);
        $nome->setSize('100%');
        $status->setSize('100%');
        $logomarca->setSize('100%');
        $tipo_layout->setSize('100%');
        $codigo_layout->setSize('100%');
        $imagem_layout->setSize('100%');
        $nome_arquivo_php->setSize('100%');
        $nome_arquivo_css->setSize('100%');
        $bancos_modulos_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Nome:", null, '14px', null, '100%'),$nome],[new TLabel("Banco Relacionado:", null, '14px', null, '100%'),$bancos_modulos_id],[new TLabel("Status: ", null, '14px', null, '100%'),$status]);
        $row1->layout = ['col-sm-2',' col-sm-3','col-sm-4',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Codigo layout:", null, '14px', null, '100%'),$codigo_layout],[new TLabel("Tipo layout:", null, '14px', null, '100%'),$tipo_layout]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Rótulo:", null, '14px', null),$nome_arquivo_php],[new TLabel("Rótulo:", null, '14px', null),$nome_arquivo_css]);
        $row3->layout = [' col-sm-6',' col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Logomarca:", null, '14px', null, '100%'),$logomarca],[new TLabel("Imegem do layout: ", null, '14px', null),$imagem_layout]);
        $row4->layout = [' col-sm-12',' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['LayoutBancosList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new LayoutBancos(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $logomarca_dir = 'logomarca';
            $imagem_layout_dir = 'imagem_lyout'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'logomarca', $logomarca_dir);
            $this->saveFile($object, $data, 'imagem_layout', $imagem_layout_dir);
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
            TApplication::loadPage('LayoutBancosList', 'onShow', $loadPageParam); 

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

                $object = new LayoutBancos($key); // instantiates the Active Record 

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

