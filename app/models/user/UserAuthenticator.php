<?php
namespace prisoner;
class UserAuthenticator extends \eskymo\Object implements \Nette\Security\IAuthenticator
{

	/** @var UserRepostory */
	private $repository;

	public function __construct(UserRepository $repository) {
		$this->repository = $repository;
	}

	public function authenticate(array $credentials) {
		$username = $credentials[\Nette\Security\IAuthenticator::USERNAME];
		$password = $credentials[\Nette\Security\IAuthenticator::PASSWORD];
		$user = $this->repository->fetchAndCreate(
			$this->repository->findAll()->where('[email] = %s', $username)
		);
		if (empty($user)) {
			throw new \Nette\Security\AuthenticationException("User not found.", \Nette\Security\IAuthenticator::IDENTITY_NOT_FOUND);
		}
		if ($this->repository->hashPassword($password) !== $user->password) {
			throw new \Nette\Security\AuthenticationException("Invalid password.", \Nette\Security\IAuthenticator::INVALID_CREDENTIAL);
		}
		return new \Nette\Security\Identity($user->getId(), $user->type);
	}

}

