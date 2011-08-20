<?php
namespace prisoner;

class TournamentProcessor implements Processor {
    
    /** @var Tournament */
    private $tournament;
    
    public function __construct(Tournament $tournament) {
        $this->tournament = $tournament;
    }
    
    public function process(array $strategies, \eskymo\io\File  $destinationDir, $silent = true) {
        $this->prepare($destinationDir);
        $games = $this->getGames($strategies, $silent);
        $this->createTournamentChart($strategies, $destinationDir, $silent, $games);
        $this->createGamePages($strategies, $destinationDir, $silent, $games);
        $this->createIndexPage($strategies, $destinationDir, $silent, $games);
    }
    
    private function prepare(\eskymo\io\File  $destinationDir) {
       $dir = $this->getTournamentDirectory($destinationDir);
       if ($dir->exists()) {
           foreach($dir->listFiles() AS $file) {
               $file->delete();
           }
           $dir->delete();
       }
       $dir->mkdir();        
    }
    

    
    private function createIndexPage(array $strategies, \eskymo\io\File $destinationDir, $silent, array $games) {
        $scores = array();
        $goodRatio = array();
        for($i=0; $i<count($strategies); $i++) {
            $score = 0;
            foreach($games[$i] AS $game) {
                if ($game == null) continue;
                $score += $game->getScoreA();
            }
            $scores[$i] = $score;
        }
        arsort($scores);
        $newStrategies = array();
        foreach($scores AS $index => $score ) {
            $newStrategies[] = array($strategies[$index], $score);
        }
        $indexFile = new \eskymo\io\File($destinationDir->getAbsolutePath() . '/index.html');
        $indexFile->createNewFile();
        $template = \FileTemplateFactory::getInstance()->createTemplate($destinationDir, ".");        
        $template->setFile(__DIR__ . '/templates/index.latte');
        $template->strategies = $newStrategies;
        $template->save($indexFile->getAbsolutePath());
    }


    private function createGamePages(array $strategies, \eskymo\io\File $destinationDir, $silent, array $games) {
        $counterRow = 0;
        foreach($games AS $gameRow) {
            $counterGame = 0;
            foreach($gameRow AS $game) {
                if ($game == null) {
                    $counterGame++;
                    continue;
                }
                $templateFile = new \eskymo\io\File($this->getTournamentDirectory($destinationDir)->getAbsolutePath() . '/game_' . $counterRow . '_' . $counterGame . '.html');
                $templateFile->createNewFile();
                $template = \FileTemplateFactory::getInstance()->createTemplate($destinationDir, "..");
                $template->strategyA = $strategies[$counterRow];
                $template->strategyB = $strategies[$counterGame];
                $template->game = $game;
                $template->setFile(__DIR__ . '/templates/game.latte');
                $template->save($templateFile->getAbsolutePath());
                $counterGame++;
            }
            $counterRow++;
        }
    }

    private function createTournamentChart(array $strategies, \eskymo\io\File $destinationDir, $silent, array $games) {
        $indexFile = new \eskymo\io\File($this->getTournamentDirectory($destinationDir)->getAbsolutePath() . '/index.html');
        $indexFile->createNewFile();
        $template = \FileTemplateFactory::getInstance()->createTemplate($destinationDir, "..");
        $template->setFile(__DIR__ . '/templates/index-tournament.latte');
        $template->strategies = $strategies;
        $template->games = $games;
        $template->save($indexFile->getAbsolutePath());
    }    
    
    private function getGames(array $strategies, $silent) {
        $games = array();
        $counterA = 0;
        foreach($strategies AS $strategyA) {
            $games[$counterA] = array();
            $counterB = 0;
            foreach($strategies AS $strategyB) {
                if ($counterA == $counterB) {
                    $games[$counterA][] = null;
                }
                else {
                    $games[$counterA][] = Game::createNewGame($strategyA, $strategyB, $this->tournament);
                }
                $counterB++;
            }
            $counterA++;
        }
        return $games;
    }
    
    /** @return \eskymo\io\File */
    private function getTournamentDirectory(\eskymo\io\File $destinationDir) {
        return new \eskymo\io\File($destinationDir->getAbsolutePath() . '/tournament');
    }
    
}
