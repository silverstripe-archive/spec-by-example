<?php

/**
 * These are basic steps that apply to many different web UIs.  Be careful not to over-use these as they may
 * turn your specifications into unintelligible scripts.
 */
class BasicSteps extends WebDriverSteps {
	
	/**
	 * Given /^I visit (http[^ ]+)/
	 **/
	public function stepIVisitURL($url) {
		// Absolutize URL if necessary
		if(!preg_match('/^[a-z]+:/', $url)) $url = $this->site->baseURL() . $url;
		$this->session->open($url);
	}

	/**
	 * Given /^I wait (.*) seconds$/
	 **/
	public function stepIWaitNSeconds($seconds) {
		sleep($seconds);
	}


	/**
	 * Then /^I can see the content "([^"]*)"$/
	 **/
	public function stepICanSeeTheContentParameter($arg1) {
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

}
