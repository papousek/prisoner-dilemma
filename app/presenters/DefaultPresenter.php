<?php
class DefaultPresenter extends \Nette\Application\UI\Presenter {
    
    public function renderDefault($directory = NULL, $memorySize = NULL) {
        if ($directory == null || $memorySize == null) {
            $this->redirect("params");
        }
        
    }
    
    public function renderParams() {}
    
    public function renderSuccess() {
        
    }
    
    public function strategySubmitted(Nette\Forms\Form $form) {
        $values = $form->getValues();
        $memorySize = $this->getParam("memorySize");
        $strategyFile = new eskymo\io\File(WWW_DIR . '/strategies/' . $this->getParam("directory") . '/' . \Nette\Utils\Strings::webalize($values['name']) . '.strategy');
        if ($strategyFile->exists()) {
            $form->addError("Strategie s daným jménem již existuje.");
            return;
        }
        $strategyFile->createNewFile();
        $output = $values['name'] . ':' . $memorySize . ':';
        $counter = 0;
        for($length=0; $length<=$memorySize; $length++) {
            for($i=0; $i<pow(2, $length); $i++) {
                $output .= $values['memory' . $counter];
                $output .= ($values['response' . $counter] ? '1' : '0');
                $counter++;
            }
        }         
        $fp = fopen($strategyFile->getAbsolutePath(), "w");
        fwrite($fp, $output);
        fclose($fp);
        $this->redirect("success");
    }
    
    public function paramsSubmitted(Nette\Forms\Form $form) {
        $values = $form->getValues();
        $strategyDir = new eskymo\io\File(WWW_DIR . '/strategies/' . $values['directory']);
        if (!$strategyDir->exists()) {
            $form->addError("Adresář [" . $values['directory'] . "] není k dispozici.");
            return;
        }
        $this->redirect("default", $values['directory'], $values['memorySize']);
    }
    
    public function createComponentParamsForm($name) {
        $form = new Nette\Application\UI\Form();
        $form->addText("directory", "Adresář")
                ->addRule(Nette\Forms\Form::FILLED, "Pole 'Adresář' musí být vyplněno");
        $form->addText("memorySize", "Velikost paměti")
                ->addRule(Nette\Forms\Form::FILLED, "Pole 'Velikost paměti' musí být vyplněno.")
                ->addRule(Nette\Forms\Form::INTEGER, "Pole 'Velikost paměti' musí být číslo.");
        $form->addSubmit("submitbutton", "Odeslat");
        $form->onSuccess[] = array($this, "paramsSubmitted");
        return $form;
    }
    
    public function createComponentStrategyForm($name) {
        $memorySize = $this->getParam("memorySize");
        $form = new Nette\Application\UI\Form();
        $form->addGroup();
        $form->addText("name", "Název strategie")
                ->addRule(Nette\Forms\Form::FILLED, "Pole 'Název strategie' musí být vyplněno");        
        $form->addGroup("Spolupráce");
        $form->addCheckbox("response0", str_pad("", $memorySize, "?", STR_PAD_LEFT));
        $form->addHidden("memory0", "");
        $counter = 0;
        for($length=1; $length<=$memorySize; $length++) {
            for($i=0; $i<pow(2, $length); $i++) {
                $counter++;
                $form->addCheckbox("response" . $counter, str_pad(str_pad(decbin($i), $length, "0", STR_PAD_LEFT), $memorySize, "?", STR_PAD_LEFT));
                $form->addHidden("memory" . $counter, str_pad(decbin($i), $length, "0", STR_PAD_LEFT));
            }
        }        
        $form->addSubmit("submitbutton", "Odeslat");
        $form->onSuccess[] = array($this, "strategySubmitted");
        return $form;
    }
    
    protected function beforeRender() {
        $tournaments =new eskymo\io\File(WWW_DIR . '/tournaments');
        $this->getTemplate()->tournaments = $tournaments->listFiles();
    }
    
}
