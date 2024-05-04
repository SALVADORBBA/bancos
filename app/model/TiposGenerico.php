<?php

class TiposGenerico extends TRecord
{
    const TABLENAME  = 'tipos_generico';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_numerica');
        parent::addAttribute('titulo');
        parent::addAttribute('descricao');
        parent::addAttribute('chave');
        parent::addAttribute('bancos_modulos_id');
        parent::addAttribute('app');
        parent::addAttribute('status');
            
    }

    
}

