 
<?php

class CalculosTaxasBanrisul
{
public static function adicionarModificador($valor_total, $modificador) {
    if ($modificador['tipo'] === 'juros') {
        // Convertendo o valor do juros para porcentagem
        $valor_juros = $valor_total * ((float)$modificador['valor'] / 100);
        $valor_total += $valor_juros;
    } elseif ($modificador['tipo'] === 'desconto') {
        // Calculando o desconto como uma porcentagem do valor total
        $desconto = $valor_total * ((float)$modificador['valor'] / 100);
        $valor_total -= $desconto;
    } else {
        // Adicione aqui outras condições conforme necessário
    }

    // Formatar o valor total com duas casas decimais
    $valor_total_formatado = number_format($valor_total, 2, '.', '');

    return $valor_total_formatado;
}


    public static function addday($data, $dias) {
        // Cria um objeto DateTime com a data fornecida
        $dataObj = new DateTime($data);
        
        // Adiciona o número de dias especificado
        $dataObj->modify('+' . $dias . ' days');
        
        // Retorna a nova data como uma string no formato desejado
        return $dataObj->format('Y-m-d');
    }
    
     public static function SUBday($data, $dias) {
        // Cria um objeto DateTime com a data fornecida
        $dataObj = new DateTime($data);
        
        // Adiciona o número de dias especificado
        $dataObj->modify('-' . $dias . ' days');
        
        // Retorna a nova data como uma string no formato desejado
        return $dataObj->format('Y-m-d');
    }
    
    
    
    public static function validar_padrao($valor) {
    // Padrão regex para validar o formato
    $padrao = '/^-?\d{1,4}\.\d{1}$/';
    
    // Verifica se o valor corresponde ao padrão
    if (preg_match($padrao, $valor)) {
        return true;
    } else {
        return false;
    }
}


 
    public static function DigitosVerificadores($nossoNumero) {
        // Calcular primeiro dígito verificador (módulo 10)
        $pesos_mod10 = array(2, 1, 2, 1, 2, 1, 2, 1);
        $soma_mod10 = 0;

        for ($i = strlen($nossoNumero) - 1; $i >= 0; $i--) {
            $digito = intval($nossoNumero[$i]);
            $soma_mod10 += ($digito * $pesos_mod10[$i % 8]) - ($digito > 4 ? 9 : 0);
        }

        $resto_mod10 = $soma_mod10 % 10;
        $primeiroDV = ($resto_mod10 == 0) ? 0 : 10 - $resto_mod10;

        // Adicionar primeiro dígito verificador ao nosso número
        $nossoNumeroComDV = $nossoNumero . $primeiroDV;

        // Calcular segundo dígito verificador (módulo 11)
        $pesos_mod11 = array(2, 3, 4, 5, 6, 7, 8, 9, 2);
        $soma_mod11 = 0;

        for ($i = strlen($nossoNumeroComDV) - 1; $i >= 0; $i--) {
            $digito = intval($nossoNumeroComDV[$i]);
            $soma_mod11 += $digito * $pesos_mod11[$i % 9];
        }

        $resto_mod11 = $soma_mod11 % 11;
        $segundoDV = ($resto_mod11 < 2) ? $resto_mod11 : 11 - $resto_mod11;

        // Retornar o número de controle com dígitos verificadores
        return substr($nossoNumeroComDV, 0, -1) . '.' . $segundoDV;
    }
}

 

// Exemplo de uso
 
 

 