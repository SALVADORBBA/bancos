<?php

class Boleto extends TRecord
{
    const TABLENAME  = 'boleto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nossonumero');
        parent::addAttribute('codigobarras');
        parent::addAttribute('linhadigitavel');
        parent::addAttribute('pdfboleto');
        parent::addAttribute('pdf_nfe');
        parent::addAttribute('status');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('valor');
        parent::addAttribute('data_vencimento');
        parent::addAttribute('dataemissao');
        parent::addAttribute('xml');
        parent::addAttribute('cliente_id');
        parent::addAttribute('datavencimento_interno');
        parent::addAttribute('data_baixa');
        parent::addAttribute('mensagem_baixa');
        parent::addAttribute('parametros_banco_id');
            
    }

    
}

