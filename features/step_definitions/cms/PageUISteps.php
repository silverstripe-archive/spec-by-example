<?php

/**
 * Steps relating to the CMS: Page UI
 */
class PageUISteps extends WebDriverSteps {

	/**
	 * Given /^I am editing the "([^"]*)" page$/
	 **/
	public function stepIAmEditingTheParameterPage($arg1) {
		self::markPending();
	}

	/**
	 * Then /^I see a form for editing the "([^"]*)" page$/
	 **/
	public function stepISeeAFormForEditingTheParameterPage($arg1) {
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
	
}