<?php

class ParametrosBancos extends TRecord
{
    const TABLENAME  = 'parametros_bancos';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $workspaces_santander;
    private $banco;
    private $beneficiario;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('banco_id');
        parent::addAttribute('beneficiario_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('workspaces_santander_id');
        parent::addAttribute('numerocontrato');
        parent::addAttribute('numerocontacorrente');
        parent::addAttribute('modalidade');
        parent::addAttribute('identificacaoboletoempresa');
        parent::addAttribute('identificacaoemissaoboleto');
        parent::addAttribute('identificacaodistribuicaoboleto');
        parent::addAttribute('tipodesconto');
        parent::addAttribute('diasparadesconto_primeiro');
        parent::addAttribute('valorprimeirodesconto');
        parent::addAttribute('dataprimeirodesconto');
        parent::addAttribute('diasparadesconto_segundo');
        parent::addAttribute('datasegundodesconto');
        parent::addAttribute('valorsegundodesconto');
        parent::addAttribute('diasparadesconto_terceiro');
        parent::addAttribute('dataterceirodesconto');
        parent::addAttribute('valorTerceiroDesconto');
        parent::addAttribute('tipomulta');
        parent::addAttribute('tipojurosmora');
        parent::addAttribute('diasmultas');
        parent::addAttribute('valormulta');
        parent::addAttribute('diasjurosmora');
        parent::addAttribute('valorjurosmora');
        parent::addAttribute('codigoprotesto');
        parent::addAttribute('numerodiasprotesto');
        parent::addAttribute('codigonegativacao');
        parent::addAttribute('numerodiasnegativacao');
        parent::addAttribute('gerarpdf');
        parent::addAttribute('ambiente');
        parent::addAttribute('client_id');
        parent::addAttribute('apelido');
        parent::addAttribute('carteira');
        parent::addAttribute('certificado_base64');
        parent::addAttribute('agencia');
        parent::addAttribute('digito_agencia');
        parent::addAttribute('digito_conta');
        parent::addAttribute('username');
        parent::addAttribute('password');
        parent::addAttribute('scope');
        parent::addAttribute('info1');
        parent::addAttribute('info2');
        parent::addAttribute('info3');
        parent::addAttribute('info4');
        parent::addAttribute('info5');
        parent::addAttribute('mens1');
        parent::addAttribute('mens2');
        parent::addAttribute('mens3');
        parent::addAttribute('mens4');
        parent::addAttribute('cooperativa');
        parent::addAttribute('posto');
        parent::addAttribute('status');
        parent::addAttribute('codigobeneficiario');
        parent::addAttribute('cpfcnpjbeneficiario');
        parent::addAttribute('client_secret');
        parent::addAttribute('chave_pix');
        parent::addAttribute('client_id_bolecode');
        parent::addAttribute('client_secret_bolecode');
        parent::addAttribute('observacao');
        parent::addAttribute('senha_certificado_pix');
        parent::addAttribute('certificados_pix');
        parent::addAttribute('tipo_chave_pix');
        parent::addAttribute('certificado');
        parent::addAttribute('senha');
        parent::addAttribute('etapa_processo_boleto');
        parent::addAttribute('versao');
        parent::addAttribute('sistema_origem');
        parent::addAttribute('autenticacao');
        parent::addAttribute('usuario_servico');
        parent::addAttribute('unidade');
        parent::addAttribute('authorization');
        parent::addAttribute('gw_dev_app_key');
        parent::addAttribute('numeroconvenio');
        parent::addAttribute('numerovariacaocarteira');
        parent::addAttribute('indicadoraceitetitulovencido');
        parent::addAttribute('numerodiaslimiterecebimento');
        parent::addAttribute('codigoaceite');
        parent::addAttribute('tipos_documentos');
        parent::addAttribute('valorabatimento');
        parent::addAttribute('baixa_devolver_codigo');
        parent::addAttribute('baixar_devolver_prazo');
        parent::addAttribute('protesto_prazo');
        parent::addAttribute('protesto_codigo');
        parent::addAttribute('url1');
        parent::addAttribute('url2');
        parent::addAttribute('url3');
        parent::addAttribute('url4');
            
    }

    /**
     * Method set_workspaces_santander
     * Sample of usage: $var->workspaces_santander = $object;
     * @param $object Instance of WorkspacesSantander
     */
    public function set_workspaces_santander(WorkspacesSantander $object)
    {
        $this->workspaces_santander = $object;
        $this->workspaces_santander_id = $object->id;
    }

    /**
     * Method get_workspaces_santander
     * Sample of usage: $var->workspaces_santander->attribute;
     * @returns WorkspacesSantander instance
     */
    public function get_workspaces_santander()
    {
    
        // loads the associated object
        if (empty($this->workspaces_santander))
            $this->workspaces_santander = new WorkspacesSantander($this->workspaces_santander_id);
    
        // returns the associated object
        return $this->workspaces_santander;
    }
    /**
     * Method set_banco
     * Sample of usage: $var->banco = $object;
     * @param $object Instance of Banco
     */
    public function set_banco(Banco $object)
    {
        $this->banco = $object;
        $this->banco_id = $object->id;
    }

    /**
     * Method get_banco
     * Sample of usage: $var->banco->attribute;
     * @returns Banco instance
     */
    public function get_banco()
    {
    
        // loads the associated object
        if (empty($this->banco))
            $this->banco = new Banco($this->banco_id);
    
        // returns the associated object
        return $this->banco;
    }
    /**
     * Method set_beneficiario
     * Sample of usage: $var->beneficiario = $object;
     * @param $object Instance of Beneficiario
     */
    public function set_beneficiario(Beneficiario $object)
    {
        $this->beneficiario = $object;
        $this->beneficiario_id = $object->id;
    }

    /**
     * Method get_beneficiario
     * Sample of usage: $var->beneficiario->attribute;
     * @returns Beneficiario instance
     */
    public function get_beneficiario()
    {
    
        // loads the associated object
        if (empty($this->beneficiario))
            $this->beneficiario = new Beneficiario($this->beneficiario_id);
    
        // returns the associated object
        return $this->beneficiario;
    }

    /**
     * Method getWorkspacesSantanders
     */
    public function getWorkspacesSantanders()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('parametros_bancos_id', '=', $this->id));
        return WorkspacesSantander::getObjects( $criteria );
    }
    /**
     * Method getCobrancaTitulos
     */
    public function getCobrancaTitulos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('parametros_bancos_id', '=', $this->id));
        return CobrancaTitulo::getObjects( $criteria );
    }
    /**
     * Method getRateioSicoobs
     */
    public function getRateioSicoobs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('parametros_bancos_id', '=', $this->id));
        return RateioSicoob::getObjects( $criteria );
    }

    public function set_workspaces_santander_parametros_bancos_to_string($workspaces_santander_parametros_bancos_to_string)
    {
        if(is_array($workspaces_santander_parametros_bancos_to_string))
        {
            $values = ParametrosBancos::where('id', 'in', $workspaces_santander_parametros_bancos_to_string)->getIndexedArray('id', 'id');
            $this->workspaces_santander_parametros_bancos_to_string = implode(', ', $values);
        }
        else
        {
            $this->workspaces_santander_parametros_bancos_to_string = $workspaces_santander_parametros_bancos_to_string;
        }

        $this->vdata['workspaces_santander_parametros_bancos_to_string'] = $this->workspaces_santander_parametros_bancos_to_string;
    }

    public function get_workspaces_santander_parametros_bancos_to_string()
    {
        if(!empty($this->workspaces_santander_parametros_bancos_to_string))
        {
            return $this->workspaces_santander_parametros_bancos_to_string;
        }
    
        $values = WorkspacesSantander::where('parametros_bancos_id', '=', $this->id)->getIndexedArray('parametros_bancos_id','{parametros_bancos->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_beneficiario_to_string($cobranca_titulo_beneficiario_to_string)
    {
        if(is_array($cobranca_titulo_beneficiario_to_string))
        {
            $values = Beneficiario::where('id', 'in', $cobranca_titulo_beneficiario_to_string)->getIndexedArray('id', 'id');
            $this->cobranca_titulo_beneficiario_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_beneficiario_to_string = $cobranca_titulo_beneficiario_to_string;
        }

        $this->vdata['cobranca_titulo_beneficiario_to_string'] = $this->cobranca_titulo_beneficiario_to_string;
    }

    public function get_cobranca_titulo_beneficiario_to_string()
    {
        if(!empty($this->cobranca_titulo_beneficiario_to_string))
        {
            return $this->cobranca_titulo_beneficiario_to_string;
        }
    
        $values = CobrancaTitulo::where('parametros_bancos_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_parametros_bancos_to_string($cobranca_titulo_parametros_bancos_to_string)
    {
        if(is_array($cobranca_titulo_parametros_bancos_to_string))
        {
            $values = ParametrosBancos::where('id', 'in', $cobranca_titulo_parametros_bancos_to_string)->getIndexedArray('id', 'id');
            $this->cobranca_titulo_parametros_bancos_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_parametros_bancos_to_string = $cobranca_titulo_parametros_bancos_to_string;
        }

        $this->vdata['cobranca_titulo_parametros_bancos_to_string'] = $this->cobranca_titulo_parametros_bancos_to_string;
    }

    public function get_cobranca_titulo_parametros_bancos_to_string()
    {
        if(!empty($this->cobranca_titulo_parametros_bancos_to_string))
        {
            return $this->cobranca_titulo_parametros_bancos_to_string;
        }
    
        $values = CobrancaTitulo::where('parametros_bancos_id', '=', $this->id)->getIndexedArray('parametros_bancos_id','{parametros_bancos->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_cliente_to_string($cobranca_titulo_cliente_to_string)
    {
        if(is_array($cobranca_titulo_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $cobranca_titulo_cliente_to_string)->getIndexedArray('id', 'id');
            $this->cobranca_titulo_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_cliente_to_string = $cobranca_titulo_cliente_to_string;
        }

        $this->vdata['cobranca_titulo_cliente_to_string'] = $this->cobranca_titulo_cliente_to_string;
    }

    public function get_cobranca_titulo_cliente_to_string()
    {
        if(!empty($this->cobranca_titulo_cliente_to_string))
        {
            return $this->cobranca_titulo_cliente_to_string;
        }
    
        $values = CobrancaTitulo::where('parametros_bancos_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_fk_status_to_string($cobranca_titulo_fk_status_to_string)
    {
        if(is_array($cobranca_titulo_fk_status_to_string))
        {
            $values = SituacaoBoleto::where('id', 'in', $cobranca_titulo_fk_status_to_string)->getIndexedArray('nome', 'nome');
            $this->cobranca_titulo_fk_status_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_fk_status_to_string = $cobranca_titulo_fk_status_to_string;
        }

        $this->vdata['cobranca_titulo_fk_status_to_string'] = $this->cobranca_titulo_fk_status_to_string;
    }

    public function get_cobranca_titulo_fk_status_to_string()
    {
        if(!empty($this->cobranca_titulo_fk_status_to_string))
        {
            return $this->cobranca_titulo_fk_status_to_string;
        }
    
        $values = CobrancaTitulo::where('parametros_bancos_id', '=', $this->id)->getIndexedArray('status','{fk_status->nome}');
        return implode(', ', $values);
    }

    public function set_rateio_sicoob_parametros_bancos_to_string($rateio_sicoob_parametros_bancos_to_string)
    {
        if(is_array($rateio_sicoob_parametros_bancos_to_string))
        {
            $values = ParametrosBancos::where('id', 'in', $rateio_sicoob_parametros_bancos_to_string)->getIndexedArray('id', 'id');
            $this->rateio_sicoob_parametros_bancos_to_string = implode(', ', $values);
        }
        else
        {
            $this->rateio_sicoob_parametros_bancos_to_string = $rateio_sicoob_parametros_bancos_to_string;
        }

        $this->vdata['rateio_sicoob_parametros_bancos_to_string'] = $this->rateio_sicoob_parametros_bancos_to_string;
    }

    public function get_rateio_sicoob_parametros_bancos_to_string()
    {
        if(!empty($this->rateio_sicoob_parametros_bancos_to_string))
        {
            return $this->rateio_sicoob_parametros_bancos_to_string;
        }
    
        $values = RateioSicoob::where('parametros_bancos_id', '=', $this->id)->getIndexedArray('parametros_bancos_id','{parametros_bancos->id}');
        return implode(', ', $values);
    }

    
}

