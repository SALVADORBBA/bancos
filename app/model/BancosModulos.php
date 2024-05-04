<?php

class BancosModulos extends TRecord
{
    const TABLENAME  = 'bancos_modulos';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('numero');
        parent::addAttribute('descricao');
        parent::addAttribute('status');
        parent::addAttribute('logo');
        parent::addAttribute('ambiente');
        parent::addAttribute('apelido');
        parent::addAttribute('system_unit_id');
            
    }

    
}

