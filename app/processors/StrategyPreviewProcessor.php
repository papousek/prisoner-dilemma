<?php

namespace prisoner;

class StrategyPreviewProcessor extends AbstractProcessor {

    private $processedFiles;
    
    protected function after(\eskymo\io\File $destinationDir) {
        $indexFile = new \eskymo\io\File($this->getPreviewDirectory($destinationDir)->getAbsolutePath() . '/index.html');
        $indexFile->createNewFile();
        $template = $this->createTemplate($destinationDir, "..");
        $template->files = $this->processedFiles;
        $template->setFile(__DIR__ . '/templates/index-preview.latte');
        $template->save($indexFile->getAbsolutePath());
    }
    
    protected function before(\eskymo\io\File $destinationDir) {
       $previewDir = $this->getPreviewDirectory($destinationDir);
       if ($previewDir->exists()) {
           foreach($previewDir->listFiles() AS $file) {
               $file->delete();
           }
           $previewDir->delete();
       }
       $this->processedFiles = array();
       $previewDir->mkdir();
    }
    
    protected function processStrategy(Strategy $strategy, \eskymo\io\File $destinationDir) {
        $webalized = \Nette\Utils\Strings::webalize($strategy->getName());
        $previewDir = $this->getPreviewDirectory($destinationDir);
        $previewFile = new \eskymo\io\File($previewDir->getAbsolutePath() . '/' . $webalized . "-preview-" . uniqid() . '.html');
        if (!$previewDir->exists()) {
            $previewDir->mkdir();
        }
        $previewFile->createNewFile();
        $template = $this->createTemplate($destinationDir, "..");
        $template->strategy = $strategy;
        $template->setFile(__DIR__ . '/templates/preview.latte');
        $template->save($previewFile->getAbsolutePath());
        $this->processedFiles[$previewFile->getName()] = $strategy;
    }
    
    /** @return \eskymo\io\File */
    private function getPreviewDirectory(\eskymo\io\File $destinationDir) {
        return new \eskymo\io\File($destinationDir->getAbsolutePath() . '/preview');
    }

}