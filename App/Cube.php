<?php namespace Cube;

use Exception;

class Cube{
    
    
    protected $n; //Dimension Cube
    protected $sequencer;
    protected $persistence;
    
    
    function __construct(){
        
        $this->persistence = new Persistence();
        
        $this->n = $this->persistence->getValue('n');
        
        $this->sequencer = new Sequencer($this->persistence);
    }
    
    private function setDimension($dimension){
        $this->n = $dimension;
        $this->persistence->setValue('n', $dimension);
    }
    
    private function getDimension(){
        return $this->n;
    }
    
    public function executeCommand($command){
        
        $result = '';
        
        //Sequence
        $sequence = $this->sequencer->getSequence();
        
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
        
        
        try{
            $policy = new Policy();
            switch($sequence){
                case Config::SEQUENCE_T:
                    $test_cases = $values[0];
                    $policy->verifyTestCase( $test_cases );
                    $this->sequencer->setTestCases($test_cases);
                    $this->sequencer->nextSequence();
                    break;

                case Config::SEQUENCE_NM:
                    
                    $dimension = $values[0];
                    $number_operation = $values[1];
                    
                    $policy->verifyDimension( $dimension );
                    $policy->verifyOperationsNumber( $number_operation );
                    
                    $this->setDimension($dimension);
                    $this->sequencer->setOperationsNumber($number_operation);
                    $this->sequencer->nextSequence();
                    
                    break;

                case Config::SEQUENCE_QU:
                    if(stripos($command, Config::COMMAND_QUERY ) !== FALSE ){
                        $policy->verifyPosition($this->getDimension(), $values[0], $values[1], $values[2]);
                        $policy->verifyPosition($this->getDimension(), $values[3], $values[4], $values[5]);
                    }else if(stripos($command, Config::COMMAND_UPDATE ) !== FALSE){
                        $policy->verifyPosition($this->getDimension(), $values[0], $values[1], $values[2]);
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