<?php

class AlterarVencimentoForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'CobrancaTitulo';
    private static $primaryKey = 'id';
    private static $formName = 'form_AlterarVencimentoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.50, null);
        parent::setTitle("AlterarVencimento");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("AlterarVencimento");


        $id = new TEntry('id');
        $data_vencimento = new TDate('data_vencimento');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $seunumero = new TEntry('seunumero');
        $cliente_nome = new TEntry('cliente_nome');


        $data_vencimento->setMask('dd/mm/yyyy');
        $data_vencimento->setDatabaseMask('yyyy-mm-dd');
        $valor->setMaxLength(12);
        $id->setEditable(false);
        $cliente_nome->setEditable(false);

        $id->setSize(100);
        $valor->setSize('100%');
        $seunumero->setSize('100%');
        $data_vencimento->setSize(220);
        $cliente_nome->setSize('100%');

        $row1 = $this->form->addFields([new TLabel(new TImage('fas:binoculars #000000')."CÓDIGO: ", null, '14px', null, '100%'),$id],[new TLabel(new TImage('fas:calendar-alt #000000')."DATA VENCIMENTO:", null, '14px', null, '100%'),$data_vencimento],[new TLabel(new TImage('fas:barcode #000000')."VALOR BOLETO: ", null, '14px', null, '100%'),$valor],[new TLabel(new TImage('fas:sort-numeric-up #000000')."NÚMERO: ", null, '14px', null),$seunumero],[new TLabel(new TImage('fas:user-circle #000000')."CLIENTE:", null, '14px', null),$cliente_nome]);
        $row1->layout = [' col-sm-2',' col-sm-3',' col-sm-3',' col-sm-4',' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new CobrancaTitulo(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data

            sleep(1);
                $response=  DirecionadorClass::UpdateBoleto($param['id']);
            dd( $response);
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle'); 

                TWindow::closeWindow(parent::getId()); 

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

                $object = new CobrancaTitulo($key); // instantiates the Active Record 

                                $object->cliente_nome = $object->cliente->nome;

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

