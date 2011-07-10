<?php
class DefaultPresenter extends BasePresenter
{

	public function renderDefault() {}

	public function createComponentLoginForm($name) {
		return new LoginForm($this, $name);
	}

}
