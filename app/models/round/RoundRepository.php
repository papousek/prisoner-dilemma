<?php
namespace prisoner;

class RoundRepository extends \eskymo\model\Repository
{

	public function __construct(\DibiConnection $connection) {
		parent::__construct($connection, "round", "prisoner");
	}

	/** @return \prisoner\RoundEntity */
	public function createEmpty() {
		return parent::createEmpty();
	}

}
