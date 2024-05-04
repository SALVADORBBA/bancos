<?php

class Beneficiario extends TRecord
{
    const TABLENAME  = 'beneficiario';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $system_unit;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('tipo_pessoa');
        parent::addAttribute('cpf');
        parent::addAttribute('cnpj');
        parent::addAttribute('insc_estadual');
        parent::addAttribute('data_nascimento');
        parent::addAttribute('endereco');
        parent::addAttribute('cidade');
        parent::addAttribute('estado');
        parent::addAttribute('cep');
        parent::addAttribute('telefone');
        parent::addAttribute('email');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('numero');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cmun');
        parent::addAttribute('cuf');
        parent::addAttribute('instancename');
        parent::addAttribute('urlexterna');
        parent::addAttribute('apikey');
        parent::addAttribute('rotaexterna');
            
    }

    /**
     * Method set_system_unit
     * Sample of usage: $var->system_unit = $object;
     * @param $object Instance of SystemUnit
     */
    public function set_system_unit(SystemUnit $object)
    {
        $this->system_unit = $object;
        $this->system_unit_id = $object->id;
    }

    /**
     * Method get_system_unit
     * Sample of usage: $var->system_unit->attribute;
     * @returns SystemUnit instance
     */
    public function get_system_unit()
    {
    
        // loads the associated object
        if (empty($this->system_unit))
            $this->system_unit = new SystemUnit($this->system_unit_id);
    
        // returns the associated object
        return $this->system_unit;
    }

    /**
     * Method getParametrosItaus
     */
    public function getParametrosItaus()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('beneficiario_id', '=', $this->id));
        return ParametrosItau::getObjects( $criteria );
    }
    /**
     * Method getParametrosSicredis
     */
    public function getParametrosSicredis()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('beneficiario_id', '=', $this->id));
        return ParametrosSicredi::getObjects( $criteria );
    }
    /**
     * Method getClientes
     */
    public function getClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('beneficiario_id', '=', $this->id));
        return Cliente::getObjects( $criteria );
    }
    /**
     * Method getCobrancaTitulos
     */
    public function getCobrancaTitulos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('beneficiario_id', '=', $this->id));
        return CobrancaTitulo::getObjects( $criteria );
    }
    /**
     * Method getParametrosBancoss
     */
    public function getParametrosBancoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('beneficiario_id', '=', $this->id));
        return ParametrosBancos::getObjects( $criteria );
    }

    public function set_parametros_itau_banco_to_string($parametros_itau_banco_to_string)
    {
        if(is_array($parametros_itau_banco_to_string))
        {
            $values = Banco::where('id', 'in', $parametros_itau_banco_to_string)->getIndexedArray('apelido', 'apelido');
            $this->parametros_itau_banco_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_itau_banco_to_string = $parametros_itau_banco_to_string;
        }

        $this->vdata['parametros_itau_banco_to_string'] = $this->parametros_itau_banco_to_string;
    }

    public function get_parametros_itau_banco_to_string()
    {
        if(!empty($this->parametros_itau_banco_to_string))
        {
            return $this->parametros_itau_banco_to_string;
        }
    
        $values = ParametrosItau::where('beneficiario_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
        return implode(', ', $values);
    }

    public function set_parametros_itau_beneficiario_to_string($parametros_itau_beneficiario_to_string)
    {
        if(is_array($parametros_itau_beneficiario_to_string))
        {
            $values = Beneficiario::where('id', 'in', $parametros_itau_beneficiario_to_string)->getIndexedArray('id', 'id');
            $this->parametros_itau_beneficiario_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_itau_beneficiario_to_string = $parametros_itau_beneficiario_to_string;
        }

        $this->vdata['parametros_itau_beneficiario_to_string'] = $this->parametros_itau_beneficiario_to_string;
    }

    public function get_parametros_itau_beneficiario_to_string()
    {
        if(!empty($this->parametros_itau_beneficiario_to_string))
        {
            return $this->parametros_itau_beneficiario_to_string;
        }
    
        $values = ParametrosItau::where('beneficiario_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
        return implode(', ', $values);
    }

    public function set_parametros_sicredi_banco_to_string($parametros_sicredi_banco_to_string)
    {
        if(is_array($parametros_sicredi_banco_to_string))
        {
            $values = Banco::where('id', 'in', $parametros_sicredi_banco_to_string)->getIndexedArray('apelido', 'apelido');
            $this->parametros_sicredi_banco_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_sicredi_banco_to_string = $parametros_sicredi_banco_to_string;
        }

        $this->vdata['parametros_sicredi_banco_to_string'] = $this->parametros_sicredi_banco_to_string;
    }

    public function get_parametros_sicredi_banco_to_string()
    {
        if(!empty($this->parametros_sicredi_banco_to_string))
        {
            return $this->parametros_sicredi_banco_to_string;
        }
    
        $values = ParametrosSicredi::where('beneficiario_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
        return implode(', ', $values);
    }

    public function set_parametros_sicredi_beneficiario_to_string($parametros_sicredi_beneficiario_to_string)
    {
        if(is_array($parametros_sicredi_beneficiario_to_string))
        {
            $values = Beneficiario::where('id', 'in', $parametros_sicredi_beneficiario_to_string)->getIndexedArray('id', 'id');
            $this->parametros_sicredi_beneficiario_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_sicredi_beneficiario_to_string = $parametros_sicredi_beneficiario_to_string;
        }

        $this->vdata['parametros_sicredi_beneficiario_to_string'] = $this->parametros_sicredi_beneficiario_to_string;
    }

    public function get_parametros_sicredi_beneficiario_to_string()
    {
        if(!empty($this->parametros_sicredi_beneficiario_to_string))
        {
            return $this->parametros_sicredi_beneficiario_to_string;
        }
    
        $values = ParametrosSicredi::where('beneficiario_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
        return implode(', ', $values);
    }

    public function set_cliente_beneficiario_to_string($cliente_beneficiario_to_string)
    {
        if(is_array($cliente_beneficiario_to_string))
        {
            $values = Beneficiario::where('id', 'in', $cliente_beneficiario_to_string)->getIndexedArray('id', 'id');
            $this->cliente_beneficiario_to_string = implode(', ', $values);
        }
        else
        {
            $this->cliente_beneficiario_to_string = $cliente_beneficiario_to_string;
        }

        $this->vdata['cliente_beneficiario_to_string'] = $this->cliente_beneficiario_to_string;
    }

    public function get_cliente_beneficiario_to_string()
    {
        if(!empty($this->cliente_beneficiario_to_string))
        {
            return $this->cliente_beneficiario_to_string;
        }
    
        $values = Cliente::where('beneficiario_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = CobrancaTitulo::where('beneficiario_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = CobrancaTitulo::where('beneficiario_id', '=', $this->id)->getIndexedArray('parametros_bancos_id','{parametros_bancos->id}');
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
    
        $values = CobrancaTitulo::where('beneficiario_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->id}');
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
    
        $values = CobrancaTitulo::where('beneficiario_id', '=', $this->id)->getIndexedArray('status','{fk_status->nome}');
        return implode(', ', $values);
    }

    public function set_parametros_bancos_banco_to_string($parametros_bancos_banco_to_string)
    {
        if(is_array($parametros_bancos_banco_to_string))
        {
            $values = Banco::where('id', 'in', $parametros_bancos_banco_to_string)->getIndexedArray('apelido', 'apelido');
            $this->parametros_bancos_banco_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_bancos_banco_to_string = $parametros_bancos_banco_to_string;
        }

        $this->vdata['parametros_bancos_banco_to_string'] = $this->parametros_bancos_banco_to_string;
    }

    public function get_parametros_bancos_banco_to_string()
    {
        if(!empty($this->parametros_bancos_banco_to_string))
        {
            return $this->parametros_bancos_banco_to_string;
        }
    
        $values = ParametrosBancos::where('beneficiario_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
        return implode(', ', $values);
    }

    public function set_parametros_bancos_beneficiario_to_string($parametros_bancos_beneficiario_to_string)
    {
        if(is_array($parametros_bancos_beneficiario_to_string))
        {
            $values = Beneficiario::where('id', 'in', $parametros_bancos_beneficiario_to_string)->getIndexedArray('id', 'id');
            $this->parametros_bancos_beneficiario_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_bancos_beneficiario_to_string = $parametros_bancos_beneficiario_to_string;
        }

        $this->vdata['parametros_bancos_beneficiario_to_string'] = $this->parametros_bancos_beneficiario_to_string;
    }

    public function get_parametros_bancos_beneficiario_to_string()
    {
        if(!empty($this->parametros_bancos_beneficiario_to_string))
        {
            return $this->parametros_bancos_beneficiario_to_string;
        }
    
        $values = ParametrosBancos::where('beneficiario_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
        return implode(', ', $values);
    }

    public function set_parametros_bancos_workspaces_santander_to_string($parametros_bancos_workspaces_santander_to_string)
    {
        if(is_array($parametros_bancos_workspaces_santander_to_string))
        {
            $values = WorkspacesSantander::where('id', 'in', $parametros_bancos_workspaces_santander_to_string)->getIndexedArray('id', 'id');
            $this->parametros_bancos_workspaces_santander_to_string = implode(', ', $values);
        }
        else
        {
            $this->parametros_bancos_workspaces_santander_to_string = $parametros_bancos_workspaces_santander_to_string;
        }

        $this->vdata['parametros_bancos_workspaces_santander_to_string'] = $this->parametros_bancos_workspaces_santander_to_string;
    }

    public function get_parametros_bancos_workspaces_santander_to_string()
    {
        if(!empty($this->parametros_bancos_workspaces_santander_to_string))
        {
            return $this->parametros_bancos_workspaces_santander_to_string;
        }
    
        $values = ParametrosBancos::where('beneficiario_id', '=', $this->id)->getIndexedArray('workspaces_santander_id','{workspaces_santander->id}');
        return implode(', ', $values);
    }

    
}

