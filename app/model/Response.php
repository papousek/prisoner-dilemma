<?php
namespace prisoner;

class Response {
    
    const EVIL = '0';
    const GOOD = '1'; 
    
    private $type;
    
    public function __construct($type) {
        if ($type != self::EVIL && $type != self::GOOD) {
            throw new \InvalidArgumentException("The given type [$type] is not valid.");
        }
        $this->type = $type;
    }
    
    public function getType() {
        return $this->type;
    }
}