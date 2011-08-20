<?php
namespace prisoner;

class GenerateTool extends CommandLineTool {

    
    private static $DESTINATION_DIR;
    private static $ERROR_REPORT;
    private static $ROUNDS;
    private static $SCORE_DRAW_EVIL;
    private static $SCORE_DRAW_GOOD;
    private static $SCORE_LOSE;
    private static $SCORE_WIN;
    private static $STRATEGY_DIR;
    
    public function __construct() {
        self::$DESTINATION_DIR = new Argument("d", "directory where generated files will be placed", true);
        self::$ERROR_REPORT = new Argument("e", "enables error reporting", false, true);
        self::$ROUNDS = new Argument("r", "rounds", false);
        self::$SCORE_DRAW_EVIL = new Argument("se", "score for draw (evil)", false);
        self::$SCORE_DRAW_GOOD = new Argument("sg", "score for draw (good)", false);
        self::$SCORE_LOSE = new Argument("sl", "score for lose", false);
        self::$SCORE_WIN = new Argument("sw", "score for win", false);
        self::$STRATEGY_DIR = new Argument("s", "directory where strategies are located", true);
        parent::__construct();
    }

    public function run() {
        $source = new \eskymo\io\File($this->getArgument(self::$STRATEGY_DIR));
        $destination = new \eskymo\io\File($this->getArgument(self::$DESTINATION_DIR));
        $loader = new StrategyDirectoryLoader();
        $strategies = $loader->loadStrategies($source, !$this->getArgument(self::$ERROR_REPORT));
        foreach($this->getProcessors() AS $processor) {
            $processor->process($strategies, $destination, !$this->getArgument(self::$ERROR_REPORT));
        }
        
    }
    
    protected function getArguments() {
        return array(
            self::$DESTINATION_DIR,
            self::$ERROR_REPORT,
//            self::$SCORE_DRAW_EVIL,
//            self::$SCORE_DRAW_GOOD,
//            self::$SCORE_LOSE,
//            self::$SCORE_WIN,
            self::$STRATEGY_DIR,
        );
    }
    
    private function getProcessors() {
        $scoreDrawEvil = $this->getArgument(self::$SCORE_DRAW_EVIL, 1);
        $scoreDrawGood = $this->getArgument(self::$SCORE_DRAW_GOOD, 3);
        $scoreLose = $this->getArgument(self::$SCORE_LOSE, 0);
        $scoreWin = $this->getArgument(self::$SCORE_WIN, 5);
        $rounds = $this->getArgument(self::$ROUNDS, 10);
        return array(
            new StrategyPreviewProcessor(),
            new TournamentProcessor(new Tournament($rounds, $scoreWin, $scoreLose, $scoreDrawGood, $scoreDrawEvil)),
        );
    }
    
}

