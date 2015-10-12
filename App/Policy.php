<?php namespace Cube;

use Exception;


class Policy{
    
    const MIN_T = 1;
    const MAX_T = 50;
    
    const MIN_N = 1;
    const MAX_N = 100;
    
    const MIN_M = 1;
    const MAX_M = 1000;
    
    const MIN_W = -1000000000;
    const MAX_W = 1000000000;
    
    function __contruct(){
        
    }
    
    public function verifyTestCase($t){
        if( !(self::MIN_T <= $t && $t <= self::MAX_T) ) 
            throw new Exception(
                    'El número de casos no puede ser menor que ' . self::MIN_T . ' ni mayor que ' . self::MAX_T
            );
    }
    
    public function verifyDimension($n){
        if( !(self::MIN_N <= $n && $n <= self::MAX_N) ) 
            throw new Exception(
                    'La dimensión no puede ser menor que ' . self::MIN_N . ' ni mayor que ' . self::MAX_N
            );
    }
    
    public function verifyOperationsNumber($m){
        if( !(self::MIN_M <= $m && $m <= self::MAX_M) ) 
            throw new Exception(
                    'El número de operaciones no puede ser menor que ' . self::MIN_M . ' ni mayor que ' . self::MAX_M
            );
    }
    
    public function verifyPosition($n, $x, $y, $z){
        
        if( !(self::MIN_N <= $x && $x <= $n) ) 
            throw new Exception(
                    "El valor para X no puede ser menor que "  . self::MIN_N . " ni mayor que " . $n
            );
        
        if( !(self::MIN_N <= $y && $y <= $n) ) 
            throw new Exception(
                    "El valor para Y no puede ser menor que " . self::MIN_N . " ni mayor que " . $n
            );
        
        if( !(self::MIN_N <= $z && $z <= $n) ) 
            throw new Exception(
                    "El valor para Z no puede ser menor que " . self::MIN_N . " ni mayor que " . $n
            );
        
    }
    
    public function verifyCellValue($w, $x, $y, $z){
        if( !(self::MIN_W <= $w && $w <= self::MAX_W) ) 
            throw new Exception(
                    "El valor para la celda ($x,$y,$z) no puede ser menor que " . self::MIN_W . " ni mayor que " . self::MAX_W
            );
    }
}

?>