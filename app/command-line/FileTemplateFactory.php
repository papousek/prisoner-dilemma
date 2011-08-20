<?php
class FileTemplateFactory {
    
    private static $instance;
    
    /** @return \FileTemplateFactory */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new FileTemplateFactory();
        }
        return self::$instance;
    }
    
    /** @return Nette\Templating\FileTemplate */
    public function createTemplate(eskymo\io\File $destinationDir, $contextPath = "") {
        $template = new \Nette\Templating\FileTemplate();
        $template->registerHelperLoader('Nette\Templating\DefaultHelpers::loader');
        $template->registerFilter(new \Nette\Latte\Engine());
        $template->destinationDir = $destinationDir;
        $template->contextPath = $contextPath;
        $template->registerHelper('strategyLink', array(get_class(), 'strategyLinkHelper'));
        return $template;        
    }
    
    public static function strategyLinkHelper(\prisoner\Strategy $strategy, eskymo\io\File $destinationDir, $contextPath) {
        $previewDir = new eskymo\io\File($destinationDir->getAbsolutePath() . '/preview');
        $files = $previewDir->listFiles(new \eskymo\io\FileNameFilter(\Nette\Utils\Strings::webalize($strategy->getName()) . '-preview-*'));
        if (count($files) != 1) {
            return '';
        }
        else {
            return $contextPath . '/preview/' . $files[0]->getName();
        }
    }
    
}