<?php namespace Cube;


class Config{
    
    #Values for Validator and Extractor Class 
    const SEQUENCE_T  = 'T';  // T => Total test cases.
    const SEQUENCE_NM = 'NM'; // N M => size cube and total operations
    const SEQUENCE_QU = 'QU'; // QUERY or UPDATE operation
    const SEQUENCE_DEFAULT = Config::SEQUENCE_T;
    
    const COMMAND_UPDATE = 'UPDATE';
    const COMMAND_QUERY  = 'QUERY';

    const TOTAL_NUM_UPDATE = 4;
    const TOTAL_NUM_QUERY  = 6;
    
    #Cube
    const INIT_VAL_CELLS = 0;
    
    #Special Command
    const COMMAND_RESET = 'RESET';
    
    
    #Values for Policy Class
    const MIN_T = 1;
    const MAX_T = 50;
    
    const MIN_N = 1;
    const MAX_N = 100;
    
    const MIN_M = 1;
    const MAX_M = 1000;
    
    const MIN_W = -1000000000;
    const MAX_W = 1000000000;
}


?>