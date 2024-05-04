<?php

class BoletoServices extends AdiantiRecordService
{
    const DATABASE      = 'conecatarbanco';
    const ACTIVE_RECORD = 'CobrancaTitulo';
    const ATTRIBUTES    = ['avalista_id','bancos_modulos_id','beneficiario_id','caminho_boleto','cliente_id','codigobarras','created_at','data_baixa','databaixa','DataDoProces','data_vencimento','descricao_baixa','digito_verificador_global','emissao_tipo','emv','horariobaixa','id','identificacaoboletoempresa','identificador','id_titulo_empresa','linhadigitavel','modelo','nossonumero','novaDataVencimento','numero_bb','parametros_bancos_id','pdfboletobase64','qrcode','seunumero','status','system_unit_id','tipo','txid','updated_at','url_bb','user_id','valor','valorabatimento','xml_alteracao_boleto','xml_baixa_boleto','xml_create_boleto','xml_response'];
 

   
  public function Cobranca() # MÉTODO PARA LISTAR AS PESSOAS ATIVAS
    {
        try
        {
            TTransaction::open(self::DATABASE);
            $pessoas = CobrancaTitulo::where('status', '=', 1)->get();
            if ($pessoas)
            {
                $retorno = array();
                foreach ($pessoas as $pessoa) 
                {
                    $retorno[] = $pessoa->toArray();
                }
                return $retorno;
            } else {
                return array('situacao' => 'erro', 'retorno' => "NENHUM REGISTRO FOI ENCONTRADO");
            }
            TTransaction::close();
        } catch (Exception $e) {
            return array('situacao' => 'erro', 'retorno' => $e->getMessage());
        }
    }
}
   