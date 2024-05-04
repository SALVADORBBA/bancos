<?php

class StatusCobranca extends TRecord
{
    const TABLENAME  = 'status_cobranca';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codigoBeneficiario');
        parent::addAttribute('dia');
        parent::addAttribute('cpfCnpjBeneficiario');
        parent::addAttribute('status');
        parent::addAttribute('parametros_bancos_id');
        parent::addAttribute('banco_id');
            
    }

    
}

