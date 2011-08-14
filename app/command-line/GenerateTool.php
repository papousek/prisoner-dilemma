<?php
namespace prisoner;

class GenerateTool extends CommandLineTool {

    private static $STRATEGY_DIR;
    private static $DESTINATION_DIR;
    
    public function __construct() {
        self::$STRATEGY_DIR = new Argument("s", "directory where strategies are located", true);
        self::$DESTINATION_DIR = new Argument("d", "directory where generated files will be placed", true);
        parent::__construct();
    }

    public function run() {
        $source = new \eskymo\io\File($this->getArgument(self::$STRATEGY_DIR));
        $destination = new \eskymo\io\File($this->getArgument(self::$DESTINATION_DIR));
    }
    
    protected function getArguments() {
        return array(
            self::$STRATEGY_DIR,
            self::$DESTINATION_DIR
        );
    }
    
}

