<?php
namespace prisoner;

class StrategyRepository extends \eskymo\model\Repository
{

	public function __construct(\DibiConnection $connection) {
		parent::__construct($connection, "strategy", "prisoner");
	}

	/** @return \prisoner\StrategyEntity */
	public function createEmpty() {
		return parent::createEmpty();
	}

	/** @return \prisoner\StrategyEntity */
	public function createFromString($string) {
		$position = 0;
		$memorySize = 1;
		while($position < strlen($string)) {
			for($i = 0; $i<pow(2, $memorySize); $i++) {
				
			}
		}
	}

}
