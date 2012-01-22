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
	 * Then /^I (can|cannot) see the content "([^"]*)"$/
	 **/
	public function stepICanSeeTheContentParameter($maybe, $text) {
		$assert = ($maybe == 'can') ? 'assertTrue' : 'assertFalse';
		$this->$assert($this->natural->textIsVisible($text));
	}

	/**
	 * Then /^I can see the headline "([^"]*)"$/
	 */
	public function stepICanSeeTheHeadlineParameter($content) {
		$matched = false;
		foreach(range(1,6) as $level) {
			$headers = $this->natural->wd()->elements('css selector', 'h' . $level);
			foreach($headers as $header) {
				if(trim($header->text()) == $content) $matched = true;
			}			
		}
		
		if(!$matched) throw new LogicException("Couldn't find '$content' in preview panel");
	}

	/**
	 * Then /^I can see a "([^"]*)" field in the "([^"]*)" form$/
	 **/
	public function stepICanSeeAParameterFieldInTheParameterForm($field, $form) {
		$this->stepICanSeeAParameterField($field, $form);
	}

	/**
	 * Then /^I can see a "([^"]*)" field$/
	 **/
	public function stepICanSeeAParameterField($field, $form = null) {
		try {
			$this->natural->field($field, $form);
			$success = true;
		} catch(LogicException $e) {
			$success = false;
		}
		$this->assertTrue($success);
	}

	/**
	 * When /^I put "([^"]*)" into the "([^"]*)" field in the "([^"]*)" form$/
	 **/
	public function stepIPutParameterIntoTheParameterFieldInTheParameterForm($value, $field, $form) {
		$this->stepIPutParameterIntoTheParameterField($value, $field, $form);
	}

	/**
	 * When /^I put "([^"]*)" into the "([^"]*)" field$/
	 **/
	public function stepIPutParameterIntoTheParameterField($value, $field, $form = null) {
		$this->natural->field($field, $form)->setTo($value);
	}

	/**
	 * When /^I click the "([^"]*)" button$/
	 **/
	public function stepIClickTheParameterButton($buttonName) {
		$this->natural->button($buttonName)->click();
	}

	/**
	 * When /^I click the "([^"]*)" link$/
	 */
	 public function stepIClickOnTheParameterLink($link) {
	 	$this->natural->link($link)->click();
	 }

}