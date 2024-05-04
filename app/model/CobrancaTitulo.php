<?php

class CobrancaTitulo extends TRecord
{
    const TABLENAME  = 'cobranca_titulo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $beneficiario;
    private $cliente;
    private $parametros_bancos;
    private $fk_status;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('beneficiario_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('parametros_bancos_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('valor');
        parent::addAttribute('data_vencimento');
        parent::addAttribute('novaDataVencimento');
        parent::addAttribute('emissao_tipo');
        parent::addAttribute('bancos_modulos_id');
        parent::addAttribute('status');
        parent::addAttribute('tipo');
        parent::addAttribute('identificacaoboletoempresa');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('valorabatimento');
        parent::addAttribute('seunumero');
        parent::addAttribute('caminho_boleto');
        parent::addAttribute('user_id');
        parent::addAttribute('data_baixa');
        parent::addAttribute('descricao_baixa');
        parent::addAttribute('numero_bb');
        parent::addAttribute('DataDoProces');
        parent::addAttribute('qrcode');
        parent::addAttribute('linhadigitavel');
        parent::addAttribute('codigobarras');
        parent::addAttribute('digito_verificador_global');
        parent::addAttribute('modelo');
        parent::addAttribute('avalista_id');
        parent::addAttribute('identificador');
        parent::addAttribute('txid');
        parent::addAttribute('nossonumero');
        parent::addAttribute('pdfboletobase64');
        parent::addAttribute('xml_create_boleto');
        parent::addAttribute('xml_response');
        parent::addAttribute('xml_alteracao_boleto');
        parent::addAttribute('xml_baixa_boleto');
        parent::addAttribute('url_bb');
        parent::addAttribute('emv');
        parent::addAttribute('databaixa');
        parent::addAttribute('horariobaixa');
        parent::addAttribute('id_titulo_empresa');
        parent::addAttribute('url_imagem');
    
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
     * Method set_cliente
     * Sample of usage: $var->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_cliente(Cliente $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Cliente instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
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
    /**
     * Method set_situacao_boleto
     * Sample of usage: $var->situacao_boleto = $object;
     * @param $object Instance of SituacaoBoleto
     */
    public function set_fk_status(SituacaoBoleto $object)
    {
        $this->fk_status = $object;
        $this->status = $object->id;
    }

    /**
     * Method get_fk_status
     * Sample of usage: $var->fk_status->attribute;
     * @returns SituacaoBoleto instance
     */
    public function get_fk_status()
    {
    
        // loads the associated object
        if (empty($this->fk_status))
            $this->fk_status = new SituacaoBoleto($this->status);
    
        // returns the associated object
        return $this->fk_status;
    }

 
            // Se houver uma data de baixa, considera o título como "QUITADO"
public function get_vencimento_situacao() {
    $cor = '';
    $texto = '';

    if (!empty($this->databaixa)) {
        // Se houver uma data de baixa, verifica se é igual à data atual
        if ($this->databaixa == date('Y-m-d')) {
            // QUITADO Hoje
            $cor = 'success';
            $texto = '⚪ QUITADO Hoje';
        } else {
            // QUITADO
            $cor = 'success';
            $texto = '⚪ QUITADO';
        }
    } else {
        // Se não houver data de baixa, verifica a data de vencimento
        $today = date('Y-m-d');
        $dt_vencimento = $this->data_vencimento;

        if ($dt_vencimento < $today) {
            // VENCIDO
            $cor = 'danger';
            $texto = '🔴 VENCIDO';
        } elseif ($dt_vencimento == $today) {
            // VENCE HOJE
            $cor = 'primary';
            $texto = '🟣 VENCE HOJE';
        } else {
            // A VENCER
            $cor = 'info';
            $texto = '🔵 A VENCER';
        }
    }

    $label = "<h6><span class='badge badge-{$cor}'>{$texto}</span></h6>";

    return $label;
}

    
}

