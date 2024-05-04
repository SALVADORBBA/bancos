<?php

class CobrancaRestServicesMobi extends AdiantiRecordService
{
    const DATABASE      = 'conecatarbanco';
    const ACTIVE_RECORD = 'CobrancaTitulo';
    const ATTRIBUTES    = ['avalista_id','bancos_modulos_id','beneficiario_id','caminho_boleto','cliente_id','codigobarras','created_at','data_baixa','databaixa','DataDoProces','data_vencimento','descricao_baixa','digito_verificador_global','emissao_tipo','emv','horariobaixa','id','identificacaoboletoempresa','identificador','id_titulo_empresa','linhadigitavel','modelo','nossonumero','novaDataVencimento','numero_bb','parametros_bancos_id','pdfboletobase64','qrcode','seunumero','status','system_unit_id','tipo','txid','updated_at','url_bb','user_id','valor','valorabatimento','xml_alteracao_boleto','xml_baixa_boleto','xml_create_boleto','xml_response'];
    
    /**
     * load($param)
     *
     * Load an Active Records by its ID
     * 
     * @return The Active Record as associative array
     * @param $param['id'] Object ID
     */
    // Código gerado pelo snippet: "Conexão com banco de dados"
    

  

    
              // code

    
        // -----

    /**
     * delete($param)
     *
     * Delete an Active Records by its ID
     * 
     * @return The Operation result
     * @param $param['id'] Object ID
     */
    
    
    /**
     * store($param)
     *
     * Save an Active Records
     * 
     * @return The Operation result
     * @param $param['data'] Associative array with object data
     */
    
    
    /**
     * loadAll($param)
     *
     * List the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['offset']    Query offset
     *        $param['limit']     Query limit
     *        $param['order']     Query order by
     *        $param['direction'] Query order direction (asc, desc)
     *        $param['filters']   Query filters (array with field,operator,field)
     */
    
    
    /**
     * deleteAll($param)
     *
     * Delete the Active Records by the filter
     * 
     * @return Array of records
     * @param $param['filters']   Query filters (array with field,operator,field)
     */
}
