<?php
namespace prisoner;

interface Processor {
 
    function process(array $strategies, File $destinationDir, $silent = true);
    
}
