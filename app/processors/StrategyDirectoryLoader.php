<?php
namespace prisoner;

class StrategyDirectoryLoader {

    public function loadStrategies(File $directory, $silent = true) {
        $files = $directory->listFiles(new \eskymo\io\FileNameFilter("*.strategy"));
        $factory = new StringStrategyFactory();
        $strategies = array();
        foreach($files AS $file) {
            $fp = fopen($file->getAbsolutePath(), "r");
            $content = fread($file, filesize($filename));
            $content = explode("\n", $content);
            if (count($content) < 1) {
                if ($silent) {
                    continue;
                }
                else {
                    throw new \InvalidArgumentException("The file [" . $file->getAbsolutePath() . "] has no line to parse.");
                }
            }
            if ($silent) {
                try {
                    $strategies[] = $factory->createStrategy($content[0]);
                } catch(Exception $e) {}
            }
            
        }
    }
    
}
