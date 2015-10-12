<?php namespace Cube;

use Exception;

class Cube{
    
    public static function testing($command){
        return "Cube Summation - Comando recibido: $command";
    }
    
    public function executeCommand($command){
        
        $result = '';
        $sequence = 'QU'; //T NM
        $n = 10; //Valor de la secuencia
        
        try{
            $val = new Validator();
            $result = $val->scanCommand($command, $sequence);
            
            if($result === TRUE)    
                $result = $this->verifyRules($sequence, $command);
            
            if($result === TRUE)
                $result = 'Comando aceptado para ejecutar en el cubo.';
            
        }catch(Exception $e ){
            return $e->getMessage();
        }
        
        return $result;
    }
    
    private function verifyRules($sequence, $command){
        
        $ext = new Extractor();
        $values = $ext->extractValues($command);
        
        //Order $values
        //T = [0]
        //N M  = [0] [1]
        //x y z w  = [0] [1] [2] [3]
        //x1 y1 z1 x2 y2 z2  = [0] [1] [2] [3] [4] [5]
        
        $n = 10;
        
        try{
            $policy = new Policy();
            switch($sequence){
                case Config::SEQUENCE_T:
                    $policy->verifyTestCase( $values[0] );
                    break;

                case Config::SEQUENCE_NM:
                    $policy->verifyDimension( $values[0] );
                    $policy->verifyOperationsNumber( $values[1] );
                    break;

                case Config::SEQUENCE_QU:
                    if(stripos($command, Config::COMMAND_QUERY ) !== FALSE ){
                        $policy->verifyPosition($n, $values[0], $values[1], $values[2]);
                        $policy->verifyPosition($n, $values[3], $values[4], $values[5]);
                    }else if(stripos($command, Config::COMMAND_UPDATE ) !== FALSE){
                        $policy->verifyPosition($n, $values[0], $values[1], $values[2]);
                        $policy->verifyCellValue($values[3], $values[0], $values[1], $values[2]);
                    }
                    break;
            }
        
        }catch(Exception $e ){
            return $e->getMessage();
        }
        
        return TRUE;    
    }
        
}

?>