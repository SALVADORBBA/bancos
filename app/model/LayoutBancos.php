<?php

class LayoutBancos extends TRecord
{
    const TABLENAME  = 'layout_bancos';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $bancos_modulos;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('bancos_modulos_id');
        parent::addAttribute('logomarca');
        parent::addAttribute('codigo_layout');
        parent::addAttribute('tipo_layout');
        parent::addAttribute('nome_arquivo_php');
        parent::addAttribute('nome_arquivo_css');
        parent::addAttribute('status');
        parent::addAttribute('imagem_layout');
            
    }

    /**
     * Method set_banco
     * Sample of usage: $var->banco = $object;
     * @param $object Instance of Banco
     */
    public function set_bancos_modulos(Banco $object)
    {
        $this->bancos_modulos = $object;
        $this->bancos_modulos_id = $object->id;
    }

    /**
     * Method get_bancos_modulos
     * Sample of usage: $var->bancos_modulos->attribute;
     * @returns Banco instance
     */
    public function get_bancos_modulos()
    {
    
        // loads the associated object
        if (empty($this->bancos_modulos))
            $this->bancos_modulos = new Banco($this->bancos_modulos_id);
    
        // returns the associated object
        return $this->bancos_modulos;
    }

    
}

