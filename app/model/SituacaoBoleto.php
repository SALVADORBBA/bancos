<?php

class SituacaoBoleto extends TRecord
{
    const TABLENAME  = 'situacao_boleto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const EMPROCESSO = '1';
    const EMABERTO = '2';
    const QUITADO = '3';
    const CANCELADO = '4';
    const NAODEFINIDO = '5';
    const AVENCER = '6';
    const VENCIDO = '7';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('cor');
            
    }

    /**
     * Method getCobrancaTitulos
     */
    public function getCobrancaTitulos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('status', '=', $this->id));
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
    
        $values = CobrancaTitulo::where('status', '=', $this->id)->getIndexedArray('beneficiario_id','{beneficiario->id}');
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
    
        $values = CobrancaTitulo::where('status', '=', $this->id)->getIndexedArray('parametros_bancos_id','{parametros_bancos->id}');
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
    
        $values = CobrancaTitulo::where('status', '=', $this->id)->getIndexedArray('cliente_id','{cliente->id}');
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
    
        $values = CobrancaTitulo::where('status', '=', $this->id)->getIndexedArray('status','{fk_status->nome}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(CobrancaTitulo::where('status', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

