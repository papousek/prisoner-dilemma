<?php
namespace prisoner;

class StrategyDirectoryLoader {

    public function loadStrategies(\eskymo\io\File $directory, $silent = true) {
        $files = $directory->listFiles(new \eskymo\io\FileNameFilter("*.strategy"));
        $factory = new StringStrategyFactory();
        $strategies = array();
        foreach($files AS $file) {
            $fp = fopen($file->getAbsolutePath(), "r");
            $content = fread($fp, filesize($file->getAbsolutePath()));
            $content = explode("\n", $content);
            if (count($content) < 1) {
                fclose($fp);
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
                } catch(Exception $e) {
                    fclose($fp);
                }
            }
            else {
                $strategies[] = $factory->createStrategy($content[0]);
            }
        }
        return $strategies;
    }
    
}
