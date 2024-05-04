<?php

class ControleMeuNumerosFormSicredi extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'ControleMeuNumeros';
    private static $primaryKey = 'id';
    private static $formName = 'form_ControleMeuNumerosForm';

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
        $this->form->setFormTitle("Cadastro de controle meu numeros");

        $criteria_parametros_bancos_id = new TCriteria();
        $criteria_banco_id = new TCriteria();

        $id = new TEntry('id');
        $status = new THidden('status');
        $system_unit_id = new THidden('system_unit_id');
        $parametros_bancos_id = new TDBCombo('parametros_bancos_id', 'conecatarbanco', 'ParametrosSicredi', 'id', '{apelido}','id asc' , $criteria_parametros_bancos_id );
        $banco_id = new TDBCombo('banco_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_banco_id );
        $ultimo_numero = new TEntry('ultimo_numero');
        $numero_anterior = new TEntry('numero_anterior');


        $parametros_bancos_id->enableSearch();
        $banco_id->setDefaultOption(false);
        $parametros_bancos_id->setDefaultOption(false);

        $id->setEditable(false);
        $banco_id->setEditable(false);
        $parametros_bancos_id->setEditable(false);

        $status->setValue('livre');
        $ultimo_numero->setValue('NULL');
        $numero_anterior->setValue('NULL');
        $parametros_bancos_id->setValue('NULL');
        $banco_id->setValue($param["banco_id"] ?? "");
        $system_unit_id->setValue(TSession::getValue("userunitid"));

        $id->setSize(100);
        $status->setSize(200);
        $banco_id->setSize('100%');
        $system_unit_id->setSize(200);
        $ultimo_numero->setSize('100%');
        $numero_anterior->setSize('100%');
        $parametros_bancos_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("CÓDIGO: ", null, '14px', null, '100%'),$id,$status,$system_unit_id],[new TLabel("PARAMETRO BANCO: ", null, '14px', null, '100%'),$parametros_bancos_id],[new TLabel("BANCO:", null, '14px', null),$banco_id]);
        $row1->layout = [' col-sm-2','col-sm-6',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Ultimo numero:", null, '14px', null, '100%'),$ultimo_numero],[new TLabel("Numero anterior:", null, '14px', null, '100%'),$numero_anterior]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ControleMeuNumerosList', 'onShow']), 'fas:arrow-left #000000');
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

            $object = new ControleMeuNumeros(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle'); 

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

                $object = new ControleMeuNumeros($key); // instantiates the Active Record 

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

    if($param){
             TTransaction::open(self::$database);

                $objeto = ControleMeuNumeros::where('parametros_bancos_id', '=', $param['parametro_id'])->
                                               where('banco_id', '=', $param['banco_id'])->orderBy('ultimo_numero','desc')->first();

                // Código gerado pelo snippet: "Enviar dados para campo"
                $object = new stdClass();

                if(isset($objeto)){
                $object->ultimo_numero = $objeto->ultimo_numero;
                $object->id =$objeto->id;
                //$object->fieldName = 'insira o novo valor aqui'; //sample
                }else{
                $object->id = $objeto->id;
                $object->ultimo_numero = 0;
                }
                TForm::sendData(self::$formName, $object);
                // -----

                TTransaction::close();

    }
    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

