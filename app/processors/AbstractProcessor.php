<?php
namespace prisoner;

abstract class AbstractProcessor implements Processor {
    
    public function process(array $strategies, \eskymo\io\File $destinationDir, $silent = true) {
        $this->before($destinationDir);
        foreach($strategies AS $strategy) {
            if ($silent) {
                try {
                    $this->processStrategy($strategy, $destinationDir);
                } catch(Exception $e) {}
            }
            else {
                $this->processStrategy($strategy, $destinationDir);
            }
        }
        $this->after($destinationDir);
    }
    
    protected function createTemplate(\eskymo\io\File $destinationDir, $contextPath) {
        return \FileTemplateFactory::getInstance()->createTemplate($destinationDir, $contextPath);
    }
    
    abstract protected function after(\eskymo\io\File $destinationDir);
    
    abstract protected function before(\eskymo\io\File $destinationDir);
    
    abstract protected function processStrategy(Strategy $strategy, \eskymo\io\File $destinationDir);
}
