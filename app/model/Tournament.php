<?php
namespace prisoner;

class Tournament {

    private $rounds;
    private $scoreDrawGood;
    private $scoreDrawEvil;
    private $scoreLose;
    private $scoreWin;
    
    public function __construct($rounds, $scoreWin, $scoreLose, $scoreDrawGood, $scoreDrawEvil) {
        $this->rounds = $rounds;
        $this->scoreDrawGood = $scoreDrawGood;
        $this->scoreDrawEvil = $scoreDrawEvil;
        $this->scoreLose = $scoreLose;
        $this->scoreWin = $scoreWin;
    }

    public function getRounds() {
        return $this->rounds;
    }
    
    public function getScoreDrawGood() {
        return $this->scoreDrawGood;
    }    
    
    public function getScoreDrawEvil() {
        return $this->scoreDrawEvil;
    }
    
    public function getScoreLose() {
        return $this->scoreLose;
    }
    
    public function getScoreWin() {
        return $this->scoreWin;
    }
    
    /** @return array|Response*/
    public function play(array $responses) {
        
    }
}