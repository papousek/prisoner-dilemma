<?php
namespace prisoner;

class Strategy {
    
    private $memories;
    private $maxMemorySize;
    private $responses;
    private $name;
    public function __construct($name, array $memories, array $responses) {
        if (count($memories) != count($responses)) {
            throw new \InvalidArgumentException("The size number of memories doesn't match to number of responses.");
        }
        $this->memorySize = 0;
        foreach($memories AS $memory) {
            if ($this->memorySize < $memory->getSize()) {
                $this->memorySize = $memory->getSize();
            }
        }
        $this->memories = $memories;
        $this->responses = $responses;
        $this->name = $name;
    }
    
    public function getMaxMemorySize() {
        return $this->maxMemorySize;
    }
    
    public function getName() {
        return $this->name;
    }
    
    /** @return Response */
    public function getResponse(\prisoner\Memory $memory) {
        $counter = 0;
        foreach($this->memories AS $m) {
            if ($memory->equals($m)) {
                return $this->responses[$counter];
            }
            $counter++;
        }
        throw new \InvalidArgumentException("There is no memory which matches the given one.");
    }
}