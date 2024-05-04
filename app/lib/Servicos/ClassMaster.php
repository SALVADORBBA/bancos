<?php
class ClassMaster{

    //ClassMaster::formatDecimalToString
    public static  function cleandoc( $value){
        
        
       return $value= preg_replace('/[^a-zA-Z0-9\s]/', '', $value);

        
    }
     /**
     * Cria um UUID (Identificador Único Universal) baseado na versão 4.
     *
     * @param int $model O identificador do modelo.
     * @return string O UUID gerado.
     */
    public static function CreateUuid($model)
    {

        $data = random_bytes(16);

        // Set the version number (4) and variant bits
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant RFC4122

        // Format the UUID as a string
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return $uuid;
    }

        
    public static  function cleanPasta( $value){
        
        
$dataHora = $value;
$caractereSubstituto = '_';

// Remova espaços, dois pontos ':' e hífens '-' e substitua por um caractere específico
$dataHoraFormatada = str_replace([' ', ':', '-'], $caractereSubstituto, $dataHora);

return $dataHoraFormatada; // Resultado: "20231019235959"

    }
    
    
       public static function TrataDoc($valor)
    {
        $antes = ['.', '-', '/', '(', ')', ' '];
        $depos = ['', '', '', '', '', ''];
        return str_replace($antes, $depos, $valor);

    }

    

    

    /**
     * Limita o tamanho do texto ao valor especificado.
     *
     * @param string $texto O texto a ser limitado.
     * @param int $limite O limite máximo de caracteres.
     * @return string O texto limitado.
     */
    public static function limitarTexto($texto, $limite)
    {
        if (strlen($texto) > $limite) {
            $texto = substr($texto, 0, $limite);
        }
        return $texto;
    }   
    
    
       public static function tipodoc($tipo)
    {
        
         if (strlen($tipo) === 11) {
            return $tipo_pessoa = "PESSOA_FISICA";
        } else {
          return $tipo_pessoa = "PESSOA_JURIDICA";
        }
    
         
    } 

   /**
     * Converte uma data para o formato "d/m/Y".
     *
     * @param string $data A data a ser convertida.
     * @return string A data convertida.
     */
    public static function data_BR($data)
    {
        $dataConvertida = date("d/m/Y", strtotime($data));
        return $dataConvertida;
    }



   public static function data_BR_H($data)
    {
        $dataConvertida = date("d/m/Y H:i:s", strtotime($data));
        return $dataConvertida;
    }
public static  function calcularDataFutura($dias,$vencimento) {
    $dataAtual = $vencimento; // Data atual no formato "AAAA-MM-DD"
    $dataFutura = date('Y-m-d', strtotime("-$dias days", strtotime($dataAtual)));
    return $dataFutura;
}

  /**
     * Converte um valor numérico para uma string formatada como moeda.
     *
     * @param float $value O valor numérico.
     * @return string O valor formatado como moeda. MillFunctionsClass::modeda_string
     */
    public static function modeda_string($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
    
    
    
    
       public static function Moeda($total, $desconto) //

    {
     $total = str_replace(',', '.', str_replace('.', '', $total));
    $desconto = str_replace(',', '.', str_replace('.', '', $desconto));

    // Converter para float
    $total = floatval($total);
    $desconto = floatval($desconto);

    // Validar se o desconto é menor ou igual ao total
    if ($desconto > $total) {
        return 'Erro: O valor do desconto não pode ser maior que o valor total.';
    }

    // Se o desconto for zero ou menor, o resultado é igual ao total
    if ($desconto <= 0) {
        return $total;
    }

    // Subtrair os valores
    $resultado = $total - $desconto;

    return $resultado;
    }

    
}