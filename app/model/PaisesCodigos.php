<?php

class PaisesCodigos extends TRecord
{
    const TABLENAME  = 'paises_codigos';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codigo');
        parent::addAttribute('fone');
        parent::addAttribute('iso');
        parent::addAttribute('iso3');
        parent::addAttribute('nome');
        parent::addAttribute('nomeFormal');
            
    }

    
}

