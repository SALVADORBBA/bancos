<?php

class BuscarBoleto
{
    public function __construct($param)
    {
        
    }
    
    public static function create($param)
    {
        
        
        
 
                TTransaction::open('conecatarbanco');
            $objeto = CobrancaTitulo::where('id', '!=',180)->first();
        return  $dados;
        
            TTransaction::close();
   
    }
}
