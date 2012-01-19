<?php

/**
 * Steps relating to visiting the front-end site
 */
class FrontEndUISteps extends WebDriverSteps {

	/**
	 * When /^I visit the "([^"]*)" draft page$/
	 **/
	public function stepIVisitTheParameterDraftPage($arg1) {
		self::markPending();
	}

	/**
	 * When /^I visit the "([^"]*)" published page$/
	 **/
	public function stepIVisitTheParameterPublishedPage($arg1) {
		self::markPending();
	}

	/**
	 * Given /^I visit the "([^"]*)" page$/
	 **/
	public function stepIVisitTheParameterPage($arg1) {
		self::markPending();
	}

}