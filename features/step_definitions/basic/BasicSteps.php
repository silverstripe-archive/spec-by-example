<?php

/**
 * These are basic steps that apply to many different web UIs.  Be careful not to over-use these as they may
 * turn your specifications into unintelligible scripts.
 */
class BasicSteps extends WebDriverSteps {

	/**
	 * Clear the session each time
	 */
	public function beforeAll() {
		$this->session->deleteAllCookies();
	}
	
	
	/**
	 * Given /^(if )?I visit ([^ ]+)$/
	 **/
	public function stepIVisitURL($dummy1, $url) {
		$this->natural->visit($url);
	}
	
	
	/**
	 * Then /^I will be redirected to ([^ ]+)/
	 **/
	public function stepIWillBeRedirectedTo($url) {
		echo $this->natural->currentURL() . ", " , $url . "\n";
		$this->assertTrue($this->natural->isCurrentURLSimilarTo($url));
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
	public function stepICanSeeTheContentParameter($text) {
		$this->assertTrue($this->natural->textIsVisible($text));
	}


	/**
	 * Then /^I can see a "([^"]*)" field$/
	 **/
	public function stepICanSeeAParameterField($field) {
		try {
			$this->natural->field($field);
			$success = true;
		} catch(LogicException $e) {
			$success = false;
		}
		$this->assertTrue($success);
	}


	/**
	 * When /^I put "([^"]*)" into the "([^"]*)" field$/
	 **/
	public function stepIPutParameterIntoTheParameterField($value, $field) {
		$this->natural->field($field)->setTo($value);
	}

}