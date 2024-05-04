<?php

class ParametrosBancosList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'ParametrosBancos';
    private static $primaryKey = 'id';
    private static $formName = 'form_ParametrosBancosList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de Parâmetros Bancos");
        $this->limit = 20;

        $criteria_banco_id = new TCriteria();
        $criteria_beneficiario_id = new TCriteria();

        $filterVar = "1";
        $criteria_banco_id->add(new TFilter('status', '=', $filterVar)); 

        $id = new TEntry('id');
        $banco_id = new TDBCombo('banco_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_banco_id );
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{id}','id asc' , $criteria_beneficiario_id );


        $banco_id->enableSearch();
        $beneficiario_id->enableSearch();

        $id->setSize(100);
        $banco_id->setSize('100%');
        $beneficiario_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("BANCO: ", null, '14px', null, '100%'),$banco_id],[new TLabel("BENEFICIÁRIOS:", null, '14px', null, '100%'),$beneficiario_id]);
        $row1->layout = ['col-sm-2',' col-sm-5',' col-sm-5'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $dropdownHeader = new TDropDown("Cadastro de Parametros", 'fas:university #000000');
        $dropdownHeader->setPullSide('right');
        $dropdownHeader->setButtonClass('btn btn-sm btn-default dropdown-toggle');

        $btn_onedit = $dropdownHeader->addPostAction("Cadastrar Sicredi", new TAction(['ParametrosBancosSicrediForm', 'onEdit']), self::$formName, 'fas:plus #69aa46');
        $this->btn_onedit = $btn_onedit;
        $btn_onshow = $dropdownHeader->addPostAction("Cadastrar  Itau", new TAction(['ParametrosBancosItauForm', 'onShow']), self::$formName, 'fas:plus #4CAF50');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow = $dropdownHeader->addPostAction("Cadastrar  Sicoob", new TAction(['ParametrosBancosSicoobForm', 'onShow']), self::$formName, 'fas:plus #4CAF50');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow = $dropdownHeader->addPostAction("Cadastrar  Santader", new TAction(['ParametrosBancosSantaderForm', 'onShow']), self::$formName, 'fas:plus #4CAF50');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow = $dropdownHeader->addPostAction("Cadastrar  Banco do Brasil", new TAction(['ParametrosBancosBBForm', 'onShow']), self::$formName, 'fas:plus #4CAF50');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow = $dropdownHeader->addPostAction("Cadastrar Banrisul", new TAction(['ParametrosBancosBanrisulForm', 'onShow']), self::$formName, 'fas:plus #4CAF50');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow = $dropdownHeader->addPostAction("Cadastrar  Bradesco", new TAction(['ParametrosBancosBradescoForm', 'onShow']), self::$formName, 'fas:plus #4CAF50');
        $this->btn_onshow = $btn_onshow;

        $this->form->addHeaderWidget( $dropdownHeader );

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_banco_apelido = new TDataGridColumn('banco->apelido', "BANCO", 'left');
        $column_banco_logo_transformed = new TDataGridColumn('banco->logo', "", 'left');
        $column_apelido = new TDataGridColumn('apelido', "PARÂMETRO", 'left');
        $column_beneficiario_nome = new TDataGridColumn('beneficiario->nome', "BENFICIÁRIO", 'left');
        $column_status_transformed = new TDataGridColumn('status', "STATUS", 'left');

        $column_banco_logo_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
                    if($value){
        return '<img src="' . $value . '" alt="Imagem" style="width: 80px;" class="rounded-image" />';

                   }

        });

        $column_status_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
           $label = new TElement('span');
            $label->{'class'} = 'label label-';

            if ($value == '1') {
                $label->{'class'} .= 'success';
                $label->add('Habilitado');    

                return $label;
            }

            $label->{'class'} .= 'danger';
            $label->add('Desabilitado');

            return $label;

        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_banco_apelido);
        $this->datagrid->addColumn($column_banco_logo_transformed);
        $this->datagrid->addColumn($column_apelido);
        $this->datagrid->addColumn($column_beneficiario_nome);
        $this->datagrid->addColumn($column_status_transformed);

        $action_Oneditar = new TDataGridAction(array('ParametrosBancosList', 'Oneditar'));
        $action_Oneditar->setUseButton(true);
        $action_Oneditar->setButtonClass('btn btn-default btn-sm');
        $action_Oneditar->setLabel("Editar");
        $action_Oneditar->setImage('far:edit #2196F3');
        $action_Oneditar->setField(self::$primaryKey);

        $action_Oneditar->setParameter('tipo', '{banco_id}');

        $this->datagrid->addAction($action_Oneditar);

        $action_onDelete = new TDataGridAction(array('ParametrosBancosList', 'onDelete'));
        $action_onDelete->setUseButton(true);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);
        $action_onDelete->setDisplayCondition('ParametrosBancosList::DesabilitarExcluir');

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';
        $headerActions->style = 'justify-content: space-between;';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel->getBody()->insert(0, $headerActions);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['ParametrosBancosList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('btn-default');
        $button_limpar_filtros->setImage('fas:eraser #f44336');

        $this->datagrid_form->addField($button_limpar_filtros);

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['ParametrosBancosList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $head_left_actions->add($button_limpar_filtros);
        $head_left_actions->add($button_atualizar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Parâmetros Bancos","Parametros bancoss"]));
        }
        $container->add($this->form);

        $container->add($panel);

        parent::add($container);

    }

    public function Oneditar($param = null) 
    {
        try 
        {
         switch ($param['tipo']) {
       case 3:
        $pageParam = ['key' => $param['key'],'tipo' => $param['tipo']];
        TApplication::loadPage('ParametrosBancosSicrediForm', 'onEdit', $pageParam);
        break;

        case 4:
       $pageParam = ['key' => $param['key'],'tipo' => $param['tipo']];
        TApplication::loadPage('ParametrosBancosItauForm', 'onEdit', $pageParam);
        break;

    case 5:
        $pageParam = ['key' => $param['key']];
        TApplication::loadPage('ParametrosBancosSantaderForm', 'onEdit', $pageParam);
        break;

          case 1:
        $pageParam = ['key' => $param['key']];
        TApplication::loadPage('ParametrosBancosSicoobForm', 'onEdit', $pageParam);
        break;

            case 2:
        $pageParam = ['key' => $param['key']];
        TApplication::loadPage('ParametrosBancosBBForm', 'onEdit', $pageParam);
        break;

        case 6:
        $pageParam = ['key' => $param['key']];
        TApplication::loadPage('ParametrosBancosBradescoForm', 'onEdit', $pageParam);
        break;

       case 7:
        $pageParam = ['key' => $param['key']];
        TApplication::loadPage('ParametrosBancosCEFForm', 'onEdit', $pageParam);
        break;

           case 8:
        $pageParam = ['key' => $param['key']];
        TApplication::loadPage('ParametrosBancosBanrisulForm', 'onEdit', $pageParam);
        break;

    // default:
    //     $pageParam = ['key' => $param['key']];
    //     TApplication::loadPage('ParametrosBancosSicrediForm', 'onEdit', $pageParam);
    //     break;
}

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new ParametrosBancos($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
    public static function DesabilitarExcluir($object)
    {
        try 
        {
            if($object)
            {
                return false;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onClearFilters($param = null) 
    {
        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }
    public function onRefresh($param = null) 
    {
        $this->onReload([]);
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->banco_id) AND ( (is_scalar($data->banco_id) AND $data->banco_id !== '') OR (is_array($data->banco_id) AND (!empty($data->banco_id)) )) )
        {

            $filters[] = new TFilter('banco_id', '=', $data->banco_id);// create the filter 
        }

        if (isset($data->beneficiario_id) AND ( (is_scalar($data->beneficiario_id) AND $data->beneficiario_id !== '') OR (is_array($data->beneficiario_id) AND (!empty($data->beneficiario_id)) )) )
        {

            $filters[] = new TFilter('beneficiario_id', '=', $data->beneficiario_id);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'conecatarbanco'
            TTransaction::open(self::$database);

            // creates a repository for ParametrosBancos
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new ParametrosBancos($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

