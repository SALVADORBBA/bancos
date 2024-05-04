<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeGenerator          ////QrCodeGenerator::create
{
 
    public static  function create()
    {
        
        
        
             $path = 'app/bb/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
          
        }
        $fileName='00020101021226920014br';
        $qrCodeContent = '00020101021226920014br.gov.bcb.pix2570qrcodepix-h.bb.com.br/pix/v2/cobv/988b5a2a-3ebd-4ba1-8a2b-b90ad989d9a3520400005303986540535.875802BR5919PADARIA PESSOA ROSA6008BRASILIA62070503***63048E6B';
        $qrCode = new QrCode($qrCodeContent);
        $qrCode->setSize(130);
        
        $writer = new PngWriter();

        $filePath = $path . $fileName . '.png';
        $writer->write($qrCode)->saveToFile($filePath);

        return $filePath;
    }
}