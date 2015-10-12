<?php namespace Cube;

use Exception;

class Validator{
    
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
        
        $comando_query  = Config::COMMAND_QUERY . ' x1 y1 z1 x2 y2 z2';
        $comando_update = Config::COMMAND_UPDATE . ' x y z W';
        $message_qu = "$main_message `$comando_query` O `$comando_update`.";
            
        $message_t = "$main_message Numero de tests `T`.";
        $message_nm = "$main_message Dimesión del cubo (N) y total de operaciones (M) => `N M`";
        
        $arr_msg = array (
                        Config::COMAND_TYPE_T => $message_t,
                        Config::COMAND_TYPE_NM => $message_nm,
                        Config::COMAND_TYPE_QU => $message_qu
                    );
        
        return $arr_msg[$type_command];
    }
    
    protected function getPattern($type_command, $command){
        
        $pattern = '';
        
        switch($type_command){
                
            case Config::COMAND_TYPE_T:
                $pattern = "/^\s*\d+\s*$/";
                break;
                 
            case Config::COMAND_TYPE_NM:
                $pattern = "/^\s*\d+\s+\d+\s*$/";
                break;
                
            case Config::COMAND_TYPE_QU:
                $type = '';
                $num = '';
                if(stripos($command, Config::COMMAND_QUERY ) !== FALSE ){
                    $type = Config::COMMAND_QUERY;
                    $num  = Config::TOTAL_NUM_QUERY;
                }else if(stripos($command, Config::COMMAND_UPDATE ) !== FALSE){
                    $type = Config::COMMAND_UPDATE;
                    $num  = Config::TOTAL_NUM_UPDATE;    
                }
                $pattern = "/^\s*" . $type . "(\s+\d+){" . $num . "}\s*$/i";
                
                break;
                
            default:
                throw new Exception('Error de configuración: `' 
                                    . $type_command . '` No es un comando válido. Usar tipo `'
                                    . Config::COMAND_TYPE_T  . '`, `'
                                    . Config::COMAND_TYPE_NM . '`, `'
                                    . Config::COMAND_TYPE_QU
                                   );
                break;
        }
        return $pattern;
            
    }
    
}

?>
