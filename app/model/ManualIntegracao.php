<?php

class ManualIntegracao extends TRecord
{
    const TABLENAME  = 'manual_integracao';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'create_at';

    private $banco;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('banco_id');
        parent::addAttribute('arquivo');
        parent::addAttribute('create_at');
            
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

    
}

