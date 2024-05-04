<?php

class ParametrosSicredi extends TRecord
{
    const TABLENAME  = 'parametros_sicredi';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $beneficiario;
    private $banco;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('banco_id');
        parent::addAttribute('beneficiario_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('numerocontrato');
        parent::addAttribute('numerocontacorrente');
        parent::addAttribute('modalidade');
        parent::addAttribute('identificacaoboletoempresa');
        parent::addAttribute('identificacaoemissaoboleto');
        parent::addAttribute('identificacaodistribuicaoboleto');
        parent::addAttribute('tipodesconto');
        parent::addAttribute('diasparadesconto_primeiro');
        parent::addAttribute('valorprimeirodesconto');
        parent::addAttribute('dataprimeirodesconto');
        parent::addAttribute('diasparadesconto_segundo');
        parent::addAttribute('datasegundodesconto');
        parent::addAttribute('valorsegundodesconto');
        parent::addAttribute('diasparadesconto_terceiro');
        parent::addAttribute('dataterceirodesconto');
        parent::addAttribute('valorTerceiroDesconto');
        parent::addAttribute('tipomulta');
        parent::addAttribute('tipojurosmora');
        parent::addAttribute('diasmultas');
        parent::addAttribute('valormulta');
        parent::addAttribute('diasjurosmora');
        parent::addAttribute('valorjurosmora');
        parent::addAttribute('codigoprotesto');
        parent::addAttribute('numerodiasprotesto');
        parent::addAttribute('codigonegativacao');
        parent::addAttribute('numerodiasnegativacao');
        parent::addAttribute('gerarpdf');
        parent::addAttribute('ambiente');
        parent::addAttribute('client_id');
        parent::addAttribute('apelido');
        parent::addAttribute('carteira');
        parent::addAttribute('certificado_base64');
        parent::addAttribute('agencia');
        parent::addAttribute('digito_agencia');
        parent::addAttribute('digito_conta');
        parent::addAttribute('username');
        parent::addAttribute('password');
        parent::addAttribute('scope');
        parent::addAttribute('info1');
        parent::addAttribute('info2');
        parent::addAttribute('info3');
        parent::addAttribute('info4');
        parent::addAttribute('info5');
        parent::addAttribute('mens1');
        parent::addAttribute('mens2');
        parent::addAttribute('mens3');
        parent::addAttribute('mens4');
        parent::addAttribute('cooperativa');
        parent::addAttribute('posto');
        parent::addAttribute('status');
        parent::addAttribute('codigobeneficiario');
        parent::addAttribute('cpfcnpjbeneficiario');
            
    }

    /**
     * Method set_beneficiario
     * Sample of usage: $var->beneficiario = $object;
     * @param $object Instance of Beneficiario
     */
    public function set_beneficiario(Beneficiario $object)
    {
        $this->beneficiario = $object;
        $this->beneficiario_id = $object->id;
    }

    /**
     * Method get_beneficiario
     * Sample of usage: $var->beneficiario->attribute;
     * @returns Beneficiario instance
     */
    public function get_beneficiario()
    {
    
        // loads the associated object
        if (empty($this->beneficiario))
            $this->beneficiario = new Beneficiario($this->beneficiario_id);
    
        // returns the associated object
        return $this->beneficiario;
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

