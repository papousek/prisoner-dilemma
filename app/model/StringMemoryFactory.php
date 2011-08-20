<?php
namespace prisoner;
class StringMemoryFactory {
    
    const UNKNOWN = 'U';
    
    /** @return Memory */
    public function createMemory($string) {
        $trimmedString = trim(strtoupper($string), self::UNKNOWN);
        $responses = array();
        for($i=0; $i<strlen($string); $i++) {
            $responses[] = new Response($trimmedString{$i});
        }
        return new Memory($responses);
    }
}
