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
            
            if( $this->sequencer->isMoreTest() ) {
                $val = new Validator();
                $result = $val->scanCommand($command, $sequence);

                if($result !== TRUE)
                    return $result;

                $this->sequencer->executeSequence();
                $result = $this->verifyRules($sequence, $command);
            
            }else
                $result = 'Fin.';
            
        }catch(Exception $e ){
            return $e->getMessage();
        }
        
        return $result;
    }
    
    
    
    protected function verifyRules($sequence, $command){
        
        $ext = new Extractor();
        $values = $ext->extractValues($command);
        
        $message = '';
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
                    $message = 'Dimensión y número de operaciones (N, M)';
                    break;

                case Config::SEQUENCE_NM:
                    
                    $dimension = $values[0];
                    $number_operation = $values[1];
                    
                    $policy->verifyDimension( $dimension );
                    $policy->verifyOperationsNumber( $number_operation );
                    
                    $this->setDimension($dimension);
                    $this->sequencer->setOperationsNumber($number_operation);
                    $this->sequencer->nextSequence();
                    
                    $this->createCube();
                    $message = 'Comandos QUERY y UPDATE';
                    
                    break;

                case Config::SEQUENCE_QU:
                    
                    if(stripos($command, Config::COMMAND_QUERY ) !== FALSE ){
                        
                        $x1 = $values[0]; $y1 = $values[1]; $z1 = $values[2];
                        $x2 = $values[3]; $y2 = $values[4]; $z2 = $values[5];
                        
                        $policy->verifyPosition($this->getDimension(), $x1, $y1, $z1);
                        $policy->verifyPosition($this->getDimension(), $x2, $y2, $z2);
                        
                        $message = $this->executeCube(Config::COMMAND_QUERY, $x1, $y1, $z1, 0, $x2, $y2, $z2);
                        
                    }else if(stripos($command, Config::COMMAND_UPDATE ) !== FALSE){
                        
                        $x1 = $values[0]; $y1 = $values[1]; $z1 = $values[2]; $w = $values[3];
                        
                        $policy->verifyPosition($this->getDimension(), $x1, $y1, $z1);
                        $policy->verifyCellValue($w, $x1, $y1, $z1);
                        
                        $message = $this->executeCube(Config::COMMAND_UPDATE, $x1, $y1, $z1, $w);
                    }
                    
                    break;
            }
        
        }catch(Exception $e ){
            return $e->getMessage();
        }
        
        return $message;    
    }
    
    protected function createCube(){
        $dim = $this->getDimension();
        for($x = Config::MIN_N; $x <= $dim; $x ++ ){
            for($y = Config::MIN_N; $y <= $dim; $y ++ ){
                for($z = Config::MIN_N; $z <= $dim; $z ++ ){
                    $this->persistence->setValue( $this->getFormatCells($x, $y, $z), Config::INIT_VAL_CELLS);
                }
            }
            
        }
    }
    
    protected function getFormatCells($x, $y, $z){
        return "$x-$y-$z";
    }
    
    
    protected function sumCells($x1, $y1, $z1, $x2, $y2, $z2){
        $result = 0;
        
        for($x = $x1; $x <= $x2; $x ++ ){
            for($y = $y1; $y <= $y2; $y ++ ){
                for($z = $z1; $z <= $z2; $z ++ ){
                    
                    $val = $this->persistence->getValue( $this->getFormatCells($x, $y, $z) );
                    if( !is_numeric( $val ) ) throw new Exception("Error: La celda ($x, $y, $z) no tiene un valor válido. Valor: $val");
                        
                    $result += $val;
                }
            }
        }
        
        return $result;
    }
    
    protected function executeCube($command_type, $x1, $y1, $z1, $w, $x2 = 0, $y2 = 0, $z2 = 0){
        $result  = '';
        
        if($command_type == Config::COMMAND_UPDATE ){
            $this->persistence->setValue( $this->getFormatCells($x1, $y1, $z1), $w );
            $result = "Actualizado ($x1, $y1, $z1)";
        }else if($command_type == Config::COMMAND_QUERY ){
            $result = $this->sumCells($x1, $y1, $z1, $x2, $y2, $z2);
        }else{
            throw new Exception(
                "Tipo commando Desconocido: $command_type"
            );
        }
        
        
        return $result;
    }
        
}

?>