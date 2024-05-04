<?php

/**
 * 
 * 
 * 
 * 
 */
class ClassDireciona
{
    
    /**
     * 
     */
    public static function run($var)
    {
    
    
              $StdClass= new stdClass();
            $StdClass->id=18;
            $StdClass->beneficiario_id=12;
    
         return json_encode( array('status' => 'success', 'data' => $StdClass));
 
    
    }
}