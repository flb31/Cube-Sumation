<?php namespace Cube;

use Exception;

class Validator{
    
    
    const COMAND_TYPE_T  = 'T';  // T => Total test cases.
    const COMAND_TYPE_NM = 'NM'; // N M => size cube and total operations
    const COMAND_TYPE_QU = 'QU'; // QUERY or UPDATE operation
    
    const COMMAND_UPDATE = 'UPDATE';
    const COMMAND_QUERY  = 'QUERY';
    const TOTAL_NUM_UPDATE = 4;
    const TOTAL_NUM_QUERY  = 6;
    
    public function scanCommand($command, $type_command){
        
        try{
            
            if( is_null($command) || strlen($command) == 0 ) throw new Exception('');
            
            if ( preg_match ( $this->getPattern($type_command, $command) , $command) )
                return TRUE;
            else{
                throw new Exception( 
                        $this->getMessageExceptionScan ($type_command)
                );
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    protected function getMessageExceptionScan($type_command){
        
        $main_message = 'Comando no válido debe ser de la forma:';
        
        $comando_query  = self::COMMAND_QUERY . ' x1 y1 z1 x2 y2 z2';
        $comando_update = self::COMMAND_UPDATE . ' x y z W';
        $message_qu = "$main_message `$comando_query` O `$comando_update`.";
            
        $message_t = "$main_message Numero de tests `T`.";
        $message_nm = "$main_message Dimesión del cubo (N) y total de operaciones (M) => `N M`";
        
        $arr_msg = array (
                        self::COMAND_TYPE_T => $message_t,
                        self::COMAND_TYPE_NM => $message_nm,
                        self::COMAND_TYPE_QU => $message_qu
                    );
        
        return $arr_msg[$type_command];
    }
    
    protected function getPattern($type_command, $command){
        
        $pattern = '';
        
        switch($type_command){
                
            case self::COMAND_TYPE_T:
                $pattern = "/^\s*\d{1,3}\s*$/";
                break;
                
            case self::COMAND_TYPE_NM:
                $pattern = "/^(\s*\d{1,3}\s*){2}$/";
                break;
                
            case self::COMAND_TYPE_QU:
                $type = '';
                $num = '';
                if(stripos($command, self::COMMAND_QUERY ) !== FALSE ){
                    $type = self::COMMAND_QUERY;
                    $num  = self::TOTAL_NUM_QUERY;
                }else if(stripos($command, self::COMMAND_UPDATE ) !== FALSE){
                    $type = self::COMMAND_UPDATE;
                    $num  = self::TOTAL_NUM_UPDATE;    
                }
                $pattern = "/^\s*" . $type . "(\s+\d{1,3}){" . $num . "}\s*$/i";
                
                break;
                
            default:
                throw new Exception('Error de configuración: `' 
                                    . $type_command . '` No es un comando válido. Usar tipo `'
                                    . self::COMAND_TYPE_T  . '`, `'
                                    . self::COMAND_TYPE_NM . '`, `'
                                    . self::COMAND_TYPE_QU
                                   );
                break;
        }
        return $pattern;
            
    }
    
}

?>