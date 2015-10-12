<?php namespace Cube;

use Exception;

class Validator{
    
    public function scanCommand($command, $sequence){
        
        try{
            
            if( is_null($command) || strlen($command) == 0 ) throw new Exception('');
            
            $res = $this->specialCommands($command);
            if ( $res['res'] ) return $res;
            
            if ( preg_match ( $this->getPattern($sequence, $command) , $command) )
                return array('res' => TRUE, 'command' => '');
            else{
                throw new Exception( 
                        $this->getMessageExceptionScan ($sequence)
                );
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    protected function  specialCommands($command){
        if( preg_match("/^\s*reset\s*$/i", $command) ) 
            return array('res' => TRUE, 'command' => Config::COMMAND_RESET );
        
        return array('res' => FALSE, 'command' => '');
    }
    
    protected function getMessageExceptionScan($sequence){
        
        $main_message = 'Comando no válido debe ser de la forma:';
        
        $comando_query  = Config::COMMAND_QUERY . ' x1 y1 z1 x2 y2 z2';
        $comando_update = Config::COMMAND_UPDATE . ' x y z W';
        $message_qu = "$main_message `$comando_query` O `$comando_update`.";
            
        $message_t = "$main_message Numero de tests `T`.";
        $message_nm = "$main_message Dimesión del cubo (N) y total de operaciones (M) => `N M`";
        
        $arr_msg = array (
                        Config::SEQUENCE_T => $message_t,
                        Config::SEQUENCE_NM => $message_nm,
                        Config::SEQUENCE_QU => $message_qu
                    );
        
        return $arr_msg[$sequence];
    }
    
    protected function getPattern($sequence, $command){
        
        $pattern = '';
        
        switch($sequence){
                
            case Config::SEQUENCE_T:
                $pattern = "/^\s*-?\d+\s*$/";
                break;
                 
            case Config::SEQUENCE_NM:
                $pattern = "/^\s*-?\d+\s+-?\d+\s*$/";
                break;
                
            case Config::SEQUENCE_QU:
                $type = '';
                $num = '';
                if(stripos($command, Config::COMMAND_QUERY ) !== FALSE ){
                    $type = Config::COMMAND_QUERY;
                    $num  = Config::TOTAL_NUM_QUERY;
                }else if(stripos($command, Config::COMMAND_UPDATE ) !== FALSE){
                    $type = Config::COMMAND_UPDATE;
                    $num  = Config::TOTAL_NUM_UPDATE;    
                }
                $pattern = "/^\s*" . $type . "(\s+-?\d+){" . $num . "}\s*$/i";
                
                break;
                
            default:
                throw new Exception('Error de configuración: `' 
                                    . $sequence . '` No es un comando válido. Usar tipo `'
                                    . Config::SEQUENCE_T  . '`, `'
                                    . Config::SEQUENCE_NM . '`, `'
                                    . Config::SEQUENCE_QU
                                   );
                break;
        }
        return $pattern;
            
    }
    
}

?>
