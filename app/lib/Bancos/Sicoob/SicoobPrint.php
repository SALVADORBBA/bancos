<?php


class SicoobPrint
{
    private $key;
    private $parametros;
    private $titulos;
   private $tipo;
    public function __construct($key,$tipo)
    {
        $this->key = $key;
              $this->tipo= $tipo;
        $this->titulos = CobrancaTitulo::find($this->key);
        $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
    }

    public function GetPDF()
    {
        try {
            $pdf_data = base64_decode($this->titulos->pdfboletobase64);

            $path = 'boletos/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $nome = $this->titulos->id . '_boleto.pdf'; // Alterei o nome do arquivo para evitar problemas
            $arquivo = $path . $nome;

            file_put_contents($arquivo, $pdf_data);

     if( $this->tipo<>1){
            
    $window = TWindow::create('PDF', 0.8, 0.8);
    
    $object = new TElement('iframe');
    $object->src  = $arquivo;
    $object->type  = 'application/pdf';
    $object->style = "width: 100%; height:calc(100% - 10px)";
        
        $window->add($object);
        $window->show();
        }else{
        
        return  $arquivo;
        
        }
            
        } catch (Exception $e) {
            // Trate a exceção conforme necessário
            return null;
        }
    }
}

   
        
        