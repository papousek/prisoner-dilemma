<?php
namespace prisoner;

class Memory {
    
    private $responses;
    
    public function __construct(array $responses) {
        $this->responses = $responses;
    }
    
    /** @return \prisoner\Response */
    public function getResponse($index) {
        if ($index < 0 || $index >= $this->getSize()) {
            return $this->responses[$index];
        }
    }
    
    public function getSize() {
        return count($this->responses);
    }
    
    public function equals(Memory $memory) {
        if ($memory->getSize() != $this->getSize()) {
            return false;
        }
        for($i=0; $i<$memory->getSize(); $i++) {
            if ($memory->getResponse($i)->getType() != $this->getResponse($i)->getType()) {
                return false;
            }
        }
        return true;
    }
    
}
