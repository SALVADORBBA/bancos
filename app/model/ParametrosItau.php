<?php

class ParametrosItau extends TRecord
{
    const TABLENAME  = 'parametros_itau';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $banco;
    private $beneficiario;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('banco_id');
        parent::addAttribute('beneficiario_id');
        parent::addAttribute('numerocontacorrente');
        parent::addAttribute('digito_conta');
        parent::addAttribute('agencia');
        parent::addAttribute('digito_agencia');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('tipos_documentos_id');
        parent::addAttribute('numerocontrato');
        parent::addAttribute('certificado');
        parent::addAttribute('senha');
        parent::addAttribute('modalidade');
        parent::addAttribute('tipomulta');
        parent::addAttribute('tipojurosmora');
        parent::addAttribute('diasmultas');
        parent::addAttribute('valormulta');
        parent::addAttribute('diasjurosmora');
        parent::addAttribute('valorjurosmora');
        parent::addAttribute('negativar');
        parent::addAttribute('numerodiasnegativar');
        parent::addAttribute('client_id');
        parent::addAttribute('username');
        parent::addAttribute('password');
        parent::addAttribute('emissor_certificado');
        parent::addAttribute('emissao_certificado');
        parent::addAttribute('proprietario_certificado');
        parent::addAttribute('validade_certificado');
        parent::addAttribute('validar_certificado');
        parent::addAttribute('observacao');
        parent::addAttribute('info1');
        parent::addAttribute('info2');
        parent::addAttribute('info3');
        parent::addAttribute('info4');
        parent::addAttribute('info5');
        parent::addAttribute('mens1');
        parent::addAttribute('mens2');
        parent::addAttribute('mens3');
        parent::addAttribute('mens4');
        parent::addAttribute('token_api_local');
        parent::addAttribute('login_api');
        parent::addAttribute('senha_api');
        parent::addAttribute('chave_1');
        parent::addAttribute('chave_2');
        parent::addAttribute('chave_3');
        parent::addAttribute('chave_4');
        parent::addAttribute('api_endpoint_url_homologacao');
        parent::addAttribute('api_endpoint_url_producao');
        parent::addAttribute('client_secret');
        parent::addAttribute('status');
        parent::addAttribute('apelido');
        parent::addAttribute('chave_pix');
        parent::addAttribute('tipo_chave_pix');
        parent::addAttribute('client_id_bolecode');
        parent::addAttribute('client_secret_bolecode');
        parent::addAttribute('certificados_pix');
        parent::addAttribute('certificados_extra');
        parent::addAttribute('senha_certificado_pix');
        parent::addAttribute('senha_certificado_extra');
        parent::addAttribute('carteira');
        parent::addAttribute('certificado_base64');
        parent::addAttribute('certificado_pix_base64');
        parent::addAttribute('certificado_extra_base64');
            
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

    
}

