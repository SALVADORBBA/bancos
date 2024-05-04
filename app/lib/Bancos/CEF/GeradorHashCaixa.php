<?php

class GeradorHashCaixa
{
    private $codigoBeneficiario;
    private $nossoNumero;
    private $dataVencimento;
    private $valor;
    private $cnpj;

    public function __construct($codigoBeneficiario, $nossoNumero, $dataVencimento, $valor, $cnpj)
    {
        $this->codigoBeneficiario = $codigoBeneficiario;
        $this->nossoNumero = $nossoNumero;
        $this->dataVencimento = $dataVencimento;
        $this->valor = $valor;
        $this->cnpj = $cnpj;
    }

    public function GetHash()
    {
        try {
            $numeroParaHash = preg_replace('/[^A-Za-z0-9]/', '',
                str_pad($this->codigoBeneficiario, 7, '0', STR_PAD_LEFT) .
                $this->nossoNumero
            );

            if ($this->dataVencimento == 0) {
                $numeroParaHash .= str_pad("", 8, '0', STR_PAD_LEFT);
            } else {
                $numeroParaHash .= strftime('%d%m%Y', strtotime($this->dataVencimento));
            }

            $valorFormatado = number_format($this->valor, 2, '.', '');
            $valorReplace = str_replace('.', '', $valorFormatado);
            $numeroParaHash .= str_pad($valorReplace, 15, '0', STR_PAD_LEFT);
            $numeroParaHash .= str_pad($this->cnpj, 14, '0', STR_PAD_LEFT);

            return base64_encode(hash('sha256', $numeroParaHash, true));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    
}


