<?php

class Banco extends TRecord
{
    const TABLENAME  = 'banco';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const sicoob = '1';

    private $system_unit;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('status');
        parent::addAttribute('numero');
        parent::addAttribute('logo');
        parent::addAttribute('ambiente');
        parent::addAttribute('apelido');
        parent::addAttribute('system_unit_id');
            
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
        $criteria->add(new TFilter('banco_id', '=', $this->id));
        return ParametrosItau::getObjects( $criteria );
    }
    /**
     * Method getParametrosSicredis
     */
    public function getParametrosSicredis()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('banco_id', '=', $this->id));
        return ParametrosSicredi::getObjects( $criteria );
    }
    /**
     * Method getParametrosBancoss
     */
    public function getParametrosBancoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('banco_id', '=', $this->id));
        return ParametrosBancos::getObjects( $criteria );
    }
    /**
     * Method getManualIntegracaos
     */
    public function getManualIntegracaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('banco_id', '=', $this->id));
        return ManualIntegracao::getObjects( $criteria );
    }
    /**
     * Method getLayoutBancoss
     */
    public function getLayoutBancoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('bancos_modulos_id', '=', $this->id));
        return LayoutBancos::getObjects( $criteria );
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
    
        $values = ParametrosItau::where('banco_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
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
    
        $values = ParametrosItau::where('banco_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = ParametrosSicredi::where('banco_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
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
    
        $values = ParametrosSicredi::where('banco_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = ParametrosBancos::where('banco_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
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
    
        $values = ParametrosBancos::where('banco_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = ParametrosBancos::where('banco_id', '=', $this->id)->getIndexedArray('workspaces_santander_id','{workspaces_santander->id}');
        return implode(', ', $values);
    }

    public function set_manual_integracao_banco_to_string($manual_integracao_banco_to_string)
    {
        if(is_array($manual_integracao_banco_to_string))
        {
            $values = Banco::where('id', 'in', $manual_integracao_banco_to_string)->getIndexedArray('apelido', 'apelido');
            $this->manual_integracao_banco_to_string = implode(', ', $values);
        }
        else
        {
            $this->manual_integracao_banco_to_string = $manual_integracao_banco_to_string;
        }

        $this->vdata['manual_integracao_banco_to_string'] = $this->manual_integracao_banco_to_string;
    }

    public function get_manual_integracao_banco_to_string()
    {
        if(!empty($this->manual_integracao_banco_to_string))
        {
            return $this->manual_integracao_banco_to_string;
        }
    
        $values = ManualIntegracao::where('banco_id', '=', $this->id)->getIndexedArray('banco_id','{banco->apelido}');
        return implode(', ', $values);
    }

    public function set_layout_bancos_bancos_modulos_to_string($layout_bancos_bancos_modulos_to_string)
    {
        if(is_array($layout_bancos_bancos_modulos_to_string))
        {
            $values = Banco::where('id', 'in', $layout_bancos_bancos_modulos_to_string)->getIndexedArray('apelido', 'apelido');
            $this->layout_bancos_bancos_modulos_to_string = implode(', ', $values);
        }
        else
        {
            $this->layout_bancos_bancos_modulos_to_string = $layout_bancos_bancos_modulos_to_string;
        }

        $this->vdata['layout_bancos_bancos_modulos_to_string'] = $this->layout_bancos_bancos_modulos_to_string;
    }

    public function get_layout_bancos_bancos_modulos_to_string()
    {
        if(!empty($this->layout_bancos_bancos_modulos_to_string))
        {
            return $this->layout_bancos_bancos_modulos_to_string;
        }
    
        $values = LayoutBancos::where('bancos_modulos_id', '=', $this->id)->getIndexedArray('bancos_modulos_id','{bancos_modulos->apelido}');
        return implode(', ', $values);
    }

    
}

