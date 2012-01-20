<?php

/**
 * Steps relating the to the general behavior of the CMS
 */
class CMSSteps extends WebDriverSteps {

	/**
	 * Given /^I am logged into the CMS$/
	 **/
	public function stepIAmLoggedIntoTheCMS() {
		$this->stepILogInWith('sam@silverstripe.com', 'password');
		$this->natural->visit("admin");
	}

	/**
	* When /^I log in with "([^"]*)" and "([^"]*)"$/
	**/
	public function stepILogInWith($email,$password) {
		$this->session->open($this->site->baseURL() . "Security/login");
		
		$this->natural->visit("Security/login");
		$this->natural->field("Email")->setTo($email);
		$this->natural->field("Password")->setTo($password);
		$this->natural->button("Log in")->click();
	}

	/**
	* Then /^I will see a bad log\-in message$/
	**/
	public function stepIWillSeeABadLogInMessage() {
		$this->assertTrue($this->natural->textIsVisible("That doesn't seem to be the right e-mail address or password"));
	}


	/**
	 * When /^I click "([^"]*)" in the CMS menu$/
	 **/
	public function stepIClickParameterInTheCMSMenu($arg1) {
		$this->natural->panel('#cms-menu')->link($arg1)->click();
	}

	/**
	 * When /^I click "([^"]*)" in the tree$/
	 **/
	public function stepIClickParameterInTheTree($arg1) {
		self::markPending();
	}

}