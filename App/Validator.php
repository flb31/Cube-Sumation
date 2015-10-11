<?php namespace Cube;

use Exception;

class Validator{
    
    const COMMAND_UPDATE = 'UPDATE';
    const TOTAL_NUM_UPDATE = 4;
    
    const COMMAND_QUERY = 'QUERY';
    const TOTAL_NUM_QUERY = 6;
    
    
    
    public function scanCommand($command){
        
        try{
            if ( preg_match ( $this->getPattern($command) , $command) )
                return TRUE;
            else{
                $comando_query = self::COMMAND_QUERY . ' x1 y1 z1 x2 y2 z2';
                $comando_update = self::COMMAND_UPDATE . ' x y z W';
                throw new Exception("Comando debe ser formato `$comando_query` O `$comando_update`");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    protected function getPattern($command){
        
        
        if(strpos($command, self::COMMAND_QUERY ) !== FALSE ){
            $type = self::COMMAND_QUERY;
            $num = self::TOTAL_NUM_QUERY;
        }else if(stripos($command, self::COMMAND_UPDATE ) !== FALSE){
            $type = self::COMMAND_UPDATE;
            $num = self::TOTAL_NUM_UPDATE;
        }else{
            throw new Exception('Usar sentencia: ' . self::COMMAND_UPDATE . " o " . self::COMMAND_QUERY);
        }
        
        return "/^\s*".$type."(\s+\d{1,3}\s*){".$num."}$/i";
            
    }
    
}

?>