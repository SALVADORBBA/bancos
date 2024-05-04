<?php

/**
 * 
 */
class SimuladorJsonBanrisul
{
    
    /**
     * 
     */
    public  static function gera($key)
    {
       
       
   
// Criando objetos
$retorno = new stdClass();
$titulo = new stdClass();
$beneficiario = new stdClass();
$pagador = new stdClass();
$instrucoes = new stdClass();
$juros = new stdClass();
$pag_parcial = new stdClass();

// Preenchendo os dados
$retorno->retorno = "04";

$titulo->nosso_numero = "0000000264";
$titulo->seu_numero = "64452-1";
$titulo->data_vencimento = "2021-05-05";
$titulo->valor_nominal = "150.50";
$titulo->especie = "99";
$titulo->data_emissao = "2021-03-17";
$titulo->id_titulo_empresa = "0011000000000000000064452";
$titulo->codigo_barras = "04191861100000150502100100000010000000024047";
$titulo->linha_digitavel = "04192100180000001000900000240473186110000015050";

$beneficiario->codigo = "0010000001088";
$beneficiario->tipo_pessoa = "J";
$beneficiario->cpf_cnpj = "92702067000196";
$beneficiario->nome = "BANRISUL COBRANCA-TESTE";
$beneficiario->nome_fantasia = "BANRISUL";

$pagador->tipo_pessoa = "F";
$pagador->cpf_cnpj = "00000000191";
$pagador->nome = "PAGADOR FICTICIO";
$pagador->endereco = "RUA CALDAS JUNIOR 120";
$pagador->cep = "90010260";
$pagador->cidade = "PORTO ALEGRE";
$pagador->uf = "RS";
$pagador->aceite = "A";

$juros->codigo = "3";
$instrucoes->juros = $juros;

$pag_parcial->autoriza = "1";
$pag_parcial->codigo = "3";

$titulo->beneficiario = $beneficiario;
$titulo->pagador = $pagador;
$titulo->instrucoes = $instrucoes;
$titulo->pag_parcial = $pag_parcial;

$retorno->titulo = $titulo;

// Convertendo para JSON
$json = json_encode($retorno);

// Mostrando o JSON
return  $json;

    }
}