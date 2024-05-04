<?php

//   * Autor: Rubens dos Santos
//      * Email: salvadorbba@gmail.com
//      * Celular: (12) 99675-8056

class WebserviceCaixa
{
    private $codigoBeneficiario;
    private $nossoNumero;
    private $dataVencimento;
    private $cnpj;
    private $valor;

    public function __construct()
    {
        $this->codigoBeneficiario = 999999;
        $this->nossoNumero = 0;
        $this->dataVencimento = '2024-05-05';
        $this->cnpj = '00360305000104';
        $this->valor = 100.00;
    }

    public function incluirBoleto()
    {
        $autenticacao = $this->generateAutenticacao();

        $xml = new DOMDocument('3.0', 'iso-8859-1');
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;

        // SOAP Envelope
        $envelope = $xml->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soapenv:Envelope');
        $envelope->setAttribute('xmlns:ext', 'http://caixa.gov.br/sibar/manutencao_cobranca_bancaria/boleto/externo');
        $envelope->setAttribute('xmlns:sib', 'http://caixa.gov.br/sibar');
        $xml->appendChild($envelope);

        // SOAP Header
        $header = $xml->createElement('soapenv:Header');
        $envelope->appendChild($header);

        // SOAP Body
        $body = $xml->createElement('soapenv:Body');
        $envelope->appendChild($body);

        // Your existing code for generating XML content
        $root = $xml->createElement('manutencaocobrancabancaria:SERVICO_ENTRADA');
        $body->appendChild($root);

        $headerElement = $xml->createElement('sibar_base:HEADER');
        $root->appendChild($headerElement);

        $this->appendArrayToXml($xml, $headerElement, [
            'VERSAO' => '3.2',
            'AUTENTICACAO' => 'FTGcCGGC/5mljUAvhPDOv3OaGbN1OE822PJtv6nr1yI=',
            'USUARIO_SERVICO' => 'SGCBS02P',
            'OPERACAO' => 'INCLUI_BOLETO',
            'SISTEMA_ORIGEM' => 'SIGCB',
            'UNIDADE' => '1679', // Substitua pela unidade real
            'DATA_HORA' => date('YmdHis'),
        ]);

        // Continue with the rest of your XML structure
        $dados = $xml->createElement('DADOS');
        $root->appendChild($dados);

        $incluirBoleto = $xml->createElement('INCLUI_BOLETO');
        $dados->appendChild($incluirBoleto);

        $this->appendArrayToXml($xml, $incluirBoleto, [
            'CODIGO_BENEFICIARIO' => 999999,
            'TITULO' => [
                'NOSSO_NUMERO' => 0,
                'NUMERO_DOCUMENTO' => 'TESTE001',
                'DATA_VENCIMENTO' => '2024-05-05',
                'VALOR' => $this->valor,
                'TIPO_ESPECIE' => 99,
                'FLAG_ACEITE' => 'S',
                'DATA_EMISSAO' => date('Y-m-d'),
               
                'CODIGO_MOEDA' => 9,
                'PAGADOR' => [
                    'CPF' => '00000000191',
                    'NOME' => 'TESTE PAGADOR 001',
                    'ENDERECO' => [
                        'LOGRADOURO' => 'SAUS QUADRA 03',
                        'BAIRRO' => 'BRASILIA',
                        'CIDADE' => 'BRASILIA',
                        'UF' => 'DF',
                        'CEP' => '70070030',
                    ],
                ],
            ],
        ]);

        $xml_string = $xml->saveXML();
    // Format the XML string with indentation
                        // $dom = new DOMDocument('1.0');
                        // $dom->preserveWhiteSpace = false;
                        // $dom->formatOutput = true;
                        // $dom->loadXML( $xml->saveXML());
                    
                        // Display the formatted XML content
                   
        $client = new SoapClient('https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo', array('trace' => 1, 'connection_timeout' => 300));

        try {
            $response = $client->__soapCall('INCLUI_BOLETO', ['XML' => $xml_string]);
            // Process the response as needed
        } catch (SoapFault $fault) {
            // Handle SOAP errors
            echo "Error: " . $fault->faultstring;
        }
    
        
      return $response;
    }

    private function appendArrayToXml($xml, $parent, $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $xml->createElement($key);
                $parent->appendChild($child);
                $this->appendArrayToXml($xml, $child, $value);
            } else {
                $child = $xml->createElement($key, $value);
                $parent->appendChild($child);
            }
        }
    }

    private function generateAutenticacao()
    {
        $raw = preg_replace('/[^A-Za-z0-9]/', '', '0' . $this->codigoBeneficiario . $this->nossoNumero . strftime('%d%m%Y', strtotime($this->dataVencimento)) . sprintf('%015d', preg_replace('/[^0-9]/', '', $this->valor)) . sprintf('%014d', $this->cnpj));
        return base64_encode(hash('sha256', $raw, true));
    }
}

 
