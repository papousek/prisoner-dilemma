<?php
namespace prisoner;

class TournamentRepository extends \eskymo\model\Repository {

	public function __construct(\DibiConnection $connection) {
		parent::__construct($connection, "tournament", "prisoner");
	}

	/** @return \prisoner\TournamentEntity */
	public function createEmpty() {
		return parent::createEmpty();
	}

}
