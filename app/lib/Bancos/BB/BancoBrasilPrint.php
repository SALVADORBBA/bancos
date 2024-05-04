<?php

/**
 * Classe SicrediBoletoCreate  boleto BancoBrasilPrint.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 * Construtor da classe BancoBrasilPrint
 * picqer/php-barcode-generator:^2.4
 * "picqer/php-barcode-generator": "^2.4.0",
 *  "endroid/qrcode": "^5.0"
 *   "mpdf/mpdf": "^8.2"
 * @param string $key - A chave para buscar os parâmetros no banco de dados. BancoBrasilPrint GetPDF
 */
 use Mpdf\Mpdf;
 

 
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Picqer\Barcode\BarcodeGeneratorPNG;
class BancoBrasilPrint
{
    private $key;
    private $parametros;
    private $titulos;
    private $LayoutBB;
    private $beneficiario;
    private $pessoas;

    /**  TTransaction::open(self::$database);;
    /**
     * Construtor da classe BancoBrasilPrint.
        *bacon/bacon-qr-code:^2.0
        *endroid/qr-code:5.0
        *mpdf/mpdf:8.2
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key,$tipo=null)
    {
        $this->key = $key;
        $this->tipo = $tipo;


                $this->titulos = CobrancaTitulo::find($this->key);
                $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
                $this->LayoutBB =  LayoutBancos::find(2);
                $this->beneficiario = Beneficiario::find($this->parametros->beneficiario_id);
                
                     $this->pessoas = Cliente::find($this->titulos->cliente_id);
    }

    public  function GetPDF()
    {
       
 
 
                        $path='app/bb';
                        
                        ############ criação diretorios########################
                        $Linhadigitavel =$this->titulos->linhadigitavel;
                        $nomeDiretorio = $path. '/' . $this->titulos->parametros_bancos_id;
                        $nomeArquivo = $nomeDiretorio . '/' . $Linhadigitavel . '.pdf';
                        
                        if (is_dir($nomeDiretorio)) {
                        } else {
                        mkdir($nomeDiretorio, 0777, true);
                        }
                        ############ criação diretorios########################
                        $codigobarras = $this->titulos->codigobarras;
                        $generatorPNG = new BarcodeGeneratorPNG();
                        $bar_code = $generatorPNG->getBarcode($this->titulos->codigobarras, $generatorPNG::TYPE_CODE_128, 2, 50, [0, 0, 0]);
                        $img_base64 = base64_encode($bar_code);
                        $barra = '<img src="data:image/png;base64,' . $img_base64 . '" width="520">';
                        
                        $dados = $this->titulos->emv;
                        
                        $caminhoImagem = $codigobarras . ".png";
                        
                                  #####################qrcode######################### 
                       
                        $path = 'app/bb/';
                        if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                        
                        }
                        $fileName=$this->titulos->linhadigitavel;
                        $qrCodeContent = $this->titulos->emv;
                        $qrCode = new QrCode($qrCodeContent);
                        $qrCode->setSize(130);
                        
                        $writer = new PngWriter();
                        
                        $filePath = $path . $fileName . '.png';
                        $writer->write($qrCode)->saveToFile($filePath);
                        $QrcodeNew= '<img src="' . $filePath . '" alt="QR Code">';
                        
                        #####################qrcode#########################
                        function formatarNumero($numero)
                        {
                        $quatroPrimeiros = substr($numero, 0, 4);
                        // Extrai os quatro primeiros números
                        
                        $formatado_linha = substr($quatroPrimeiros, 0, 3) . '-' . substr($quatroPrimeiros, 3);
                        // Formata no formato "001-9"
                        return $formatado_linha;
                        }
                        $data_vencimento =ClassMaster::data_BR($this->titulos->data_vencimento);
                        // Exemplo de uso:
        
                        $resultado = formatarNumero($this->titulos->linhadigitavel);
                        $Cedente =   $this->beneficiario->nome;
                        $cnpj =  $this->beneficiario->cnpj;
                                       
         
                        $dadosbanco =  $this->parametros->agencia . '-' . $this->parametros->digito_agencia . ' / ' .
                        $this->parametros->numerocontacorrente . '-' .  $this->parametros->digito_conta;
                        $NossoNumero = $this->titulos->seunumero;
                        $DataDoProces = (date('d/m/Y H:i:s'));
                        $DataDoDoc = ClassMaster::data_BR_H($this->titulos->created_at);
                        $NumeroDodoc = substr($this->titulos->seunumero, -10);
                        $ValorDocumento = ClassMaster::modeda_string($this->titulos->valor);
                        $carteira =   $this->parametros->carteira;
            
      
                        $Instrucoes =
                        $this->parametros->mens1 . '<br>'
                        . $this->parametros->mens2 . '<br>'
                        . $this->parametros->mens3 . '<br>'
                        .$this->parametros->info1 .' '.  $this->titulos->identificador;
                       
                   
                        $nome = $this->pessoas->nome ;
                        $CpfDoSacado =  $this->pessoas->cpf_cnpj;
                        $RuaNumeroBairro =$this->pessoas->cobranca_endereco. ' ,' . $this->pessoas->cobranca_numero . ' ' .$this->pessoas->cobranca_complemento . ' ' .
                        $this->pessoas->cobranca_bairro;
                        
                        $CidadeUf =  $this->pessoas->cobranca_cidade . '-' .$this->pessoas->cobranca_uf;
                        $CEP =  $this->pessoas->cobranca_cep;
                        
                 
                        
                           $logo_banco =   'https://'.$_SERVER['HTTP_HOST'].'/'. $this->LayoutBB->logomarca;
 $css = 'https://' . $_SERVER['HTTP_HOST'] . '/css/css_itau.css';
$html_cod = "
<!DOCTYPE HTML>
<html>

<head>
     <link rel='stylesheet' href='{$css}'>
     
     <style>
     .ambiente {
  
    color: #fff;

}
     </style>

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

                                    <li><span style='font-family:Verdana,Geneva,sans-serif'><span
                                                style='font-size:11px'> O pagamento deste
                                                boleto poder&aacute;
                                                ser pago via PIX. Utilize o QR code ao lado: </span> </span></li>
                                </ul>
                                </li>
                                </ul>
                            </td>
                            <td style='text-align:right; width:137px'><img alt='Logo PIX'
                                    src='https://apicobranca.millgest.com.br/apirestfull/public/img/pix.jpg'
                                    style='float:right; height:102px; width:200px' /></td>
                            <td style='text-align:right; width:86px'>$QrcodeNew</td>
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
            <TD colspan=6 class=BoletoLinhaDigitavel> $Linhadigitavel</TD>
        </TR>
        <TR>
            <TD colspan=10 class=BoletoTituloEsquerdo>Local de Pagamento</TD>
            <TD class=BoletoTituloDireito>Vencimento</TD>
        </TR>
        <TR>
            <TD colspan=10 class=BoletoValorEsquerdo style='text-align: left; padding-left : 0.1cm'> ATÉ O VENC.
                PREFERENCIALMENTE NO BANCO DO BRASIL
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
            <TD class=BoletoValorEsquerdo>DM</TD>
            <TD class=BoletoValorEsquerdo>N</TD>
            <TD class=BoletoValorEsquerdo>$DataDoProces</TD>
            <TD class=BoletoValorDireito>$NossoNumero</TD>
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
            <TD colspan=2 class=BoletoValorEsquerdo> $carteira </TD>
            <TD colspan=2 class=BoletoValorEsquerdo>R$</TD>
            <TD colspan=2 class=BoletoValorEsquerdo>&nbsp;</TD>
            <TD class=BoletoValorEsquerdo>&nbsp;</TD>
            <TD class=BoletoValorDireito>$ValorDocumento</TD>
        </TR>
        <TR>
            <TD colspan=10 class=BoletoTituloEsquerdo>Instruco</TD>
            <TD class=BoletoTituloDireito>(-) Desconto</TD>
        </TR>
        <TR>
            <TD colspan=10 rowspan=9 class=BoletoValorEsquerdo
                style='text-align: left; vertical-align:top; padding-left : 0.1cm'>$Instrucoes</TD>
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
            <TD rowspan=3 Class=BoletoTituloSacado>Sacado:</TD>
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
            <TD colspan=2 Class=BoletoTituloSacador>Sacador / Avalista:</TD>
            <TD colspan=9 Class=BoletoValorSacador>...</TD>
        </TR>
        <TR>
            <TD colspan=11 class=BoletoTituloDireito style='text-align: right; padding-right: 0.1cm'>Recibo do Sacado -
                Autenticação Mecânica</TD>
        </TR>
        <TR>
            <TD class=ambiente colspan=11 valign=top>$Instrucoes</TD>
        </TR>
        <tr>

            <td colspan=11 class=BoletoPontilhado>&nbsp;</td>
        </tr>
        <TR>
            <TD colspan=4 class=BoletoLogo><img src='$logo_banco' width=' 150'>
            </TD>
            <TD colspan=2 class=BoletoCodigoBanco> $resultado</TD>
            <TD colspan=6 class=BoletoLinhaDigitavel> $Linhadigitavel</TD>
        </TR>
        <TR>
            <TD colspan=10 class=BoletoTituloEsquerdo>Local de Pagamento</TD>
            <TD class=BoletoTituloDireito>Vencimento</TD>
        </TR>
        <TR>
            <TD colspan=10 class=BoletoValorEsquerdo style='text-align: left; padding-left : 0.1cm'> ATÉ O VENC.
                PREFERENCIALMENTE NO BANCO DO BRASIL
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
            <TD class=BoletoValorEsquerdo>DM</TD>
            <TD class=BoletoValorEsquerdo>N</TD>
            <TD class=BoletoValorEsquerdo>$DataDoProces</TD>
            <TD class=BoletoValorDireito>$NossoNumero</TD>
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
            <TD colspan=2 class=BoletoValorEsquerdo> $carteira </TD>
            <TD colspan=2 class=BoletoValorEsquerdo>R$</TD>
            <TD colspan=2 class=BoletoValorEsquerdo>&nbsp;</TD>
            <TD class=BoletoValorEsquerdo>&nbsp;</TD>
            <TD class=BoletoValorDireito>$ValorDocumento</TD>
        </TR>
        <TR>
            <TD colspan=10 class=BoletoTituloEsquerdo>Instruco</TD>
            <TD class=BoletoTituloDireito>(-) Desconto</TD>
        </TR>
        <TR>
            <TD colspan=10 rowspan=9 class=BoletoValorEsquerdo
                style='text-align: left; vertical-align:top; padding-left : 0.1cm'>$Instrucoes</TD>
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
            <TD rowspan=3 Class=BoletoTituloSacado>Sacado:</TD>
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
            <TD colspan=2 Class=BoletoTituloSacador>Sacador / Avalista:</TD>
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


</body>

</html>";

$mpdf = new Mpdf();
$mpdf->WriteHTML($html_cod);

 
$pastaDestino = "documentos/pdf/sicredi/boleto/";

// Verifica se a pasta de destino existe, e se não, a cria
if (!is_dir($pastaDestino)) {
    mkdir($pastaDestino, 0777, true);
}

// Gera um nome de arquivo único para o PDF
$nomeArquivo = $pastaDestino .$ObjetoImprimir->linhadigitavel. '-Boleto.pdf';

// Saída do PDF para o arquivo
$mpdf->Output($nomeArquivo, 'F');

 if($this->tipo!=1){

    $window = TWindow::create('PDF', 0.8, 0.8);
    
    $object = new TElement('iframe');
    $object->src  = $nomeArquivo ;
    $object->type  = 'application/pdf';
    $object->style = "width: 100%; height:calc(100% - 10px)";
    
    $window->add($object);
    $window->show();
//$mpdf->WriteHTML($html_cod);

 }else{
     
     return  $nomeArquivo;
     
 }
    
        
 
    }


 
}