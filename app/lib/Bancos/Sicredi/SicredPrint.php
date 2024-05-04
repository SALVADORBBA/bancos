<?php

/**
 * Classe SicrediBoletoCreate  boleto sicredi.
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056
 * Construtor da classe SicrediBoletoCreate.
        *bacon/bacon-qr-code:^2.0
        *endroid/qr-code:5.0
        *mpdf/mpdf:8.2
 * @param string $key - A chave para buscar os parâmetros no banco de dados. SicredPrint GetPDF
 */
class SicredPrint
{
    private $key;
    private $parametros;
    private $titulos;
   private $tipo;
    /**  TTransaction::open(self::$database);;
    /**
     * Construtor da classe SicrediBoletoCreate.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key,$tipo)
    {
        $this->key = $key;
          $this->tipo = $tipo;
    }

    public  function GetPDF()
    {
        try {

            try {
           
               $this->titulos = CobrancaTitulo::find($this->key);
                $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
               // Feche a transação (a conexão será fechada automaticamente)
            } catch (Exception $e) {

                TTransaction::rollback(); // Em caso de erro, faça rollback da transação
            }


            // Verificar se os parâmetros foram encontrados
            if (!$this->parametros) {
                return response()->json(['message' => 'Parâmetros do banco não encontrados'], 404);
            }

            $getToken = new GetTokenSicredi($this->titulos->parametros_bancos_id);
            $TokenSicredi = $getToken->create();


            // Configurar a URL da requisição para obter o arquivo PDF
            $pdfUrl = 'https://api-parceiro.sicredi.com.br/sb/cobranca/boleto/v1/boletos/pdf?linhaDigitavel=' . $this->titulos->linhadigitavel;

            // Iniciar uma sessão cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $pdfUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'x-api-key: ' . $this->parametros->client_id,
                    'Authorization: Bearer ' . $TokenSicredi,
                ),
            ));

            // Executar a requisição cURL
            $pdfContent = curl_exec($curl);

            // Verificar se a requisição foi bem-sucedida
            if ($pdfContent === false) {
                throw new Exception('Falha ao obter o PDF do Sicredi: ' . curl_error($curl));
            }

            // Fechar a sessão cURL
            curl_close($curl);

            $system_unit_id =1;
            $parametros_bancos_id = $this->parametros->id;
            $beneficiario_id = $this->parametros->beneficiario_id;

            // Configurar a pasta de destino para salvar o PDF
            $pastaDestino = "documentos/pdf/sicredi/boleto/{$parametros_bancos_id}/{$beneficiario_id}/";
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0777, true);
            }

            // Gerar um nome de arquivo único para o PDF
            $nomeArquivo = $pastaDestino . $this->titulos->linhadigitavel. '.pdf';
            file_put_contents($nomeArquivo, $pdfContent);

 
           if(  $this->tipo<>1){
            
    $window = TWindow::create('PDF', 0.8, 0.8);
    
    $object = new TElement('iframe');
    $object->src  = $nomeArquivo;
    $object->type  = 'application/pdf';
    $object->style = "width: 100%; height:calc(100% - 10px)";
    
    $window->add($object);
    $window->show();
}else{
    
  return $nomeArquivo;
    
    
}
        } catch (Exception $e) {
            // Lidar com erros e retornar uma resposta de erro apropriada
            return   $e->getMessage();
        }
    }

 public  function Getfile()
    {
        try {

            try {
               
             $this->titulos = CobrancaTitulo::find($this->key);
                $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
              // Feche a transação (a conexão será fechada automaticamente)
            } catch (Exception $e) {

                TTransaction::rollback(); // Em caso de erro, faça rollback da transação
            }


            // Verificar se os parâmetros foram encontrados
            if (!$this->parametros) {
                return response()->json(['message' => 'Parâmetros do banco não encontrados'], 404);
            }

            $getToken = new GetTokenSicredi($this->titulos->parametros_bancos_id);
            $TokenSicredi = $getToken->create();


            // Configurar a URL da requisição para obter o arquivo PDF
            $pdfUrl = 'https://api-parceiro.sicredi.com.br/sb/cobranca/boleto/v1/boletos/pdf?linhaDigitavel=' . $this->titulos->linhadigitavel;

            // Iniciar uma sessão cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $pdfUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'x-api-key: ' . $this->parametros->client_id,
                    'Authorization: Bearer ' . $TokenSicredi,
                ),
            ));

            // Executar a requisição cURL
            $pdfContent = curl_exec($curl);

            // Verificar se a requisição foi bem-sucedida
            if ($pdfContent === false) {
                throw new Exception('Falha ao obter o PDF do Sicredi: ' . curl_error($curl));
            }

            // Fechar a sessão cURL
            curl_close($curl);

            $system_unit_id =1;
            $parametros_bancos_id = $this->parametros->id;
            $beneficiario_id = $this->parametros->beneficiario_id;

            // Configurar a pasta de destino para salvar o PDF
            $pastaDestino = "documentos/pdf/sicredi/boleto/{$parametros_bancos_id}/{$beneficiario_id}/";
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0777, true);
            }
            // Gerar um nome de arquivo único para o PDF
            $nomeArquivo = $pastaDestino . $this->titulos->linhadigitavel. '.pdf';
            file_put_contents($nomeArquivo, $pdfContent);
            return $nomeArquivo;
                    } catch (Exception $e) {
            // Lidar com erros e retornar uma resposta de erro apropriada
            return   $e->getMessage();
        }
    }


    public  function GetPDFSegundaVia()
    {


        try {
 
            $cobrabnca= CobrancaTitulo::find($this->key);
               


            $window = TWindow::create('Boleto Banco do Sicredi - v2', 0.8, 0.8);

            $object = new TElement('iframe');
            $object->src  =  $cobrabnca->caminho_boleto;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";

            $window->add($object);
            $window->show();
        } catch (Exception $e) {

            TTransaction::rollback(); // Em caso de erro, faça rollback da transação
        }
    }
}
