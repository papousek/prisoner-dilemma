<?php
namespace prisoner;

class UserRepository extends \eskymo\model\Repository {

	public function __construct(\DibiConnection $connection) {
		parent::__construct($connection, "user", "prisoner");
	}

	/** @return \prisoner\UserEntity */
	public function createEmpty() {
		return parent::createEmpty();
	}

	public function hashPassword($password) {
		return sha1($password . Strings::capitalize($password) . 'prisoner');
	}

}
