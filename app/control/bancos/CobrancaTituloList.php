<?php

class CobrancaTituloList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'CobrancaTitulo';
    private static $primaryKey = 'id';
    private static $formName = 'form_CobrancaTituloList';
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
        $this->form->setFormTitle("Listagem de cobranca titulos");
        $this->limit = 20;

        $id = new TEntry('id');
        $beneficiario_id = new TEntry('beneficiario_id');
        $cliente_id = new TEntry('cliente_id');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $system_unit_id = new TEntry('system_unit_id');
        $parametros_bancos_id = new TEntry('parametros_bancos_id');


        $id->setSize(100);
        $valor->setSize('100%');
        $cliente_id->setSize('100%');
        $system_unit_id->setSize('100%');
        $beneficiario_id->setSize('100%');
        $parametros_bancos_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Beneficiario id:", null, '14px', null, '100%'),$beneficiario_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Cliente id:", null, '14px', null, '100%'),$cliente_id],[new TLabel("Valor:", null, '14px', null, '100%'),$valor]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("System unit id:", null, '14px', null, '100%'),$system_unit_id],[new TLabel("Parametros bancos id:", null, '14px', null, '100%'),$parametros_bancos_id]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_id = new TDataGridColumn('id', "Código", 'center' , '70px');
        $column_beneficiario_nome = new TDataGridColumn('beneficiario->nome', "BENEFICIÁRIO", 'left');
        $column_cliente_nome = new TDataGridColumn('cliente->nome', "CLIENTE", 'left');
        $column_parametros_bancos_banco_logo_transformed = new TDataGridColumn('parametros_bancos->banco->logo', "PARAMETRO", 'left');
        $column_seunumero = new TDataGridColumn('seunumero', "SEU NÚMERO:", 'left');
        $column_data_vencimento_transformed = new TDataGridColumn('data_vencimento', "VENCIMENTO", 'left');
        $column_vencimento_situacao = new TDataGridColumn('vencimento_situacao', "SITUAÇÃO", 'left');
        $column_valor_transformed = new TDataGridColumn('valor', "VALOR", 'left');

        $column_valor_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_parametros_bancos_banco_logo_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
                    if($value){
        return '<img src="' . $value . '" alt="Imagem" style="width: 80px;" class="rounded-image" />';

                   }

        });

        $column_data_vencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_beneficiario_nome);
        $this->datagrid->addColumn($column_cliente_nome);
        $this->datagrid->addColumn($column_parametros_bancos_banco_logo_transformed);
        $this->datagrid->addColumn($column_seunumero);
        $this->datagrid->addColumn($column_data_vencimento_transformed);
        $this->datagrid->addColumn($column_vencimento_situacao);
        $this->datagrid->addColumn($column_valor_transformed);

        $action_group = new TDataGridActionGroup("Ações", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('CobrancaTituloSicrediForm', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar Boleto");
        $action_onEdit->setImage('fas:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_onTramitirBanco = new TDataGridAction(array('CobrancaTituloList', 'onTramitirBanco'));
        $action_onTramitirBanco->setUseButton(TRUE);
        $action_onTramitirBanco->setButtonClass('btn btn-default');
        $action_onTramitirBanco->setLabel("Gerar Boleto");
        $action_onTramitirBanco->setImage('fas:paper-plane #4CAF50');
        $action_onTramitirBanco->setField(self::$primaryKey);
        $action_onTramitirBanco->setDisplayCondition('CobrancaTituloList::OndesabilitarGerar');

        $action_group->addAction($action_onTramitirBanco);

        $action_OnCosultar = new TDataGridAction(array('CobrancaTituloList', 'OnCosultar'));
        $action_OnCosultar->setUseButton(TRUE);
        $action_OnCosultar->setButtonClass('btn btn-default');
        $action_OnCosultar->setLabel("Consultar Boleto");
        $action_OnCosultar->setImage('fas:search-dollar #3F51B5');
        $action_OnCosultar->setField(self::$primaryKey);
        $action_OnCosultar->setDisplayCondition('CobrancaTituloList::ondesabilitarCosultar');

        $action_group->addAction($action_OnCosultar);

        $action_onPrint = new TDataGridAction(array('CobrancaTituloList', 'onPrint'));
        $action_onPrint->setUseButton(TRUE);
        $action_onPrint->setButtonClass('btn btn-default');
        $action_onPrint->setLabel("Imprimir");
        $action_onPrint->setImage('fas:file-pdf #F44336');
        $action_onPrint->setField(self::$primaryKey);
        $action_onPrint->setDisplayCondition('CobrancaTituloList::OndesabilitarPrint');

        $action_group->addAction($action_onPrint);

        $action_OnsendEmail = new TDataGridAction(array('CobrancaTituloList', 'OnsendEmail'));
        $action_OnsendEmail->setUseButton(TRUE);
        $action_OnsendEmail->setButtonClass('btn btn-default');
        $action_OnsendEmail->setLabel("Enviar E-mail");
        $action_OnsendEmail->setImage('fas:envelope #8BC34A');
        $action_OnsendEmail->setField(self::$primaryKey);
        $action_OnsendEmail->setDisplayCondition('CobrancaTituloList::ondesabilitarSendemail');

        $action_group->addAction($action_OnsendEmail);

        $action_OnBaixar = new TDataGridAction(array('CobrancaTituloList', 'OnBaixar'));
        $action_OnBaixar->setUseButton(TRUE);
        $action_OnBaixar->setButtonClass('btn btn-default');
        $action_OnBaixar->setLabel("Baixar");
        $action_OnBaixar->setImage('fas:cloud-download-alt #000000');
        $action_OnBaixar->setField(self::$primaryKey);
        $action_OnBaixar->setDisplayCondition('CobrancaTituloList::onOffBaixar');

        $action_group->addAction($action_OnBaixar);

        $action_Onclonar = new TDataGridAction(array('CobrancaTituloList', 'Onclonar'));
        $action_Onclonar->setUseButton(TRUE);
        $action_Onclonar->setButtonClass('btn btn-default');
        $action_Onclonar->setLabel("Clonar");
        $action_Onclonar->setImage('fas:copy #FFC107');
        $action_Onclonar->setField(self::$primaryKey);

        $action_group->addAction($action_Onclonar);

        $action_OnSeandWhatsapp = new TDataGridAction(array('CobrancaTituloList', 'OnSeandWhatsapp'));
        $action_OnSeandWhatsapp->setUseButton(TRUE);
        $action_OnSeandWhatsapp->setButtonClass('btn btn-default');
        $action_OnSeandWhatsapp->setLabel("Enviar WhatsApp");
        $action_OnSeandWhatsapp->setImage('fas:comment-dots #009688');
        $action_OnSeandWhatsapp->setField(self::$primaryKey);
        $action_OnSeandWhatsapp->setDisplayCondition('CobrancaTituloList::Onoffwhats');

        $action_group->addAction($action_OnSeandWhatsapp);

        $action_AlterarVencimentoForm_onEdit = new TDataGridAction(array('AlterarVencimentoForm', 'onEdit'));
        $action_AlterarVencimentoForm_onEdit->setUseButton(TRUE);
        $action_AlterarVencimentoForm_onEdit->setButtonClass('btn btn-default');
        $action_AlterarVencimentoForm_onEdit->setLabel("Altera Boleto");
        $action_AlterarVencimentoForm_onEdit->setImage('fas:edit #000000');
        $action_AlterarVencimentoForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_AlterarVencimentoForm_onEdit);

        $this->datagrid->addActionGroup($action_group);    

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de cobranca titulos");
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

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['CobrancaTituloList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $button_cadastrar = new TButton('button_button_cadastrar');
        $button_cadastrar->setAction(new TAction(['CobrancaTituloSicrediForm', 'onShow']), "Cadastrar");
        $button_cadastrar->addStyleClass('btn-default');
        $button_cadastrar->setImage('fas:plus #69aa46');

        $this->datagrid_form->addField($button_cadastrar);

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['CobrancaTituloList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['CobrancaTituloList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['CobrancaTituloList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['CobrancaTituloList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['CobrancaTituloList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_left_actions->add($button_atualizar);
        $head_left_actions->add($button_cadastrar);
        $head_left_actions->add($btnShowCurtainFilters);

        $head_right_actions->add($dropdown_button_exportar);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Bancos","Cobranca titulos"]));
        }

        $container->add($panel);

        parent::add($container);

    }

    public function onTramitirBanco($param = null) 
    {
        try 
        {

    TTransaction::open(self::$database);
    $response=  DirecionadorClass::createBoleto($param['id']);
    TTransaction::close();
    // Executa a ação onReload() - pode estar relacionada a recarregar dados ou uma ação específica

    $this->onReload();
            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function OndesabilitarGerar($object)
    {
        try 
        {
                if ($object->status != 5 && isset($object->data_vencimento)) {
                return true;
                }

                return false;

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function OnCosultar($param = null) 
    {
        try 
        {
            TTransaction::open(self::$database);
            $response=DirecionadorClass::ConsultaseBoleto($param['id']);
            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function ondesabilitarCosultar($object)
    {
        try 
        {
             if($object->status==5)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onPrint($param = null) 
    {
        try 
        {

            TTransaction::open(self::$database);
            $response=DirecionadorClass::PrintBoleto($param['id']);

            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function OndesabilitarPrint($object)
    {
        try 
        {
            if($object->status!=1)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function OnsendEmail($param = null) 
    {
        try 
        {
///////////envio de email via class///////////////
TTransaction::open(self::$database);
$response=DirecionadorClass::SendEmailBoleto($param['id']);
TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function ondesabilitarSendemail($object)
    {
        try 
        {
        if($object->status==5)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function OnBaixar($param = null) 
    {
        try 
        {

        new TQuestion("DESEJA REALMENTE BAIXAR ESSE BOLETO", new TAction([__CLASS__, 'onYes'], $param), new TAction([__CLASS__, 'onNo'], $param));

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onOffBaixar($object)
    {
        try 
        {
          if($object->status==5)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function Onclonar($param = null) 
    {
        try 
        {

                TTransaction::open(self::$database);
                $titulo = new CobrancaTitulo($param['id']);
                $tituloClone = clone $titulo;
                unset($param['id']);
                $tituloClone->nome = $titulo->title.' Clone';
                $tituloClone->linhadigitavel =  null;
                $tituloClone->caminho_boleto =  null;
                $tituloClone->data_baixa = null ;
                $tituloClone->numero_bb =   null;
                $tituloClone->qrcode =  null;
                $tituloClone->codigobarras =  null ;
                $tituloClone->identifica = null ;
                $tituloClone->data_vencimento = null ;
                $tituloClone->seunumero = null ;
                $tituloClone->xml_create_boleto = null ;
                $tituloClone->identificador = null ;
                $tituloClone->created_at = date('Y-m-d H:i:s');
                $tituloClone->updated_at = null ;
                $tituloClone->databaixa =  null ;
                $tituloClone->horariobaixa = null ;
                $tituloClone->user_id =  TSession::getValue('userid');
                $tituloClone->status = 1;
                $tituloClone->store();
                TTransaction::close();

                $this->onReload();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function OnSeandWhatsapp($param = null) 
    {
        try 
        {

        TTransaction::open(self::$database);
        $Send= new EnviarWhatsGenerico($param['key']);
        $response= $Send->send();
        TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function Onoffwhats($object)
    {
        try 
        {
          if($object->status!=1)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onExportCsv($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.csv';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    $handler = fopen($output, 'w');
                    TTransaction::open(self::$database);

                    foreach ($objects as $object)
                    {
                        $row = [];
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();

                            if (isset($object->$column_name))
                            {
                                $row[] = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $row[] = $object->render($column_name);
                            }
                        }

                        fputcsv($handler, $row);
                    }

                    fclose($handler);
                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportXls($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xls';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $widths = [];
                $titles = [];

                foreach ($this->datagrid->getColumns() as $column)
                {
                    $titles[] = $column->getLabel();
                    $width    = 100;

                    if (is_null($column->getWidth()))
                    {
                        $width = 100;
                    }
                    else if (strpos((string)$column->getWidth(), '%') !== false)
                    {
                        $width = ((int) $column->getWidth()) * 5;
                    }
                    else if (is_numeric($column->getWidth()))
                    {
                        $width = $column->getWidth();
                    }

                    $widths[] = $width;
                }

                $table = new \TTableWriterXLS($widths);
                $table->addStyle('title',  'Helvetica', '10', 'B', '#ffffff', '#617FC3');
                $table->addStyle('data',   'Helvetica', '10', '',  '#000000', '#FFFFFF', 'LR');

                $table->addRow();

                foreach ($titles as $title)
                {
                    $table->addCell($title, 'center', 'title');
                }

                $this->limit = 0;
                $objects = $this->onReload();

                TTransaction::open(self::$database);
                if ($objects)
                {
                    foreach ($objects as $object)
                    {
                        $table->addRow();
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $value = '';
                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                            }

                            $transformer = $column->getTransformer();
                            if ($transformer)
                            {
                                $value = strip_tags(call_user_func($transformer, $value, $object, null));
                            }

                            $table->addCell($value, 'center', 'data');
                        }
                    }
                }
                $table->save($output);
                TTransaction::close();

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportPdf($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.pdf';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $this->datagrid->prepareForPrinting();
                $this->onReload();

                $html = clone $this->datagrid;
                $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();

                $dompdf = new \Dompdf\Dompdf;
                $dompdf->loadHtml($contents);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                file_put_contents($output, $dompdf->output());

                $window = TWindow::create('PDF', 0.8, 0.8);
                $object = new TElement('iframe');
                $object->src  = $output;
                $object->type  = 'application/pdf';
                $object->style = "width: 100%; height:calc(100% - 10px)";

                $window->add($object);
                $window->show();
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportXml($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xml';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    TTransaction::open(self::$database);

                    $dom = new DOMDocument('1.0', 'UTF-8');
                    $dom->{'formatOutput'} = true;
                    $dataset = $dom->appendChild( $dom->createElement('dataset') );

                    foreach ($objects as $object)
                    {
                        $row = $dataset->appendChild( $dom->createElement( self::$activeRecord ) );

                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $column_name_raw = str_replace(['(','{','->', '-','>','}',')', ' '], ['','','_','','','','','_'], $column_name);

                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                                $row->appendChild($dom->createElement($column_name_raw, $value)); 
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                                $row->appendChild($dom->createElement($column_name_raw, $value));
                            }
                        }
                    }

                    $dom->save($output);

                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onRefresh($param = null) 
    {
        $this->onReload([]);
    }
    public function onShowCurtainFilters($param = null) 
    {
        try 
        {
            //code here

                        $filter = new self([]);

            $btnClose = new TButton('closeCurtain');
            $btnClose->class = 'btn btn-sm btn-default';
            $btnClose->style = 'margin-right:10px;';
            $btnClose->onClick = "Template.closeRightPanel();";
            $btnClose->setLabel("Fechar");
            $btnClose->setImage('fas:times');

            $filter->form->addHeaderWidget($btnClose);

            $page = new TPage();
            $page->setTargetContainer('adianti_right_panel');
            $page->setProperty('page-name', 'CobrancaTituloListSearch');
            $page->setProperty('page_name', 'CobrancaTituloListSearch');
            $page->adianti_target_container = 'adianti_right_panel';
            $page->target_container = 'adianti_right_panel';
            $page->add($filter->form);
            $page->setIsWrapped(true);
            $page->show();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
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

        if (isset($data->beneficiario_id) AND ( (is_scalar($data->beneficiario_id) AND $data->beneficiario_id !== '') OR (is_array($data->beneficiario_id) AND (!empty($data->beneficiario_id)) )) )
        {

            $filters[] = new TFilter('beneficiario_id', '=', $data->beneficiario_id);// create the filter 
        }

        if (isset($data->cliente_id) AND ( (is_scalar($data->cliente_id) AND $data->cliente_id !== '') OR (is_array($data->cliente_id) AND (!empty($data->cliente_id)) )) )
        {

            $filters[] = new TFilter('cliente_id', '=', $data->cliente_id);// create the filter 
        }

        if (isset($data->valor) AND ( (is_scalar($data->valor) AND $data->valor !== '') OR (is_array($data->valor) AND (!empty($data->valor)) )) )
        {

            $filters[] = new TFilter('valor', '=', $data->valor);// create the filter 
        }

        if (isset($data->system_unit_id) AND ( (is_scalar($data->system_unit_id) AND $data->system_unit_id !== '') OR (is_array($data->system_unit_id) AND (!empty($data->system_unit_id)) )) )
        {

            $filters[] = new TFilter('system_unit_id', '=', $data->system_unit_id);// create the filter 
        }

        if (isset($data->parametros_bancos_id) AND ( (is_scalar($data->parametros_bancos_id) AND $data->parametros_bancos_id !== '') OR (is_array($data->parametros_bancos_id) AND (!empty($data->parametros_bancos_id)) )) )
        {

            $filters[] = new TFilter('parametros_bancos_id', '=', $data->parametros_bancos_id);// create the filter 
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

            // creates a repository for CobrancaTitulo
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

            //</blockLine><btnShowCurtainFiltersAutoCode>
            if(!empty($this->btnShowCurtainFilters) && empty($this->btnShowCurtainFiltersAdjusted))
            {
                $this->btnShowCurtainFiltersAdjusted = true;
                $this->btnShowCurtainFilters->style = 'position: relative';
                $countFilters = count($filters ?? []);
                $this->btnShowCurtainFilters->setLabel($this->btnShowCurtainFilters->getLabel(). "<span class='badge badge-success' style='position: absolute'>{$countFilters}<span>");
            }
            //</blockLine></btnShowCurtainFiltersAutoCode>

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

    public static function onYes($param = null) 
    {
        try 
        {
        TTransaction::open(self::$database);
        $response=DirecionadorClass::BaixarBoleto($param['id']);
        TTransaction::close();
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onNo($param = null) 
    {
        try 
        {
            //code here
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new CobrancaTitulo($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

