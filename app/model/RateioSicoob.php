<?php

class RateioSicoob extends TRecord
{
    const TABLENAME  = 'rateio_sicoob';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $parametros_bancos;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('parametros_bancos_id');
        parent::addAttribute('numerobanco');
        parent::addAttribute('numeroagencia');
        parent::addAttribute('numerocontacorrente');
        parent::addAttribute('contaprincipal');
        parent::addAttribute('codigotipovalorrateio');
        parent::addAttribute('valorrateio');
        parent::addAttribute('codigotipocalculorateio');
        parent::addAttribute('numerocpfcnpjtitular');
        parent::addAttribute('nometitular');
        parent::addAttribute('codigofinalidadeted');
        parent::addAttribute('codigotipocontadestinoted');
        parent::addAttribute('quantidadediasfloat');
        parent::addAttribute('datafloatcredito');
            
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

    
}

