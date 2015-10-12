<?php namespace Cube;

use Exception;


class Policy{
    
    
    public function verifyTestCase($t){
        if( !(Config::MIN_T <= $t && $t <= Config::MAX_T) ) 
            throw new Exception(
                    'El número de casos no puede ser menor que ' . Config::MIN_T . ' ni mayor que ' . Config::MAX_T . ". Valor: $t"
            );
    }
    
    public function verifyDimension($n){
        if( !(Config::MIN_N <= $n && $n <= Config::MAX_N) ) 
            throw new Exception(
                    'La dimensión no puede ser menor que ' . Config::MIN_N . ' ni mayor que ' . Config::MAX_N . ". Valor: $n"
            );
    }
    
    public function verifyOperationsNumber($m){
        if( !(Config::MIN_M <= $m && $m <= Config::MAX_M) ) 
            throw new Exception(
                    'El número de operaciones no puede ser menor que ' . Config::MIN_M . ' ni mayor que ' . Config::MAX_M . ". Valor: $m"
            );
    }
    
    public function verifyPosition($n, $x, $y, $z){
        
        if( !(Config::MIN_N <= $x && $x <= $n) ) 
            throw new Exception(
                    "El valor de X no puede ser menor que "  . Config::MIN_N . " ni mayor que " . $n . ". Valor: $x"
            );
        
        if( !(Config::MIN_N <= $y && $y <= $n) ) 
            throw new Exception(
                    "El valor de Y no puede ser menor que " . Config::MIN_N . " ni mayor que " . $n . ". Valor: $y"
            );
        
        if( !(Config::MIN_N <= $z && $z <= $n) ) 
            throw new Exception(
                    "El valor de Z no puede ser menor que " . Config::MIN_N . " ni mayor que " . $n . ". Valor: $z"
            );
        
    }
    
    public function verifyCellValue($w, $x, $y, $z){
        if( !(Config::MIN_W <= $w && $w <= Config::MAX_W) ) 
            throw new Exception(
                    "El valor para la celda ($x,$y,$z) no puede ser menor que " . Config::MIN_W . " ni mayor que " . Config::MAX_W . ". Valor: $w"
            );
    }
}

?>