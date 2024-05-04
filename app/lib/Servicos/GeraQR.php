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
 

 
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Picqer\Barcode\BarcodeGeneratorPNG;
class GeraQR
{
    private $key;
 

    /**  TTransaction::open(self::$database);;
    /**
     * Construtor da classe BancoBrasilPrint.
        *bacon/bacon-qr-code:^2.0
        *endroid/qr-code:5.0
        *mpdf/mpdf:8.2
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key)
    {
        $this->key = $key;
  
    }

    public  function run()
    {
       
 
 

                        
                                  #####################qrcode######################### 
                       
                        $path = 'app/qr/';
                        if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                        
                        }
                        $fileName=$this->titulos->linhadigitavel;
                        $qrCodeContent = $this->titulos->emv;
                        $qrCode = new QrCode($this->key);
                        $qrCode->setSize(200);
                        
                        $writer = new PngWriter();
                        
                        $filePath = $path . $fileName . '.png';
                        $writer->write($qrCode)->saveToFile($filePath);
                        $QrcodeNew= '<img src="' . $filePath . '" alt="QR Code">';
                        
                  echo  $QrcodeNew;
 
    }


 
}


 
// $create= new GeraQR('dados do qr');

// $retorno= $create->run();