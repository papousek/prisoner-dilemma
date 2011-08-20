<?php
namespace prisoner;
class Game {
 
    private $responsesA;
    private $responsesB;
    private $scoreA;
    private $scoreB;
    private $strategyA;
    private $strategyB;
    private $tournament;
    
    public function __construct(Tournament $tournament, Strategy $strategyA, Strategy $strategyB, array $responsesA, array $responsesB, $scoreA, $scoreB) {
        $this->tournament = $tournament;
        $this->strategyA = $strategyA;
        $this->strategyB = $strategyB;
        $this->responsesA = $responsesA;
        $this->responsesB = $responsesB;
        $this->scoreA = $scoreA;
        $this->scoreB = $scoreB;
    }
    
    /** @return Game */
    public static function createNewGame(Strategy $strategyA, Strategy $strategyB, Tournament $tournament) {
        $responsesA = array();
        $responsesB = array();
        $scoreA = 0;
        $scoreB = 0;
        for($i=0; $i<$tournament->getRounds(); $i++) {
            $responseA = $strategyA->getResponse(new Memory(array_slice($responsesB, -$strategyA->getMaxMemorySize())));
            $responseB = $strategyB->getResponse(new Memory(array_slice($responsesA, -$strategyB->getMaxMemorySize())));
            $responsesA[] = $responseA;
            $responsesB[] = $responseB;
            if ($responseA->getType() == Response::GOOD && $responseB->getType() == Response::GOOD) {
                $scoreA += $tournament->getScoreDrawGood();
                $scoreB += $tournament->getScoreDrawGood();
            }
            else if($responseA->getType() == Response::EVIL && $responseB->getType() == Response::EVIL) {
                $scoreA += $tournament->getScoreDrawEvil();
                $scoreB += $tournament->getScoreDrawEvil();                
            }
            else if($responseA->getType() == Response::EVIL && $responseB->getType() == Response::GOOD) {
                $scoreA += $tournament->getScoreWin();
                $scoreB += $tournament->getScoreLose();
            }
            else if($responseA->getType() == Response::GOOD && $responseB->getType() == Response::EVIL) {
                $scoreA += $tournament->getScoreLose();
                $scoreB += $tournament->getScoreWin();                
            }            
        }
        return new Game($tournament, $strategyA, $strategyB, $responsesA, $responsesB, $scoreA, $scoreB);
        
    }
    
    public function getResponsesA() {
        return $this->responsesA;
    }        

    public function getResponsesB() {
        return $this->responsesB;
    }            
    
    public function getScoreA() {
        return $this->scoreA;
    }    

    public function getScoreB() {
        return $this->scoreB;
    }        
    
    public function getStrategyA() {
        return $this->strategyA;
    }

    public function getStrategyB() {
        return $this->strategyB;
    }    
    
    public function getTournament() {
        return $this->tournament;
    }
}
