<?php
namespace prisoner;

interface Processor {
 
    function process(array $strategies, \eskymo\io\File  $destinationDir, $silent = true);
    
}
