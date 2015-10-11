<?php namespace Cube;

use Cube\Validator;

class Cube{
    
    public static function testing($command){
        return "Cube Summation - Comando recibido: $command";
    }
    
    public static function executeCommand($command){
        
        $result = '';
        
        try{
            $val = new Validator();
            $result = $val->scanCommand($command);
            
            if($result === TRUE)
                $result = 'Comando válido.';
            
        }catch(Exception $e ){
            return $e->getMessage();
        }
        
        return $result;
    }
        
}

?>