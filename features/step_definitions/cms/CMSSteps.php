<?php

/**
 * Steps relating the to the general behavior of the CMS
 */
class CMSSteps extends WebDriverSteps {

	/**
	 * Given /^I am logged into the CMS$/
	 **/
	public function stepIAmLoggedIntoTheCMS() {
		$this->session->open($this->site->baseURL() . "Security/login");
		$this->session->element("id", "MemberLoginForm_LoginForm_Email")->value(array('value' => array('sam@silverstripe.com') ));
		$this->session->element("id", "MemberLoginForm_LoginForm_Password")->value(array('value' => array('password') ));
		$this->session->element("id", "MemberLoginForm_LoginForm_action_dologin")->click();
		$this->session->open($this->site->baseURL() . "admin");
	}

	/**
	 * When /^I click "([^"]*)" in the CMS menu$/
	 **/
	public function stepIClickParameterInTheCMSMenu($arg1) {
		self::markPending();
	}

	/**
	 * When /^I click "([^"]*)" in the tree$/
	 **/
	public function stepIClickParameterInTheTree($arg1) {
		self::markPending();
	}

}