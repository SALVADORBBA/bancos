<?php

class ServerGenerico
{
    
  
  
    public static function dodos($dados)
    {
        // Código gerado pelo snippet: "Conexão com banco de dados"
        TTransaction::open('conecatarbanco');
 
    $registro = new CobrancaTitulo($dados['id']);
        

        TTransaction::close();
        // -----
 
     
    }
}
