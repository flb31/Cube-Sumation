<?php namespace Cube;

class Persistence{
    
    
    function __construct(){
        if( !isset($_SESSION) ) session_start();
    }
    
    public function getValue($key){
        
        if(!isset($_SESSION[$key])) return '';
        return $_SESSION[$key];
    }
    
    public function setValue($key, $value){
        $_SESSION[$key] = $value;
    }
    
    public function print_sess(){
        print_r($_SESSION);
    }
}

?>