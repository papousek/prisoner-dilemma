<?php
class LoginForm extends \eskymo\components\VisualComponent
{

	public function formSubmitted(\Nette\Forms\Form $form) {
		$values = $form->getValues();
		$user = $this->getParent()->getService('user');
		try {
			$user->login($values['email'], $values['password']);
		}
		catch(Nette\Security\AuthenticationException $e) {
			switch($e->getCode()) {
				case Nette\Security\IAuthenticator::IDENTITY_NOT_FOUND:
					$this->getPresenter()->flashMessage('Uživatel neexistuje.', 'error');
					break;
				case Nette\Security\IAuthenticator::INVALID_CREDENTIAL:
					$this->getPresenter()->flashMessage('Špatné heslo.', 'error');
			}
		}
		$this->getPresenter()->redirect('this');
	}

	public function createComponentForm($name) {
		$form = new \Nette\Application\UI\Form($this, $name);
		$form->addText("email", "E-mail")
			->addRule(Nette\Forms\Form::FILLED, "E-mail musí být vyplněn.");
		$form->addPassword("password", "Heslo")
			->addRule(Nette\Forms\Form::FILLED, "Heslo musí být vyplněno.");
		$form->addSubmit("loginSubmit", "Přihlásit se");
		$renderer = $form->getRenderer();
		$renderer->wrappers['pair']['container'] = NULL;
		$form->onSuccess[] = callback($this, 'formSubmitted');
		return $form;
	}

}
