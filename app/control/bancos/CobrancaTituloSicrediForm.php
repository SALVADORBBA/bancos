<?php

class CobrancaTituloSicrediForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'CobrancaTitulo';
    private static $primaryKey = 'id';
    private static $formName = 'form_CobrancaTituloForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.65, null);
        parent::setTitle("Cobrança Geral");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cobrança Geral");

        $criteria_beneficiario_id = new TCriteria();
        $criteria_bancos_modulos_id = new TCriteria();
        $criteria_cliente_id = new TCriteria();

        $filterVar = "1";
        $criteria_bancos_modulos_id->add(new TFilter('status', '=', $filterVar)); 
        $filterVar = "1";
        $criteria_cliente_id->add(new TFilter('status', '=', $filterVar)); 

        $system_unit_id = new THidden('system_unit_id');
        $user_id = new THidden('user_id');
        $id = new TEntry('id');
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{cnpj}  - {nome}','id asc' , $criteria_beneficiario_id );
        $bancos_modulos_id = new TDBCombo('bancos_modulos_id', 'conecatarbanco', 'Banco', 'id', '{numero} {descricao}','apelido asc' , $criteria_bancos_modulos_id );
        $parametros_bancos_id = new TCombo('parametros_bancos_id');
        $cliente_id = new TDBCombo('cliente_id', 'conecatarbanco', 'Cliente', 'id', '{cpf_cnpj} -  {nome}','id asc' , $criteria_cliente_id );
        $data_vencimento = new TDate('data_vencimento');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $identificador = new TEntry('identificador');

        $bancos_modulos_id->setChangeAction(new TAction([$this,'onChangebancos_modulos_id']));

        $beneficiario_id->addValidation("beneficiario", new TRequiredValidator()); 
        $bancos_modulos_id->addValidation("banco", new TRequiredValidator()); 
        $parametros_bancos_id->addValidation("parametro", new TRequiredValidator()); 
        $cliente_id->addValidation("cliente", new TRequiredValidator()); 
        $data_vencimento->addValidation("data vencimento", new TRequiredValidator()); 
        $valor->addValidation("valor boleto", new TRequiredValidator()); 

        $id->setEditable(false);
        $data_vencimento->setMask('dd/mm/yyyy');
        $data_vencimento->setDatabaseMask('yyyy-mm-dd');
        $cliente_id->enableSearch();
        $beneficiario_id->enableSearch();
        $bancos_modulos_id->enableSearch();
        $parametros_bancos_id->enableSearch();

        $cliente_id->setValue('NULL');
        $data_vencimento->setValue(' ');
        $beneficiario_id->setValue('NULL');
        $parametros_bancos_id->setValue('NULL');
        $user_id->setValue(TSession::getValue("userid"));
        $system_unit_id->setValue(TSession::getValue("userunitid"));

        $id->setSize(100);
        $user_id->setSize(200);
        $valor->setSize('100%');
        $cliente_id->setSize('100%');
        $system_unit_id->setSize(200);
        $data_vencimento->setSize(160);
        $identificador->setSize('100%');
        $beneficiario_id->setSize('100%');
        $bancos_modulos_id->setSize('100%');
        $parametros_bancos_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("CÓDIGO: ", null, '14px', null, '100%'),$system_unit_id,$user_id,$id],[new TLabel("BENEFICIARIO:", null, '14px', null, '100%'),$beneficiario_id],[new TLabel("BANCO:", null, '14px', null, '100%'),$bancos_modulos_id],[new TLabel("PARAMETROS BANCO:", null, '14px', null, '100%'),$parametros_bancos_id]);
        $row1->layout = [' col-sm-2',' col-sm-4',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel(new TImage('fas:user-alt #FF9800')."CLIENTE:", '#FF9800', '14px', 'B', '100%'),$cliente_id],[new TLabel(new TImage('fas:calendar-check #673AB7')."VENCIMENTO:", '#673AB7', '14px', 'B', '100%'),$data_vencimento],[new TLabel(new TImage('fas:dollar-sign #4CAF50')."VALOR:", '#4CAF50', '14px', 'B', '100%'),$valor],[new TLabel(new TImage('fas:map-signs #000000')."LOCALIZADOR:", null, '14px', 'B'),$identificador]);
        $row2->layout = [' col-sm-5','col-sm-3','col-sm-2','col-sm-2'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['CobrancaTituloList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::add($this->form);

    }

    public static function onChangebancos_modulos_id($param)
    {
        try
        {

            if (isset($param['bancos_modulos_id']) && $param['bancos_modulos_id'])
            { 
                $criteria = TCriteria::create(['banco_id' => $param['bancos_modulos_id']]);
                TDBCombo::reloadFromModel(self::$formName, 'parametros_bancos_id', 'conecatarbanco', 'ParametrosBancos', 'id', '{apelido}', 'id asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'parametros_bancos_id'); 
            }  

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

            $object = new CobrancaTitulo(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $this->fireEvents($object);

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
            TApplication::loadPage('CobrancaTituloList', 'onShow', $loadPageParam); 

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

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

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

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->bancos_modulos_id))
            {
                $value = $object->bancos_modulos_id;

                $obj->bancos_modulos_id = $value;
            }
            if(isset($object->parametros_bancos_id))
            {
                $value = $object->parametros_bancos_id;

                $obj->parametros_bancos_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->bancos_modulos_id))
            {
                $value = $object->bancos_modulos_id;

                $obj->bancos_modulos_id = $value;
            }
            if(isset($object->parametros_bancos_id))
            {
                $value = $object->parametros_bancos_id;

                $obj->parametros_bancos_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public static function getFormName()
    {
        return self::$formName;
    }

}

