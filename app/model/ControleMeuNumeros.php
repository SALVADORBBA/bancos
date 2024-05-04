<?php

class ControleMeuNumeros extends TRecord
{
    const TABLENAME  = 'controle_meu_numeros';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $system_unit;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('parametros_bancos_id');
        parent::addAttribute('ultimo_numero');
        parent::addAttribute('numero_anterior');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('status');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('banco_id');
            
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

    
}

