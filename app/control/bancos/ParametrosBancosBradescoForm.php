<?php

class ParametrosBancosBradescoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'conecatarbanco';
    private static $activeRecord = 'ParametrosBancos';
    private static $primaryKey = 'id';
    private static $formName = 'form_ParametrosBancosForm';

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
        $this->form->setFormTitle("Cadastro de parametros bancos Bradesco");

        $criteria_beneficiario_id = new TCriteria();
        $criteria_banco_id = new TCriteria();
        $criteria_workspaces_santander_id = new TCriteria();

        $id = new TEntry('id');
        $system_unit_id = new THidden('system_unit_id');
        $beneficiario_id = new TDBCombo('beneficiario_id', 'conecatarbanco', 'Beneficiario', 'id', '{nome} {nome}','id asc' , $criteria_beneficiario_id );
        $banco_id = new TDBCombo('banco_id', 'conecatarbanco', 'Banco', 'id', '{apelido}','apelido asc' , $criteria_banco_id );
        $workspaces_santander_id = new TDBCombo('workspaces_santander_id', 'conecatarbanco', 'WorkspacesSantander', 'id', '{description}','id asc' , $criteria_workspaces_santander_id );
        $apelido = new TEntry('apelido');
        $status = new TRadioGroup('status');
        $etapa_processo_boleto = new TCombo('etapa_processo_boleto');
        $numerocontacorrente = new TEntry('numerocontacorrente');
        $digito_conta = new TEntry('digito_conta');
        $agencia = new TEntry('agencia');
        $digito_agencia = new TEntry('digito_agencia');
        $numerocontrato = new TEntry('numerocontrato');
        $carteira = new TEntry('carteira');
        $observacao = new TText('observacao');
        $identificacaoemissaoboleto = new TEntry('identificacaoemissaoboleto');
        $identificacaodistribuicaoboleto = new TEntry('identificacaodistribuicaoboleto');
        $tipodesconto = new TEntry('tipodesconto');
        $diasparadesconto_primeiro = new TEntry('diasparadesconto_primeiro');
        $valorprimeirodesconto = new TNumeric('valorprimeirodesconto', '2', ',', '.' );
        $dataprimeirodesconto = new TDate('dataprimeirodesconto');
        $diasparadesconto_segundo = new TEntry('diasparadesconto_segundo');
        $datasegundodesconto = new TDate('datasegundodesconto');
        $valorsegundodesconto = new TNumeric('valorsegundodesconto', '2', ',', '.' );
        $diasparadesconto_terceiro = new TEntry('diasparadesconto_terceiro');
        $dataterceirodesconto = new TDate('dataterceirodesconto');
        $valorTerceiroDesconto = new TNumeric('valorTerceiroDesconto', '2', ',', '.' );
        $tipomulta = new TEntry('tipomulta');
        $tipojurosmora = new TEntry('tipojurosmora');
        $diasmultas = new TEntry('diasmultas');
        $valormulta = new TEntry('valormulta');
        $diasjurosmora = new TEntry('diasjurosmora');
        $valorjurosmora = new TEntry('valorjurosmora');
        $codigoprotesto = new TEntry('codigoprotesto');
        $numerodiasprotesto = new TEntry('numerodiasprotesto');
        $info1 = new TEntry('info1');
        $info2 = new TEntry('info2');
        $info3 = new TEntry('info3');
        $info4 = new TEntry('info4');
        $info5 = new TEntry('info5');
        $mens1 = new TEntry('mens1');
        $mens2 = new TEntry('mens2');
        $mens3 = new TEntry('mens3');
        $mens4 = new TEntry('mens4');
        $cooperativa = new TEntry('cooperativa');
        $client_id = new TText('client_id');
        $client_secret = new TText('client_secret');
        $username = new TEntry('username');
        $password = new TEntry('password');
        $certificado = new TFile('certificado');
        $senha = new TPassword('senha');
        $client_id_bolecode = new TText('client_id_bolecode');
        $client_secret_bolecode = new TText('client_secret_bolecode');
        $certificados_pix = new TFile('certificados_pix');
        $senha_certificado_pix = new TPassword('senha_certificado_pix');
        $tipo_chave_pix = new TCombo('tipo_chave_pix');
        $chave_pix = new TEntry('chave_pix');
        $url1 = new TEntry('url1');
        $url2 = new TEntry('url2');

        $beneficiario_id->addValidation("Beneficiario id", new TRequiredValidator()); 
        $banco_id->addValidation("Banco id", new TRequiredValidator()); 
        $etapa_processo_boleto->addValidation("AMBIENTE", new TRequiredValidator()); 
        $numerocontacorrente->addValidation("Numerocontacorrente", new TRequiredValidator()); 

        $status->setLayout('horizontal');
        $status->setUseButton();
        $certificado->setAllowedExtensions(["pfx","cer","PEM"]);
        $certificado->enableFileHandling();
        $certificados_pix->enableFileHandling();

        $id->setEditable(false);
        $banco_id->setEditable(false);
        $etapa_processo_boleto->setEditable(false);

        $status->addItems(["1"=>"ATIVO","2"=>"INATIVO"]);
        $etapa_processo_boleto->addItems(["validacao"=>"HOMOLOGAÇÃO","efetivacao"=>"PRODUÇÃO"]);
        $tipo_chave_pix->addItems(["CELULAR"=>"CELULAR","CPF/CNPJ"=>"CPF/CNPJ","E-MAIL"=>"E-MAIL","CHAVE ALEATORIA"=>"CHAVE ALEATORIA"]);

        $datasegundodesconto->setMask('dd/mm/yyyy');
        $dataprimeirodesconto->setMask('dd/mm/yyyy');
        $dataterceirodesconto->setMask('dd/mm/yyyy');

        $datasegundodesconto->setDatabaseMask('yyyy-mm-dd');
        $dataprimeirodesconto->setDatabaseMask('yyyy-mm-dd');
        $dataterceirodesconto->setDatabaseMask('yyyy-mm-dd');

        $banco_id->enableSearch();
        $tipo_chave_pix->enableSearch();
        $beneficiario_id->enableSearch();
        $etapa_processo_boleto->enableSearch();
        $workspaces_santander_id->enableSearch();

        $banco_id->setValue('5');
        $apelido->setValue('NULL');
        $agencia->setValue('6789');
        $diasmultas->setValue('5');
        $carteira->setValue('NULL');
        $client_id->setValue('NULL');
        $digito_agencia->setValue('3');
        $codigoprotesto->setValue('50');
        $system_unit_id->setValue('NULL');
        $diasparadesconto_primeiro->setValue('1');
        $etapa_processo_boleto->setValue('validacao');

        $info1->setMaxLength(80);
        $info2->setMaxLength(80);
        $info3->setMaxLength(80);
        $info4->setMaxLength(80);
        $info5->setMaxLength(80);
        $mens1->setMaxLength(80);
        $mens2->setMaxLength(80);
        $mens3->setMaxLength(80);
        $mens4->setMaxLength(80);
        $senha->setMaxLength(255);
        $apelido->setMaxLength(20);
        $carteira->setMaxLength(50);
        $tipomulta->setMaxLength(50);
        $cooperativa->setMaxLength(10);
        $digito_conta->setMaxLength(10);
        $tipodesconto->setMaxLength(50);
        $tipojurosmora->setMaxLength(50);
        $codigoprotesto->setMaxLength(11);
        $numerocontacorrente->setMaxLength(100);
        $diasparadesconto_terceiro->setMaxLength(255);
        $identificacaoemissaoboleto->setMaxLength(100);
        $identificacaodistribuicaoboleto->setMaxLength(100);

        $id->setSize(70);
        $url1->setSize('100%');
        $url2->setSize('100%');
        $info1->setSize('100%');
        $info2->setSize('100%');
        $info3->setSize('100%');
        $info4->setSize('100%');
        $info5->setSize('100%');
        $mens1->setSize('100%');
        $mens2->setSize('100%');
        $mens3->setSize('100%');
        $mens4->setSize('100%');
        $senha->setSize('100%');
        $status->setSize('100%');
        $apelido->setSize('100%');
        $agencia->setSize('100%');
        $banco_id->setSize('100%');
        $carteira->setSize('100%');
        $username->setSize('100%');
        $password->setSize('100%');
        $tipomulta->setSize('100%');
        $chave_pix->setSize('100%');
        $diasmultas->setSize('100%');
        $valormulta->setSize('100%');
        $system_unit_id->setSize(200);
        $cooperativa->setSize('100%');
        $certificado->setSize('100%');
        $digito_conta->setSize('100%');
        $tipodesconto->setSize('100%');
        $tipojurosmora->setSize('100%');
        $diasjurosmora->setSize('100%');
        $client_id->setSize('100%', 70);
        $digito_agencia->setSize('100%');
        $numerocontrato->setSize('100%');
        $valorjurosmora->setSize('100%');
        $codigoprotesto->setSize('100%');
        $tipo_chave_pix->setSize('100%');
        $beneficiario_id->setSize('100%');
        $observacao->setSize('100%', 300);
        $datasegundodesconto->setSize(110);
        $certificados_pix->setSize('100%');
        $dataprimeirodesconto->setSize(110);
        $dataterceirodesconto->setSize(110);
        $client_secret->setSize('100%', 70);
        $numerodiasprotesto->setSize('100%');
        $numerocontacorrente->setSize('100%');
        $valorsegundodesconto->setSize('100%');
        $etapa_processo_boleto->setSize('100%');
        $valorprimeirodesconto->setSize('100%');
        $valorTerceiroDesconto->setSize('100%');
        $senha_certificado_pix->setSize('100%');
        $client_id_bolecode->setSize('100%', 70);
        $workspaces_santander_id->setSize('100%');
        $diasparadesconto_segundo->setSize('100%');
        $diasparadesconto_primeiro->setSize('100%');
        $diasparadesconto_terceiro->setSize('100%');
        $identificacaoemissaoboleto->setSize('100%');
        $client_secret_bolecode->setSize('100%', 70);
        $identificacaodistribuicaoboleto->setSize('100%');

        $this->form->appendPage("1-PRINCIPAL");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("CÓDIGO:", null, '14px', null, '100%'),$id,$system_unit_id],[new TLabel("BENEFICIÁRIO: ", '#000000', '14px', 'B', '100%'),$beneficiario_id],[new TLabel("BANCO:", '#000000', '14px', 'B', '100%'),$banco_id],[new TLabel("WorkSpace", null, '14px', null),$workspaces_santander_id],[new TLabel("Apelido:", null, '14px', null, '100%'),$apelido],[new TLabel("Status:", null, '14px', null, '100%'),$status],[new TLabel(new TImage('fas:info-circle #F44336')."AMBIENTE ATENÇÃO:", '#F44336', '14px', 'B', '100%'),$etapa_processo_boleto]);
        $row1->layout = ['col-sm-1',' col-sm-4',' col-sm-4','col-sm-2','col-sm-4','col-sm-4','col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Conta corrente: ", '#000000', '14px', null, '100%'),$numerocontacorrente],[new TLabel("Digito conta:", null, '14px', null, '100%'),$digito_conta],[new TLabel("Agencia:", null, '14px', null, '100%'),$agencia],[new TLabel("Digito agencia:", null, '14px', null, '100%'),$digito_agencia],[new TLabel("Contrato", null, '14px', null),$numerocontrato],[new TLabel("CARTEIRA:", null, '14px', 'B', '100%'),$carteira]);
        $row2->layout = [' col-sm-2','col-sm-2',' col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        $row3 = $this->form->addFields([$observacao]);
        $row3->layout = [' col-sm-12'];

        $this->form->appendPage("2-COBRANÇA");
        $row4 = $this->form->addFields([new TLabel("Identificacaoemissaoboleto:", null, '14px', null, '100%'),$identificacaoemissaoboleto],[new TLabel("Identificacaodistribuicaoboleto:", null, '14px', null, '100%'),$identificacaodistribuicaoboleto]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Tipodesconto:", null, '14px', null, '100%'),$tipodesconto],[new TLabel("Diasparadesconto primeiro:", null, '14px', null, '100%'),$diasparadesconto_primeiro]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->form->addFields([new TLabel("Valorprimeirodesconto:", null, '14px', null, '100%'),$valorprimeirodesconto],[new TLabel("Dataprimeirodesconto:", null, '14px', null, '100%'),$dataprimeirodesconto]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->form->addFields([new TLabel("Diasparadesconto segundo:", null, '14px', null, '100%'),$diasparadesconto_segundo],[new TLabel("Datasegundodesconto:", null, '14px', null, '100%'),$datasegundodesconto]);
        $row7->layout = ['col-sm-6','col-sm-6'];

        $row8 = $this->form->addFields([new TLabel("Valorsegundodesconto:", null, '14px', null, '100%'),$valorsegundodesconto],[new TLabel("Diasparadesconto terceiro:", null, '14px', null, '100%'),$diasparadesconto_terceiro]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $row9 = $this->form->addFields([new TLabel("Dataterceirodesconto:", null, '14px', null, '100%'),$dataterceirodesconto],[new TLabel("ValorTerceiroDesconto:", null, '14px', null, '100%'),$valorTerceiroDesconto]);
        $row9->layout = ['col-sm-6','col-sm-6'];

        $row10 = $this->form->addFields([new TLabel("Tipomulta:", null, '14px', null, '100%'),$tipomulta],[new TLabel("Tipojurosmora:", null, '14px', null, '100%'),$tipojurosmora]);
        $row10->layout = ['col-sm-6','col-sm-6'];

        $row11 = $this->form->addFields([new TLabel("Diasmultas:", null, '14px', null, '100%'),$diasmultas],[new TLabel("Valormulta:", null, '14px', null, '100%'),$valormulta]);
        $row11->layout = ['col-sm-6','col-sm-6'];

        $row12 = $this->form->addFields([new TLabel("Diasjurosmora:", null, '14px', null, '100%'),$diasjurosmora],[new TLabel("Valorjurosmora:", null, '14px', null, '100%'),$valorjurosmora]);
        $row12->layout = ['col-sm-6','col-sm-6'];

        $row13 = $this->form->addFields([new TLabel("Codigoprotesto:", null, '14px', null, '100%'),$codigoprotesto],[new TLabel("Numerodiasprotesto:", null, '14px', null, '100%'),$numerodiasprotesto]);
        $row13->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("3-INSTRUÇÕES");
        $row14 = $this->form->addFields([new TLabel("Info1:", null, '14px', null, '100%'),$info1],[new TLabel("Info2:", null, '14px', null, '100%'),$info2]);
        $row14->layout = ['col-sm-6','col-sm-6'];

        $row15 = $this->form->addFields([new TLabel("Info3:", null, '14px', null, '100%'),$info3],[new TLabel("Info4:", null, '14px', null, '100%'),$info4]);
        $row15->layout = ['col-sm-6','col-sm-6'];

        $row16 = $this->form->addFields([new TLabel("Info5:", null, '14px', null, '100%'),$info5],[new TLabel("Mens1:", null, '14px', null, '100%'),$mens1]);
        $row16->layout = ['col-sm-6','col-sm-6'];

        $row17 = $this->form->addFields([new TLabel("Mens2:", null, '14px', null, '100%'),$mens2],[new TLabel("Mens3:", null, '14px', null, '100%'),$mens3]);
        $row17->layout = ['col-sm-6','col-sm-6'];

        $row18 = $this->form->addFields([new TLabel("Mens4:", null, '14px', null, '100%'),$mens4],[new TLabel("Cooperativa:", null, '14px', null, '100%'),$cooperativa]);
        $row18->layout = ['col-sm-6','col-sm-6'];

        $this->form->appendPage("4-CONFIGURAÇÕES BOLETOS");
        $row19 = $this->form->addContent([new TFormSeparator("DADOS BOLETO CONVECIONAL:", '#2196F3', '18', '#4CAF50')]);
        $row20 = $this->form->addFields([new TLabel(new TImage('fas:user-secret #FF5722')."CLIENT ID BOLETO:", '#FF5722', '14px', 'B', '100%'),$client_id],[new TLabel(" Client Secret BOLETO:", null, '14px', null),$client_secret],[new TLabel(new TImage('fas:user-friends #009688')."LOGIN:", '#009688', '14px', 'B', '100%'),$username],[new TLabel(new TImage('fas:keyboard #E91E63')."SENHA::", '#E91E63', '14px', 'B', '100%'),$password],[new TLabel("Certificado A1 boleto convecional: ", '#FF5722', '14px', 'BI'),$certificado],[new TLabel("Senha certificado:", '#FF5722', '14px', 'BI'),$senha]);
        $row20->layout = ['col-sm-6','col-sm-6',' col-sm-6',' col-sm-6',' col-sm-10',' col-sm-2'];

        $row21 = $this->form->addContent([new TFormSeparator("DADOS BOLETO BOLECODE:", '#FFC107', '18', '#8BC34A')]);
        $row22 = $this->form->addFields([new TLabel("Client ID PIX: ", null, '14px', 'B'),$client_id_bolecode],[new TLabel("Client Secret PIX:", null, '14px', 'B'),$client_secret_bolecode],[new TLabel("CERTIFICADO PIX: ", null, '14px', 'B'),$certificados_pix],[new TLabel("Senha certificado pix:", null, '14px', 'B'),$senha_certificado_pix],[new TLabel("Tipo chave pix:", null, '14px', 'B'),$tipo_chave_pix],[new TLabel("Chave pix:", null, '14px', 'B', '100%'),$chave_pix],[new TLabel("URL TOKEN: ", null, '14px', 'B'),$url1],[new TLabel("URL AÇÕES DO BOLETO: ", null, '14px', 'B'),$url2]);
        $row22->layout = ['col-sm-6','col-sm-6','col-sm-4','col-sm-2','col-sm-2','col-sm-4',' col-sm-12',' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ParametrosBancosList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Bancos","Cadastro de parametros bancos Bradesco"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new ParametrosBancos(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $certificado_dir = 'certificados/normal';
            $certificados_pix_dir = 'certificados/pix'; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'certificado', $certificado_dir);
            $this->saveFile($object, $data, 'certificados_pix', $certificados_pix_dir);
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
            TApplication::loadPage('ParametrosBancosList', 'onShow', $loadPageParam); 

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

                $object = new ParametrosBancos($key); // instantiates the Active Record 

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

