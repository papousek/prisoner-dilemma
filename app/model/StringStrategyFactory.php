<?php
namespace prisoner;
class StringStrategyFactory {
    
    /** @return Strategy */
    public function createStrategy($string) {
        $splitted = explode(":", $string);
        if (count($splitted) != 3) {
            throw new \InvalidArgumentException("The string [$string] should be able to be splitted to 3 pieces by ':' character.");
        }
        $name = $splitted[0];
        $maxMemorySize = $splitted[1];
        $strategy = $splitted[2];
        $position=0;
        $memories = array();
        $responses = array();
        $memoryFactory = new StringMemoryFactory();
        for($memorySize=0; $memorySize<$maxMemorySize; $memorySize++) {
            $numberOfPieces = pow(2, $memorySize+1);
            for($i=0; $i<$numberOfPieces; $i++) {
                $memory = substr($strategy, $position, $memorySize);
                $response = substr($strategy, $position + $memorySize, 1);
                $position += $memorySize + 1;
                if ($memory === false || $response === false || $position > strlen($strategy)) {
                    throw new \InvalidArgumentException("The string [$string] can't be translated to strategy.");
                }
                $memories[] = $memoryFactory->createMemory($memory);
                $responses[] = new Response(strtoupper($response));
            }
        }
        return new Strategy($name, $memories, $responses);
    }
    
}
