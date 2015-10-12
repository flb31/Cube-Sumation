<?php namespace Cube;

class Sequencer{
    
    protected $t;
    protected $t_index;
    protected $sequence;
    protected $m;
    protected $m_index;
    
    protected $persistence;
    
    function __construct($persistence){
        
        $this->persistence = $persistence;
        
        $this->setSequence($this->persistence->getValue('sequence'));
        
        $this->setTestCases ($this->persistence->getValue('t') );
        $this->setTestCasesIndex ( $this->persistence->getValue('t_index') );
        
        $this->setOperationsNumber ( $this->persistence->getValue('m') );
        $this->setOperationsNumberIndex( $this->persistence->getValue('m_index') );
        
        $this->verifyData();
        
    }
    
    
    public function setOperationsNumber($number){
        $this->m = $number;
        $this->persistence->setValue('m', $number);
    }
    
    public function getOperationsNumber(){
        return $this->m;
    }
    
    public function setTestCases($test_cases){
        $this->t = $test_cases;
        $this->persistence->setValue('t', $test_cases);
    }
    
    public function getTestCases(){
        return $this->t;
    }
    
    
    public function getOperationsNumberIndex(){
        return $this->m_index;
    }
    
    public function setOperationsNumberIndex($index){
        $this->m_index = $index;
        $this->persistence->setValue('m_index', $index);
    }
    
    
    public function getTestCasesIndex(){
        return $this->t_index;
    }
    
    public function setTestCasesIndex($index){
        $this->t_index = $index;
        $this->persistence->setValue('t_index', $index);
    }
    
    protected function verifyData(){
        if( is_null( $this->getSequence() ) || strlen( $this->getSequence() ) == 0 || $this->getSequence() == FALSE)
            $this->setSequence ( Config::SEQUENCE_DEFAULT );
        
        
        if( is_null( $this->getOperationsNumber() ) || strlen( $this->getOperationsNumber() ) == 0 || $this->getOperationsNumber() == FALSE)
            $this->setOperationsNumber ( 0 );
        
        
        if( is_null( $this->getOperationsNumberIndex() ) || strlen( $this->getOperationsNumberIndex() ) == 0 || $this->getOperationsNumberIndex() == FALSE)
        $this->setOperationsNumberIndex( 0 );
    }
    
    public function nextSequence(){
        
        if($this->getSequence() == Config::SEQUENCE_T )
            $this->setSequence ( Config::SEQUENCE_NM );
        else if($this->getSequence() == Config::SEQUENCE_NM )
            $this->setSequence ( Config::SEQUENCE_QU );
    }
    
    protected function setSequence($sequence){
        $this->sequence = $sequence;
        $this->persistence->setValue('sequence', $sequence);
    }
    
    public function getSequence(){
        return $this->sequence;
    }
    
    
    public function executeSequence(){
        
        $test_case = $this->getTestCases();
        $index_case = $this->getTestCasesIndex();
        
        if($this->getSequence() == Config::SEQUENCE_QU ){
            $op_num = $this->getOperationsNumber();
            $op_num_idx = $this->getOperationsNumberIndex();

            if(++$op_num_idx < $op_num ){
                $this->setOperationsNumberIndex( $op_num_idx );
            }else{
                $this->setOperationsNumberIndex( 0 );
                $this->setSequence( Config::SEQUENCE_NM );
                $this->setTestCasesIndex( ++$index_case );
            }
        }
        
    }
    
    public function isMoreTest(){
        $test_case = $this->getTestCases();
        $index_case = $this->getTestCasesIndex();
        
        if($this->getSequence() == Config::SEQUENCE_NM && $index_case < $test_case)
            return TRUE;
        if($this->getSequence() == Config::SEQUENCE_T)
            return TRUE;
        if($this->getSequence() == Config::SEQUENCE_QU && $index_case < $test_case)
            return TRUE;
        
        return FALSE;
    }
    
    
}

?>