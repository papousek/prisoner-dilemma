<?php
namespace prisoner;

class UserRepostory extends \eskymo\model\Repository {

	public function __construct(\DibiConnection $connection) {
		parent::__construct($connection, "user", "prisoner");
	}

	/** @return \prisoner\UserEntity */
	public function createEmpty() {
		return parent::createEmpty();
	}

}
