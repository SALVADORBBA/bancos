<?php

class Cliente extends TRecord
{
    const TABLENAME  = 'cliente';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $beneficiario;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('beneficiario_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('nome');
        parent::addAttribute('razao_social');
        parent::addAttribute('cpf_cnpj');
        parent::addAttribute('insc_estadual');
        parent::addAttribute('email');
        parent::addAttribute('criado_em');
        parent::addAttribute('alterado_em');
        parent::addAttribute('fone');
        parent::addAttribute('cobranca_cep');
        parent::addAttribute('cobranca_endereco');
        parent::addAttribute('cobranca_bairro');
        parent::addAttribute('cobranca_uf');
        parent::addAttribute('cobranca_cidade');
        parent::addAttribute('cliente_situacao_id');
        parent::addAttribute('cobranca_cuf');
        parent::addAttribute('cobranca_lat');
        parent::addAttribute('cobranca_lng');
        parent::addAttribute('cobranca_cmun');
        parent::addAttribute('cobranca_email');
        parent::addAttribute('cobranca_numero');
        parent::addAttribute('observacoes');
        parent::addAttribute('cobranca_complemento');
        parent::addAttribute('status');
        parent::addAttribute('paises_codigos');
        parent::addAttribute('number');
            
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
     * Method getCobrancaTitulos
     */
    public function getCobrancaTitulos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return CobrancaTitulo::getObjects( $criteria );
    }

    public function set_cobranca_titulo_beneficiario_to_string($cobranca_titulo_beneficiario_to_string)
    {
        if(is_array($cobranca_titulo_beneficiario_to_string))
        {
            $values = Beneficiario::where('id', 'in', $cobranca_titulo_beneficiario_to_string)->getIndexedArray('id', 'id');
            $this->cobranca_titulo_beneficiario_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_beneficiario_to_string = $cobranca_titulo_beneficiario_to_string;
        }

        $this->vdata['cobranca_titulo_beneficiario_to_string'] = $this->cobranca_titulo_beneficiario_to_string;
    }

    public function get_cobranca_titulo_beneficiario_to_string()
    {
        if(!empty($this->cobranca_titulo_beneficiario_to_string))
        {
            return $this->cobranca_titulo_beneficiario_to_string;
        }
    
        $values = CobrancaTitulo::where('cliente_id', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_parametros_bancos_to_string($cobranca_titulo_parametros_bancos_to_string)
    {
        if(is_array($cobranca_titulo_parametros_bancos_to_string))
        {
            $values = ParametrosBancos::where('id', 'in', $cobranca_titulo_parametros_bancos_to_string)->getIndexedArray('id', 'id');
            $this->cobranca_titulo_parametros_bancos_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_parametros_bancos_to_string = $cobranca_titulo_parametros_bancos_to_string;
        }

        $this->vdata['cobranca_titulo_parametros_bancos_to_string'] = $this->cobranca_titulo_parametros_bancos_to_string;
    }

    public function get_cobranca_titulo_parametros_bancos_to_string()
    {
        if(!empty($this->cobranca_titulo_parametros_bancos_to_string))
        {
            return $this->cobranca_titulo_parametros_bancos_to_string;
        }
    
        $values = CobrancaTitulo::where('cliente_id', '=', $this->id)->getIndexedArray('parametros_bancos_id','{parametros_bancos->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_cliente_to_string($cobranca_titulo_cliente_to_string)
    {
        if(is_array($cobranca_titulo_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $cobranca_titulo_cliente_to_string)->getIndexedArray('id', 'id');
            $this->cobranca_titulo_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_cliente_to_string = $cobranca_titulo_cliente_to_string;
        }

        $this->vdata['cobranca_titulo_cliente_to_string'] = $this->cobranca_titulo_cliente_to_string;
    }

    public function get_cobranca_titulo_cliente_to_string()
    {
        if(!empty($this->cobranca_titulo_cliente_to_string))
        {
            return $this->cobranca_titulo_cliente_to_string;
        }
    
        $values = CobrancaTitulo::where('cliente_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->id}');
        return implode(', ', $values);
    }

    public function set_cobranca_titulo_fk_status_to_string($cobranca_titulo_fk_status_to_string)
    {
        if(is_array($cobranca_titulo_fk_status_to_string))
        {
            $values = SituacaoBoleto::where('id', 'in', $cobranca_titulo_fk_status_to_string)->getIndexedArray('nome', 'nome');
            $this->cobranca_titulo_fk_status_to_string = implode(', ', $values);
        }
        else
        {
            $this->cobranca_titulo_fk_status_to_string = $cobranca_titulo_fk_status_to_string;
        }

        $this->vdata['cobranca_titulo_fk_status_to_string'] = $this->cobranca_titulo_fk_status_to_string;
    }

    public function get_cobranca_titulo_fk_status_to_string()
    {
        if(!empty($this->cobranca_titulo_fk_status_to_string))
        {
            return $this->cobranca_titulo_fk_status_to_string;
        }
    
        $values = CobrancaTitulo::where('cliente_id', '=', $this->id)->getIndexedArray('status','{fk_status->nome}');
        return implode(', ', $values);
    }

    
}

