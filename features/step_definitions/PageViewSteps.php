<?php

// This provides a WebDriverSteps base class that gives you $this->session (for WebDriver) and $this->site->baseURL()
require_once "WebDriverSteps.php";

class BasicSteps  extends WebDriverSteps {
	
	/**
	 * Given /^I visit (http[^ ]+)/
	 **/
	public function stepIVisitURL($url) {
		$this->assertInstanceOf('WebDriverSession', $this->session);
		$this->session->open($url);
	}

	/**
	 * Given /^I wait (.*) seconds$/
	 **/
	public function stepIWaitNSeconds($seconds) {
		sleep($seconds);
	}
	
}

class PageViewSteps extends WebDriverSteps {

	

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
	* Given /^an "([^"]*)" page exists$/
	**/
	public function stepAnParameterPageExists($arg1) {
	self::markPending();
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


	/**
	* Then /^I see a form for editing the "([^"]*)" page$/
	**/
	public function stepISeeAFormForEditingTheParameterPage($arg1) {
	self::markPending();
	}


	/**
	* Given /^I visit the "([^"]*)" page$/
	**/
	public function stepIVisitTheParameterPage($arg1) {
	self::markPending();
	}


	/**
	* When /^I click the "([^"]*)" in the CMS menu$/
	**/
	public function stepIClickTheParameterInTheCMSMenu($arg1) {
	self::markPending();
	}


	/**
	* Given /^I am editing the "([^"]*)" page$/
	**/
	public function stepIAmEditingTheParameterPage($arg1) {
	self::markPending();
	}


	/**
	* Then /^I can see a "([^"]*)" field$/
	**/
	public function stepICanSeeAParameterField($arg1) {
	self::markPending();
	}


	/**
	* When /^I put "([^"]*)" into the "([^"]*)" field$/
	**/
	public function stepIPutParameterIntoTheParameterField($arg1,$arg2) {
	self::markPending();
	}


	/**
	* When /^I save the page$/
	**/
	public function stepISaveThePage() {
	self::markPending();
	}


	/**
	* Then /^I see a saved changes message$/
	**/
	public function stepISeeASavedChangesMessage() {
	self::markPending();
	}


	/**
	* When /^I visit the "([^"]*)" draft page$/
	**/
	public function stepIVisitTheParameterDraftPage($arg1) {
	self::markPending();
	}


	/**
	* Then /^I can see the content "([^"]*)"$/
	**/
	public function stepICanSeeTheContentParameter($arg1) {
	self::markPending();
	}
}
