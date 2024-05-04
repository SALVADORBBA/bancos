<?php

 
class ClassGenerica  
{
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
    
    public static function gerarData($dataHora, $fusoHorario) {
    // Criar um objeto DateTime com a data e hora especificadas
    $dataHoraObj = new DateTime($dataHora, new DateTimeZone($fusoHorario));
    
    // Formatar a data conforme o padrão desejado
    $dataFormatada = $dataHoraObj->format('Y-m-d\TH:i:sP');
    
    return $dataFormatada;
}



 public static function domNodeToArray($node) {
        $output = array();

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = self::domNodeToArray($child);
                    if(isset($child->tagName)) {
                        $t = $child->tagName;
                        if(!isset($output[$t])) {
                            $output[$t] = array();
                        }
                        $output[$t][] = $v;
                    }
                    elseif($v || $v === '0') {
                        $output = (string) $v;
                    }
                }
                if($node->attributes->length && !is_array($output)) {
                    $output = array('@content'=>$output);
                }
                if(is_array($output)) {
                    if($node->attributes->length) {
                        $aArray = array();
                        foreach($node->attributes as $attrName => $attrNode) {
                            $aArray[$attrName] = (string) $attrNode->value;
                        }
                        $output['@attributes'] = $aArray;
                    }
                    foreach ($output as $t => $v) {
                        if(is_array($v) && count($v)==1 && $t!='@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }

 public static function CleanString($str) {
        $replaces = array(
            'S'=>'S', 's'=>'s', 'Z'=>'Z', 'z'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
        );

        return preg_replace('/[^0-9A-Za-z;,.\- ]/', '', strtoupper(strtr(trim($str), $replaces)));
    }
    /**
     * Remove caracteres especiais de uma string.
     *
     * @param string $value A string a ser limpa.
     * @return string A string sem caracteres especiais.
     */
    public static function LimpaEspecial($value)
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $value);
    }

    public static function removerAcentosLetras($string)
    {
        $acentos = array(
            '/[áàâã]/u' => 'a',
            '/[éèê]/u' => 'e',
            '/[íì]/u' => 'i',
            '/[óòôõ]/u' => 'o',
            '/[úùû]/u' => 'u',
            '/[ç]/u' => 'c',
            '/[ÁÀÂÃ]/u' => 'A',
            '/[ÉÈÊ]/u' => 'E',
            '/[ÍÌ]/u' => 'I',
            '/[ÓÒÔÕ]/u' => 'O',
            '/[ÚÙÛ]/u' => 'U',
            '/[Ç]/u' => 'C',
        );
        return preg_replace(array_keys($acentos), array_values($acentos), $string);
    }

    /**
     * Converte uma data para o formato  de "Y-m-d" para "d.m.Y".
     *
     * @param string $data A data a ser convertida.
     * @return string A data convertida.
     */
    public static function CVDataBB($data)
    {
        $dataConvertida = date("d.m.Y", strtotime($data));
        return $dataConvertida;
    }
    /**
     * Converte uma data para o formato de  "d.m.Y" para "Y-m-d"
     *
     * @param string $data A data a ser convertida.
     * @return string A data convertida.
     */

    public static function CVDataBB_revessa($data)
    {
        $dataConvertida = date("Y-m-d", strtotime($data));
        return $dataConvertida;
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

    /**
     * Gera o número de identificação a partir do número do convênio e do número de controle.
     *
     * @param int $numeroConvenio O número do convênio.
     * @param int $numeroControle O número de controle.
     * @return string O número de identificação gerado.
     */
    public static function NumeroIdentificacao($numeroConvenio, $numeroControle)
    {
        $numeroConvenio = str_pad($numeroConvenio, 7, '0', STR_PAD_LEFT);
        $numeroControle = str_pad($numeroControle, 9, '0', STR_PAD_LEFT);
        return '000' . $numeroConvenio . $numeroControle;
    }
 

    public static function extractInvalidFields($data, $errors)
    {
        $invalidFields = [];
        foreach ($errors->keys() as $field) {
            $value = data_get($data, $field);
            $invalidFields[$field] = $value;
        }

        return $invalidFields;
    }

    public static function formatarValorItau($valor)
    {
        // Remover espaços em branco e caracteres de formatação
        $valor = preg_replace('/\s+/', '', $valor);

        // Verificar se o valor é um número válido
        if (!is_numeric($valor)) {
            return "Valor inválido!";
        }

        // Arredondar o valor para 2 casas decimais
        $valor = round($valor, 2);

        // Converter o valor para uma string com duas casas decimais
        $valorFormatado = number_format($valor, 2, '', '');

        // Verificar o comprimento do valor formatado
        if (strlen($valorFormatado) > 15) {
            return "Valor inválido!";
        }

        // Preencher com zeros à esquerda até ter 15 dígitos
        $valorFormatado = str_pad($valorFormatado, 15, "0", STR_PAD_LEFT);

        // Retornar o valor formatado
        return $valorFormatado;
    }

    public static function formatarValorPercentual($valor)
    {
        // Remove whitespaces and formatting characters
        $valor = preg_replace('/\s+/', '', $valor);

        // Check if the value is a valid number
        if (!is_numeric($valor)) {
            return "Valor inválido!";
        }

        // Multiply the value by 100 to get the desired output format
        $valor = round($valor * 100);

        // Convert the value to a string with the desired format
        $valorFormatado = str_pad($valor, 15, "0", STR_PAD_LEFT);

        // Return the formatted value
        return $valorFormatado;
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
 

    public static function calcularDigitoVerificador($primeirosDezDigitos)
    {
        // Obtém os 6 dígitos depois dos 10 primeiros (da esquerda para a direita)
        $seis_digitos_apos_dez = substr($primeirosDezDigitos, 10, 6);

        // Obtém o dígito da posição 17 (da esquerda para a direita)
        $digito_posicao_17 = $primeirosDezDigitos[16];

        // Formatação final
        $numero_formatado = $seis_digitos_apos_dez . '-' . $digito_posicao_17;
        return $numero_formatado; // Saída: 000043-8

    }

    public static function calcularDigitosVerificadoresBanrisul($numero)
    {
        // Verifica se o número possui 8 dígitos
        if (strlen($numero) !== 8) {
            throw new InvalidArgumentException('O número do Banrisul deve conter exatamente 8 dígitos.');
        }

        // Cálculo do primeiro dígito verificador (Módulo 10)
        $pesosModulo10 = array(1, 2, 1, 2, 1, 2, 1, 2);
        $somaModulo10 = 0;

        for ($i = 7; $i >= 0; $i--) {
            $produto = intval($numero[$i]) * $pesosModulo10[$i];
            $somaModulo10 += ($produto > 9) ? $produto - 9 : $produto;
        }

        $restoModulo10 = $somaModulo10 % 10;
        $primeiroDigitoVerificador = (10 - $restoModulo10) % 10;

        // Adiciona o primeiro dígito verificador ao número original
        $numero .= $primeiroDigitoVerificador;

        // Cálculo do segundo dígito verificador (Módulo 11)
        $pesosModulo11 = array(2, 3, 4, 5, 6, 7, 8, 9, 2);
        $somaModulo11 = 0;

        for ($i = 8; $i >= 0; $i--) {
            $somaModulo11 += intval($numero[$i]) * $pesosModulo11[$i];
        }

        $restoModulo11 = $somaModulo11 % 11;
        $segundoDigitoVerificador = (11 - $restoModulo11) % 10;

        // Retorna o número completo com os dígitos verificadores calculados
        return $numero . $segundoDigitoVerificador;
    }

    public static function formatDecimalToString($number) //

    {
        $maxLength = 16;
        $pattern = '/^-?\d{1,13}\.\d{2}$/';

        // Converte o número para uma string formatada
        $formattedNumber = number_format((float) $number, 2, '.', '');

        // Verifica se a string formatada está de acordo com o padrão
        if (preg_match($pattern, $formattedNumber)) {
            // Verifica o comprimento da string e ajusta, se necessário
            if (strlen($formattedNumber) <= $maxLength) {
                return $formattedNumber;
            } else {
                // Se o comprimento exceder maxLength, retorna uma string vazia ou uma mensagem de erro, como preferir
                return '';
            }
        } else {
            // Se o número não corresponder ao padrão, retorna uma string vazia ou uma mensagem de erro, como preferir
            return '';
        }
    }



    public static function GetRQCODEITAU($base64_string)
    {


        // Decodificar a string Base64 para dados binários
        $image_data = base64_decode($base64_string);

        // Caminho onde você deseja salvar a imagem decodificada
        $image_path = 'qr/qr.png';
        $pasta = 'qr';
        if (is_dir($pasta)) {
        } else {
            mkdir($pasta, 0777, true);
        }


        // Salvar os dados binários da imagem em um arquivo
        file_put_contents($image_path, $image_data);

        // Carregar a imagem original usando GD
        $original_image = imagecreatefrompng($image_path);

        // Obter as dimensões originais da imagem
        $original_width = imagesx($original_image);
        $original_height = imagesy($original_image);

        // Calcular o tamanho do corte (10% das bordas)
        $crop_percentage = 0.10;
        $crop_x = intval($original_width * $crop_percentage);
        $crop_y = intval($original_height * $crop_percentage);
        $crop_width = $original_width - 2 * $crop_x;
        $crop_height = $original_height - 2 * $crop_y;

        // Criar uma nova imagem cortada
        $cropped_image = imagecrop($original_image, ['x' => $crop_x, 'y' => $crop_y, 'width' => $crop_width, 'height' => $crop_height]);

        // Caminho onde você deseja salvar a imagem cortada
        $cropped_image_path = 'qr/imagem_cortada.png';

        // Salvar a imagem cortada em um arquivo
        imagepng($cropped_image, $cropped_image_path);

        // Liberar a memória alocada para as imagens
        imagedestroy($original_image);
        imagedestroy($cropped_image);

        // Exibir a imagem cortada

        return  $cropped_image_path;
    }


    public static function pfxToBase64($pfxFilePath)
    {

        // Carrega o conteúdo do arquivo .pfx
        $pfxData = file_get_contents($pfxFilePath);

        // Converte o arquivo .pfx para base64
        $base64Data = base64_encode($pfxData);


        return  $base64Data;
    }
    
    
public static function validarString($string) {
    // Remover acentos da string
   $stringSemAcento = mb_convert_encoding($string, 'ASCII', 'UTF-8');

    // Remover caracteres não permitidos
    $stringTratada = preg_replace('/[^A-Za-z0-9\!#$%\'()*+,-.\/:;=?@[\]^_`{|}~ ]/', '', $stringSemAcento);

    // Retornar a string tratada
    return $stringTratada;
}
 

 
 
     public static function downloadArquivoRemoto($url, $caminhoDestino) {
    // Inicializa o curl
    $ch = curl_init();
    
    // Define a URL
    curl_setopt($ch, CURLOPT_URL, $url);
    
    // Define para seguir os redirecionamentos
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // Define para retornar o conteúdo como uma string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Faz a requisição
    $conteudoArquivo = curl_exec($ch);
    
    // Verifica se houve algum erro
    if (curl_errno($ch)) {
        echo 'Erro ao baixar o arquivo: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }
    
    // Salva o conteúdo do arquivo localmente
    $resultado = file_put_contents($caminhoDestino, $conteudoArquivo);
return  $conteudoArquivo;
    // Verifica se o arquivo foi salvo com sucesso
    // if ($resultado !== false) {
    //     // Se o arquivo foi salvo com sucesso
    //     echo "Arquivo baixado e salvo em: $caminhoDestino";
    //     curl_close($ch);
    //     return true;
    // } else {
    //     // Se ocorreu um erro ao salvar o arquivo
    //     echo "Erro ao salvar o arquivo.";
    //     curl_close($ch);
    //     return false;
    // }
    }


 

 

}
