<?php

/**
 * 
 *
 * Autor: Rubens dos Santos
 * Email: salvadorbba@gmail.com
 * Celular: (12) 99675-8056            consultarCEP::GetCep();
 */

//consultarCEP::CEP()
class consultarCEP
{
    public static function CEP($cep)
    {
        
           $cep= ClassMaster::TrataDoc($cep);
        $url = "https://cep.awesomeapi.com.br/json/{$cep}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resultado = curl_exec($ch);
        curl_close($ch);

        if (!$resultado) {
            return false;
        }

        $dados = json_decode($resultado);

        if (isset($dados->error) && $dados->error) {
            return false;
        }

        return $dados;
    }
}
