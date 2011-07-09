<?php
namespace prisoner;

/**
 * @property string $name
 * @property string $type
 * @property string $password
 * @property string $email
 * @property string $updated
 * @property string $inserted
 */
class UserEntity extends \eskymo\model\Entity {

	const JUDGE = 'judge';

	const PLAYER = 'player';

}
