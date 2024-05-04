<?php

class WorkspacesSantander extends TRecord
{
    const TABLENAME  = 'workspaces_santander';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $parametros_bancos;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('status');
        parent::addAttribute('type');
        parent::addAttribute('description');
        parent::addAttribute('covenant_code');
        parent::addAttribute('bank_slip_billing_webhook_active');
        parent::addAttribute('pix_billing_webhook_active');
        parent::addAttribute('parametros_bancos_id');
        parent::addAttribute('id_remoto');
        parent::addAttribute('webhookurl');
            
    }

    /**
     * Method set_parametros_bancos
     * Sample of usage: $var->parametros_bancos = $object;
     * @param $object Instance of ParametrosBancos
     */
    public function set_parametros_bancos(ParametrosBancos $object)
    {
        $this->parametros_bancos = $object;
        $this->parametros_bancos_id = $object->id;
    }

    /**
     * Method get_parametros_bancos
     * Sample of usage: $var->parametros_bancos->attribute;
     * @returns ParametrosBancos instance
     */
    public function get_parametros_bancos()
    {
    
        // loads the associated object
        if (empty($this->parametros_bancos))
            $this->parametros_bancos = new ParametrosBancos($this->parametros_bancos_id);
    
        // returns the associated object
        return $this->parametros_bancos;
    }

    /**
     * Method getParametrosBancoss
     */
    public function getParametrosBancoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('workspaces_santander_id', '=', $this->id));
        return ParametrosBancos::getObjects( $criteria );
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
    
        $values = ParametrosBancos::where('workspaces_santander_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
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
    
        $values = ParametrosBancos::where('workspaces_santander_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = ParametrosBancos::where('workspaces_santander_id', '=', $this->id)->getIndexedArray('workspaces_santander_id','{workspaces_santander->id}');
        return implode(', ', $values);
    }

    
}

