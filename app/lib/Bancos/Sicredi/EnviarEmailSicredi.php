<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;



class EnviarEmailSicredi
{
                                ///EnviaEmiaSicredi::sendEmail();
  
      
    private $key;
    private $parametros;
    private $titulos;
     private $cliente;
    /**  TTransaction::open(self::$database);;
    /**
     * Construtor da classe SicrediBoletoCreate.
     *
     * @param string $key - A chave para buscar os parâmetros no banco de dados.
     */
    public function __construct($key)
    {
        $this->key = $key;
        
        $this->titulos = CobrancaTitulo::find($this->key);
        $this->parametros = ParametrosBancos::find($this->titulos->parametros_bancos_id);
        
          $this->cliente= Cliente::find( $this->titulos->cliente_id );

        
        
        // Feche a transação (a conexão será fechada automaticamente)
    }

    public  function sendEmail()
    {
        try {

     if(isset($this->cliente->email)){
            $getToken = new GetTokenSicredi($this->titulos->parametros_bancos_id);
            $TokenSicredi = $getToken->create();
  

            // Configurar a URL da requisição para obter o arquivo PDF
            $pdfUrl =  $this->parametros->url2.'/pdf?linhaDigitavel=' . $this->titulos->linhadigitavel;

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
            $pastaDestino = "app/tmp/pdf/sicredi/boleto/{$parametros_bancos_id}/{$beneficiario_id}/";
         
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0777, true);
            }

            // Gerar um nome de arquivo único para o PDF
            $nomeArquivo = $pastaDestino . $this->titulos->linhadigitavel. '.pdf';
            file_put_contents($nomeArquivo, $pdfContent);

 
           //////////////////montar arquivo///////////////////
           
           
           
            $mail = new PHPMailer();

            // Configurações de envio
            $mail->isSMTP();
            $mail->Host = 'mail.developerapi.com.br';
            $mail->SMTPAuth = true;
            $mail->Username = 'enviofiscal@developerapi.com.br';
            $mail->Password = 'Ayl{jjDg+gEb';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            // Remetente
            $mail->setFrom( $mail->Username, 'teste nome');
            $mail->addReplyTo( $mail->Username, 'teste nome2');

           
               $html='Laravel has wonderful, thorough documentation covering every aspect of the framework.
               Whether you are new to the framework or have previous experience with Laravel, we recommend
               reading all of the documentation from beginning to end.';
           
           
                       // Endereços de e-mail dos destinatários

            $emailAddresses =  $this->cliente->email;

            // Divida a string em um array usando o ponto e vírgula como delimitador
            $addresses = explode(';', $emailAddresses);

            // Percorra o array e adicione cada endereço ao objeto $mail
            foreach ($addresses as $address) {
                $mail->addAddress($address);
            }

            // Assunto e corpo do e-mail
            $mail->isHTML(true);
            $mail->Subject = "Boleto # ".$this->key;
            $mail->Body = $html;
 
            $mail->addAttachment($nomeArquivo);
          
            // Enviar o e-mail
            $mail->send();

    // Código gerado pelo snippet: "Exibir mensagem"
        new TMessage('info', "E-mail enviado para ". $this->cliente->email);
   

           }else{
    
          new TMessage('info', "Cliente sem email");
     

}

        } catch (Exception $e) {
            // Lidar com erros e retornar uma resposta de erro apropriada
            return   $e->getMessage();
        }
    }
    
}
 