<?php

 
class FormatterClass  
{
    
 
   public function __construct() {
        // Construtor vazio
    }

    public static function formatCpfCnpj($value) {
        // Remover caracteres não numéricos
        $value = preg_replace('/\D/', '', $value);
        
        // Adicionar zeros à esquerda se necessário
        if (strlen($value) == 11) { // CPF
            return str_pad($value, 11, '0', STR_PAD_LEFT);
        } elseif (strlen($value) == 14) { // CNPJ
            return str_pad($value, 14, '0', STR_PAD_LEFT);
        } else {
            // Retornar valor original se não for nem CPF nem CNPJ válido
            return $value;
        }
    }
    
    
     public static function formatDate($date) {
        return date("d/m/Y", strtotime($date));
    }
}

