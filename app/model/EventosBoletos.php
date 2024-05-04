<?php

class EventosBoletos extends TRecord
{
    const TABLENAME  = 'eventos_boletos';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('linhaDigitavel');
        parent::addAttribute('codigoBarras');
        parent::addAttribute('caminho_pdf');
        parent::addAttribute('data_cadastro');
        parent::addAttribute('parametros_bancos_id');
        parent::addAttribute('system_unit_id');
        parent::addAttribute('documento_id');
        parent::addAttribute('mensagem');
        parent::addAttribute('codigo');
        parent::addAttribute('updated_at');
        parent::addAttribute('created_at');
        parent::addAttribute('qrCode');
        parent::addAttribute('txid');
        parent::addAttribute('cobranca_titulo_id');
        parent::addAttribute('url_banco');
        parent::addAttribute('numerocontratocobranca');
        parent::addAttribute('codigocliente');
        parent::addAttribute('numerocarteira');
        parent::addAttribute('numerovariacaocarteira');
        parent::addAttribute('seunumero');
        parent::addAttribute('caminho_boleto');
        parent::addAttribute('nosso_numero_banco');
        parent::addAttribute('print');
        parent::addAttribute('titulo');
        parent::addAttribute('user_id');
        parent::addAttribute('prorrogacao_data');
            
    }

    
}

