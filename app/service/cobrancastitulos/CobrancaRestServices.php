<?php

class CobrancaRestServices extends AdiantiRecordService
{
    const DATABASE      = 'conecatarbanco';
    const ACTIVE_RECORD = 'CobrancaTitulo';
    const ATTRIBUTES    = ['id','bancos_modulos_id','beneficiario_id','cliente_id','data_vencimento','parametros_bancos_id','user_id','valor'];
  
    public function dodos ($dados){
        // Carregar um registro com base no ID fornecido
        $registro = new CobrancaTitulo($dados['id']);
        
        // Verificar se o registro foi encontrado
        if ($registro->id) {
            // Exibir os dados do registro
            echo "ID: " . $registro->id . "<br>";
            echo "Banco Módulo ID: " . $registro->bancos_modulos_id . "<br>";
            echo "Beneficiário ID: " . $registro->beneficiario_id . "<br>";
            echo "Cliente ID: " . $registro->cliente_id . "<br>";
            echo "Data de Vencimento: " . $registro->data_vencimento . "<br>";
            echo "Parâmetros Banco ID: " . $registro->parametros_bancos_id . "<br>";
            echo "User ID: " . $registro->user_id . "<br>";
            echo "Valor: " . $registro->valor . "<br>";
        } else {
            echo "Registro não encontrado.";
        }
    }
}
