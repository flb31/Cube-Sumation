<?php namespace Cube\Helpers;

class Extractor{
    
    private $array_values;
    
    public function extractValues($command){
        preg_replace_callback ("[-?\d+]", array( $this, 'extraerNumeros'), $command);
        return $this->array_values;
    }
    
    protected function extraerNumeros($data){
        $this->array_values[] = $data[0];
    }
}


?>