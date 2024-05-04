<?php
 
use Mpdf\Mpdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

 
// BoletoPrintStatico::pdf($cobranca_id)
class PrintBoletoBanrisul  
{
    /**
     * Display a listing of the resource.
     *composer require mpdf/mpdf
     *composer require picqer/php-barcode-generator   
        *bacon/bacon-qr-code:^2.0
        *endroid/qr-code:5.0
        *mpdf/mpdf:8.2
     * @return \Illuminate\Http\Response
     */
    public static function GetPDF($id,$tipo=null)
    {

            $ObjetoImprimir = CobrancaTitulo::find($id);
            $LayoutITAU =  LayoutBancos::find(8);
            $ParametrosBancos = ParametrosBancos::find($ObjetoImprimir->parametros_bancos_id);
            $Bendeficiario = Beneficiario::find($ObjetoImprimir->beneficiario_id);
            $Cliente = Cliente::find($ObjetoImprimir->cliente_id);
 
 
        $dados = new stdClass();
        $dados->cobranca = new stdClass();
        $dados->cobranca->numero = $ObjetoImprimir->seunumero;
        $dados->cobranca->linhadigitavel = $ObjetoImprimir->linhadigitavel;
        $dados->cobranca->codigoBarraNumerico = $ObjetoImprimir->codigobarras;
        $dados->cobranca->Vencimento = date('d/m/Y', strtotime($ObjetoImprimir->data_vencimento));
        $data_vencimento = $dados->cobranca->Vencimento;
        $dados->beneficiario = new stdClass();
        $dados->beneficiario->cnpj = $Bendeficiario->cnpj;
        $dados->beneficiario->nome = $Bendeficiario->razao;
        $DataDoDoc = date('d/m/Y H:i:s', strtotime($ObjetoImprimir->created_at));
        $dados->pagador = new stdClass();
        $nome = $dados->pagador->nome = $Cliente->nome;
        $documento =  $dados->pagador->documento =  $Cliente->cpf_cnpj;
        $dados->pagador->documento = $Cliente->cpf_cnpj;
        $dados->pagador->endereco = $Cliente->cobranca_endereco;
        $dados->pagador->numero = $Cliente->cobranca_numero;
        $dados->pagador->bairro = $Cliente->cobranca_bairro;
        $dados->pagador->cidade = $Cliente->cobranca_cidade;
        $dados->pagador->uf = $Cliente->cobranca_uf;
        $dados->pagador->cep = $Cliente->cobranca_cep;


 
        $ValorDocumento = number_format($ObjetoImprimir->valor, 2, ",", ".");

        $AgenciCodDoCedente = $ParametrosBancos->agencia;
        $RuaNumeroBairro = $dados->pagador->endereco . ', ' . $dados->pagador->numero . ' ' . $dados->pagador->bairro;

        $DataDoProces = date('d/m/Y  H:i:s', strtotime($ObjetoImprimir->data_cadastro));
        $NumeroDodoc =    $ObjetoImprimir->nossonumero;
        $CidadeUf = 'Cidade: ' . $dados->pagador->cidade . '-' . 'UF: ' . $dados->pagador->uf;

        $dadosbanco = $ParametrosBancos->agencia . '-' . $ParametrosBancos->digito_agencia . '  /  ' . $ParametrosBancos->numerocontacorrente . '-' . $ParametrosBancos->digito_conta;
        $NossoNumero = $ObjetoImprimir->seunumero;

        $CEP = 'CEP: ' . $dados->pagador->cep;

        $especie = "DM";

        $info =
            $ParametrosBancos->mens1 . '<br>'
            . $ParametrosBancos->mens2 . '<br>'
            . $ParametrosBancos->mens3 . '<br>'

            . $ParametrosBancos->info5 . ' ' . $ObjetoImprimir->cobranca_id;

        $dados->beneficiario->digito_agencia = $ObjetoImprimir->digito_agencia;
        $dados->beneficiario->numerocontacorrente = $ObjetoImprimir->numerocontacorrente;
        $dados->beneficiario->digito_conta = $ObjetoImprimir->digito_conta;
        function formatarCNPJ($cnpj)
        {
            $cnpj = preg_replace('/[^0-9]/', '', $cnpj); // Remove caracteres não numéricos
            $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT); // Completa com zeros à esquerda, se necessário
            $cnpjFormatado = substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12);
            return $cnpjFormatado;
        }

        $cnpj = formatarCNPJ($dados->beneficiario->cnpj);
        $Cedente = ($dados->beneficiario->nome);

        if (strlen($documento  === 11)) {
            $CpfDoSacado = 'CPF: ' . $documento;
        } else {
            $CpfDoSacado = 'CNPJ: ' . $documento;
        }



 
        $creditos = '';
        $instrucoes = '';
        $urlApi = '';
        $resultado = '041-8';
  
        $linhadigitavel = $ObjetoImprimir->linhadigitavel;
        $numero = $linhadigitavel;
        $nomeArquivo = $numero . '.pdf';
        $generatorPNG = new BarcodeGeneratorPNG();
        $bar_code = $generatorPNG->getBarcode($ObjetoImprimir->codigobarras, $generatorPNG::TYPE_CODE_128, 2, 50, [0, 0, 0]);
        $img_base64 = base64_encode($bar_code);
        $barra = '<img src="data:image/png;base64,' . $img_base64 . '" width="520">';



              $logo_banco =   'https://'.$_SERVER['HTTP_HOST'].'/'.$LayoutITAU->logomarca;
                $digito= CalculosTaxasBanrisul::DigitosVerificadores($ObjetoImprimir->nossonumero);;
        
            // $partes = explode(".", $digito);
     
            // $ultimoDigito = $partes[1];
            

        
          $digito_verificador=$digito ;

            $css = 'https://' . $_SERVER['HTTP_HOST'] . '/css/css_itau.css';
            
            $mpdf = new Mpdf();
            
             

 
        $html = " 
       
 <!DOCTYPE HTML>
        <html>

        <head>
            <link rel='stylesheet' href='{$css}'>

        </head>

        <body>
            <TABLE cellSpacing=0 cellPadding=0 border=0 class=Boleto>

                <TR>
                    <TD style='width: 0.9cm'></TD>
                    <TD style='width: 1cm'></TD>
                    <TD style='width: 1.9cm'></TD>

                    <TD style='width: 0.5cm'></TD>
                    <TD style='width: 1.3cm'></TD>
                    <TD style='width: 0.8cm'></TD>
                    <TD style='width: 1cm'></TD>

                    <TD style='width: 1.9cm'></TD>
                    <TD style='width: 1.9cm'></TD>

                    <TD style='width: 3.8cm'></TD>

                    <TD style='width: 3.8cm'> </TD>

                <tr>
                    <td colspan=11>
                        <table border='0' cellspacing='0' style='border-collapse:collapse; width:100%'>
                            <tbody>
                                <tr>
                                    <td style='width:965px'>
                                        <ul>
                                            <li><span style='font-family:Verdana,Geneva,sans-serif'><span
                                                        style='font-size:11px'>Imprima em papel A4 ou Carta</span></span></li>
                                            <li><span style='font-family:Verdana,Geneva,sans-serif'><span
                                                        style='font-size:11px'>Utilize margens m&iacute;nimas a direita e a
                                                        esquerda</span></span></li>
                                            <li><span style='font-family:Verdana,Geneva,sans-serif'><span
                                                        style='font-size:11px'>Recorte na linha pontilhada</span></span></li>
                                            <li><span style='font-family:Verdana,Geneva,sans-serif'><span
                                                        style='font-size:11px'>N&atilde;o rasure o c&oacute;digo de
                                                        barras</span></span>


                                        </ul>
                                        </li>
                                        </ul>
                                    </td>
                                    <td style='text-align:right; width:137px'> </td>
                                    <td style='text-align:right; width:86px'>  </td>
                                </tr>
                            </tbody>
                        </table>

                        <table border='0' cellpadding='1' cellspacing='1' style='width:100%'>
                            <tbody>
                                <tr>
                                    <td class=Pontilhado></td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                </TR>
                <tr>
                    <td colspan=11 class=BoletoPontilhado>&nbsp;</td>
                </tr>
                <TR>
                    <TD colspan=4 class=BoletoLogo><img src='$logo_banco' width='150'>
                    </TD>
                    <TD colspan=2 class=BoletoCodigoBanco> $resultado </TD>
                    <TD colspan=6 class=Boletolinhadigitavel>$numero</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoTituloEsquerdo>Local de Pagamento</TD>
                    <TD class=BoletoTituloDireito>Vencimento</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoValorEsquerdo style='text-align: left; padding-left : 0.1cm'> ATÉ O VENC.
                        PREFERENCIALMENTE NO BANCO DO SANTANDER
                    </TD>
                    <TD class=BoletoValorDireito>$data_vencimento</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoTituloEsquerdo> Nome do Beneficários</TD>
                    <TD class=BoletoTituloDireito>Agência/Código do Beneficário</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoValorEsquerdo style='text-align: left; padding-left : 0.1cm'>$Cedente CNPJ: $cnpj
                    </TD>
                    <TD class=BoletoValorDireito>$dadosbanco</TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoTituloEsquerdo>Data do Documento</TD>
                    <TD colspan=4 class=BoletoTituloEsquerdo>Número do Documento</TD>
                    <TD class=BoletoTituloEsquerdo>Espécie</TD>
                    <TD class=BoletoTituloEsquerdo>Aceite</TD>
                    <TD class=BoletoTituloEsquerdo>Data do Processamento</TD>
                    <TD class=BoletoTituloDireito>Nosso Número</TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoValorEsquerdo>$DataDoDoc</TD>
                    <TD colspan=4 class=BoletoValorEsquerdo>$NumeroDodoc</TD>
                    <TD class=BoletoValorEsquerdo>$especie</TD>
                    <TD class=BoletoValorEsquerdo>N</TD>
                    <TD class=BoletoValorEsquerdo>$DataDoProces</TD>
                    <TD class=BoletoValorDireito>$digito_verificador </TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoTituloEsquerdo>Uso do Banco</TD>
                    <TD colspan=2 class=BoletoTituloEsquerdo>Carteira</TD>
                    <TD colspan=2 class=BoletoTituloEsquerdo>Moeda</TD>
                    <TD colspan=2 class=BoletoTituloEsquerdo>Quantidade</TD>
                    <TD class=BoletoTituloEsquerdo>(x) Valor</TD>
                    <TD class=BoletoTituloDireito>(=) Valor do Documento</TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoValorEsquerdo>&nbsp;</TD>
                    <TD colspan=2 class=BoletoValorEsquerdo> 109 </TD>
                    <TD colspan=2 class=BoletoValorEsquerdo>R$</TD>
                    <TD colspan=2 class=BoletoValorEsquerdo>&nbsp;</TD>
                    <TD class=BoletoValorEsquerdo>&nbsp;</TD>
                    <TD class=BoletoValorDireito>$ValorDocumento</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoTituloEsquerdo>Instruções
                     
            </TD>
        </TR>
                    </TD>
                    <TD class=BoletoTituloDireito>(-) Desconto</TD>
                </TR>
                <TR>
                    <TD colspan=10 rowspan=9 class=BoletoValorEsquerdo
                        style='text-align: left; vertical-align:top; padding-left : 0.1cm'> $info</TD>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(-) Outras Deduções/Abatimento</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(+) Mora/Multa/Juros</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(+) Outros Acréscimos</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(=) Valor Cobrado</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD rowspan=3 Class=BoletoTituloSacado>Pagador: </TD>
                    <TD colspan=8 Class=BoletoValorSacado>$nome</TD>
                    <TD colspan=2 Class=BoletoValorSacado>$CpfDoSacado</TD>
                </TR>
                <TR>
                    <TD colspan=10 Class=BoletoValorSacado>$RuaNumeroBairro</TD>
                </TR>
                <TR>
                    <TD colspan=10 Class=BoletoValorSacado>$CidadeUf&nbsp;&nbsp;&nbsp;$CEP</TD>
                </TR>
                <TR>
                    <TD colspan=2 Class=BoletoTituloSacador>Pagador / Avalista:</TD>
                    <TD colspan=9 Class=BoletoValorSacador>...</TD>
                </TR>
                <TR>
                    <TD colspan=11 class=BoletoTituloDireito style='text-align: right; padding-right: 0.1cm'>Recibo do Pagador -
                        Autenticação Mecânica</TD>
                </TR>
                <TR>
                    <TD class=ambiente colspan=11 valign=top>$instrucoes</TD>
                </TR>
                <tr>

                    <td colspan=11 class=BoletoPontilhado>&nbsp;</td>
                </tr>
                <TR>
                    <TD colspan=4 class=BoletoLogo><img src='$logo_banco' width=' 150'>
                    </TD>
                    <TD colspan=2 class=BoletoCodigoBanco> $resultado</TD>
                    <TD colspan=6 class=Boletolinhadigitavel>$numero</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoTituloEsquerdo>Local de Pagamento</TD>
                    <TD class=BoletoTituloDireito>Vencimento</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoValorEsquerdo style='text-align: left; padding-left : 0.1cm'> ATÉ O VENC.
                        PREFERENCIALMENTE NO BANCO DO ITAU
                    </TD>
                    <TD class=BoletoValorDireito>$data_vencimento</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoTituloEsquerdo>Nome do Beneficário</TD>
                    <TD class=BoletoTituloDireito>Agência/Código do Beneficário</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoValorEsquerdo style='text-align: left; padding-left : 0.1cm'>$Cedente CNPJ: $cnpj
                    </TD>
                    <TD class=BoletoValorDireito>$dadosbanco</TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoTituloEsquerdo>Data do Documento</TD>
                    <TD colspan=4 class=BoletoTituloEsquerdo>Número do Documento</TD>
                    <TD class=BoletoTituloEsquerdo>Espécie</TD>
                    <TD class=BoletoTituloEsquerdo>Aceite</TD>
                    <TD class=BoletoTituloEsquerdo>Data do Processamento</TD>
                    <TD class=BoletoTituloDireito>Nosso Número</TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoValorEsquerdo>$DataDoDoc</TD>
                    <TD colspan=4 class=BoletoValorEsquerdo>$NumeroDodoc</TD>
                    <TD class=BoletoValorEsquerdo>$especie</TD>
                    <TD class=BoletoValorEsquerdo>N</TD>
                    <TD class=BoletoValorEsquerdo>$DataDoProces</TD>
                    <TD class=BoletoValorDireito>$digito_verificador </TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoTituloEsquerdo>Uso do Banco</TD>
                    <TD colspan=2 class=BoletoTituloEsquerdo>Carteira</TD>
                    <TD colspan=2 class=BoletoTituloEsquerdo>Moeda</TD>
                    <TD colspan=2 class=BoletoTituloEsquerdo>Quantidade</TD>
                    <TD class=BoletoTituloEsquerdo>(x) Valor</TD>
                    <TD class=BoletoTituloDireito>(=) Valor do Documento</TD>
                </TR>
                <TR>
                    <TD colspan=3 class=BoletoValorEsquerdo>&nbsp;</TD>
                    <TD colspan=2 class=BoletoValorEsquerdo> 109 </TD>
                    <TD colspan=2 class=BoletoValorEsquerdo>R$</TD>
                    <TD colspan=2 class=BoletoValorEsquerdo>&nbsp;</TD>
                    <TD class=BoletoValorEsquerdo>&nbsp;</TD>
                    <TD class=BoletoValorDireito>$ValorDocumento</TD>
                </TR>
                <TR>
                    <TD colspan=10 class=BoletoTituloEsquerdo>Instruções</TD>
                    <TD class=BoletoTituloDireito>(-) Desconto</TD>
                </TR>
                <TR>
                    <TD colspan=10 rowspan=9 class=BoletoValorEsquerdo
                        style='text-align: left; vertical-align:top; padding-left : 0.1cm'> $info</TD>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(-) Outras Deduções/Abatimento</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(+) Mora/Multa/Juros</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(+) Outros Acréscimos</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD class=BoletoTituloDireito>(=) Valor Cobrado</TD>
                </TR>
                <TR>
                    <TD class=BoletoValorDireito>&nbsp;</TD>
                </TR>
                <TR>
                    <TD rowspan=3 Class=BoletoTituloSacado>Pagador: </TD>
                    <TD colspan=8 Class=BoletoValorSacado>$nome</TD>
                    <TD colspan=2 Class=BoletoValorSacado>$CpfDoSacado</TD>
                </TR>
                <TR>
                    <TD colspan=10 Class=BoletoValorSacado>$RuaNumeroBairro</TD>
                </TR>
                <TR>
                    <TD colspan=10 Class=BoletoValorSacado>$CidadeUf&nbsp;&nbsp;&nbsp;$CEP</TD>
                </TR>
                <TR>
                    <TD colspan=2 Class=BoletoTituloSacador>Pagador / Avalista:</TD>
                    <TD colspan=9 Class=BoletoValorSacador>...</TD>
                </TR>
                <TR>
                    <TD colspan=11 class=BoletoTituloDireito style='text-align: right; padding-right: 0.1cm'>Ficha de
                        Compensação - Autenticação Mecânica</TD>
                </TR>
                <TR>
                    <TD colspan=11 height=60 valign=top>" . $barra . "</TD>
                </TR>
                <tr>
                    <td colspan=11 class=Pontilhado> </td>

                </tr>

            </TABLE>
 ";
        

// Adiciona o HTML ao mPDF
$mpdf->WriteHTML($html);

 
$pastaDestino = "documentos/pdf/barrisul/boleto/";

// Verifica se a pasta de destino existe, e se não, a cria
if (!is_dir($pastaDestino)) {
    mkdir($pastaDestino, 0777, true);
}

// Gera um nome de arquivo único para o PDF
$nomeArquivo = $pastaDestino .$ObjetoImprimir->linhadigitavel. '-Boleto.pdf';

// Saída do PDF para o arquivo
$mpdf->Output($nomeArquivo, 'F');

 if($tipo<>1){

    $window = TWindow::create('PDF', 0.8, 0.8);
    
    $object = new TElement('iframe');
    $object->src  = $nomeArquivo ;
    $object->type  = 'application/pdf';
    $object->style = "width: 100%; height:calc(100% - 10px)";
    
    $window->add($object);
    $window->show();
}else{
   return  $nomeArquivo; 
    
}
 
  }
}
