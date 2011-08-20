<?php
namespace prisoner;

// absolute filesystem path to the application root
define('APP_DIR', __DIR__ . '/..');

// absolute filesystem path to the libraries
define('LIBS_DIR', APP_DIR . '/../libs');

// absolute filesystem path to the temporary files
define('TEMP_DIR', APP_DIR . '/../temp');

abstract class CommandLineTool {
    
    private static $initialized = false;
    private $arguments;
    
    protected function __construct() {
        self::initEnvironment();
        $this->initTool();
    }
    
    public static function initEnvironment() {
        if (self::$initialized) {
            return;
        }
        self::$initialized = true;
        // Load Nette Framework
        // this allows load Nette Framework classes automatically so that
        // you don't have to litter your code with 'require' statements
        require LIBS_DIR . '/Nette/loader.php';
        $loader = new \Nette\Loaders\RobotLoader();
        $loader->addDirectory(APP_DIR);
        $loader->addDirectory(LIBS_DIR);
        $loader->register();
        // Enable Nette\Debug for error visualisation & logging
        \Nette\Diagnostics\Debugger::$strictMode = TRUE;
        \Nette\Diagnostics\Debugger::enable(\Nette\Diagnostics\Debugger::DEVELOPMENT);
    }
    
    abstract public function run();
    
    protected function getArgument(Argument $argument, $default = NULL) {
        if ($argument->isBool()) {
            return isset($this->arguments[$argument->getArg()]);
        }
        else {
            return (isset($this->arguments[$argument->getArg()]) ? $this->arguments[$argument->getArg()] : $default);
        }
    }
    
    protected abstract function getArguments();
    
    protected final function printArguments() {
        echo "  " . $_SERVER['SCRIPT_NAME'] . "\n";
        foreach($this->getArguments() AS $argument) {
            echo "      -" .  $argument->getArg() . " [" . $argument->getName() . "]" . ($argument->isRequired() ? " <REQUIRED>" : "") . "\n";
        }
    }
    
    protected final function printMessage($text, $type = 'info') {
        echo "  [$type]\t$text\n";
    }
    
    private function initTool() {
        $this->initArguments();
    }
    
    private function initArguments() {
        $options = "";
        foreach($this->getArguments() AS $argument) {
            $options .= $argument->getArg();
            if (!$argument->isBool()) {
                $options .= ":";
            }
        }        
        $values = getopt($options);
        foreach($this->getArguments() AS $argument) {
            if ($argument->isRequired() && !isset($values[$argument->getArg()])) {
                $this->printArguments();
                die;
            }
        }
        $this->arguments = $values;
    }
}

class Argument {
    
    private $arg;
    private $bool;
    private $name;
    private $required;
    
    public function __construct($arg, $name, $required = false, $bool = false) {
        $this->arg = $arg;
        $this->name = $name;
        $this->required = $required;
        $this->bool = $bool;
    }
    
    public function getArg() {
        return $this->arg;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function isBool() {
        return $this->bool;
    }
    
    public function isRequired() {
        return $this->required;
    }
}