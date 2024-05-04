<?php

class SystemUnit extends TRecord
{
    const TABLENAME  = 'system_unit';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('connection_name');
            
    }

    /**
     * Method getBeneficiarios
     */
    public function getBeneficiarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_unit_id', '=', $this->id));
        return Beneficiario::getObjects( $criteria );
    }
    /**
     * Method getBancos
     */
    public function getBancos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_unit_id', '=', $this->id));
        return Banco::getObjects( $criteria );
    }
    /**
     * Method getControleMeuNumeross
     */
    public function getControleMeuNumeross()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('system_unit_id', '=', $this->id));
        return ControleMeuNumeros::getObjects( $criteria );
    }

    public function set_beneficiario_system_unit_to_string($beneficiario_system_unit_to_string)
    {
        if(is_array($beneficiario_system_unit_to_string))
        {
            $values = SystemUnit::where('id', 'in', $beneficiario_system_unit_to_string)->getIndexedArray('name', 'name');
            $this->beneficiario_system_unit_to_string = implode(', ', $values);
        }
        else
        {
            $this->beneficiario_system_unit_to_string = $beneficiario_system_unit_to_string;
        }

        $this->vdata['beneficiario_system_unit_to_string'] = $this->beneficiario_system_unit_to_string;
    }

    public function get_beneficiario_system_unit_to_string()
    {
        if(!empty($this->beneficiario_system_unit_to_string))
        {
            return $this->beneficiario_system_unit_to_string;
        }
    
        $values = Beneficiario::where('system_unit_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    public function set_banco_system_unit_to_string($banco_system_unit_to_string)
    {
        if(is_array($banco_system_unit_to_string))
        {
            $values = SystemUnit::where('id', 'in', $banco_system_unit_to_string)->getIndexedArray('name', 'name');
            $this->banco_system_unit_to_string = implode(', ', $values);
        }
        else
        {
            $this->banco_system_unit_to_string = $banco_system_unit_to_string;
        }

        $this->vdata['banco_system_unit_to_string'] = $this->banco_system_unit_to_string;
    }

    public function get_banco_system_unit_to_string()
    {
        if(!empty($this->banco_system_unit_to_string))
        {
            return $this->banco_system_unit_to_string;
        }
    
        $values = Banco::where('system_unit_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    public function set_controle_meu_numeros_system_unit_to_string($controle_meu_numeros_system_unit_to_string)
    {
        if(is_array($controle_meu_numeros_system_unit_to_string))
        {
            $values = SystemUnit::where('id', 'in', $controle_meu_numeros_system_unit_to_string)->getIndexedArray('name', 'name');
            $this->controle_meu_numeros_system_unit_to_string = implode(', ', $values);
        }
        else
        {
            $this->controle_meu_numeros_system_unit_to_string = $controle_meu_numeros_system_unit_to_string;
        }

        $this->vdata['controle_meu_numeros_system_unit_to_string'] = $this->controle_meu_numeros_system_unit_to_string;
    }

    public function get_controle_meu_numeros_system_unit_to_string()
    {
        if(!empty($this->controle_meu_numeros_system_unit_to_string))
        {
            return $this->controle_meu_numeros_system_unit_to_string;
        }
    
        $values = ControleMeuNumeros::where('system_unit_id', '=', $this->id)->getIndexedArray('system_unit_id','{system_unit->name}');
        return implode(', ', $values);
    }

    
}

