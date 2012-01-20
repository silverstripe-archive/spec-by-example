<?php

/**
 * Steps relating to visiting the front-end site
 */
class FrontEndUISteps extends WebDriverSteps {

	/**
	 * When /^I visit the "([^"]*)" draft page$/
	 **/
	public function stepIVisitTheParameterDraftPage($pageName) {
		$this->natural->visit('about-us/?stage=Stage');
	}

	/**
	 * When /^I visit the "([^"]*)" published page$/
	 **/
	public function stepIVisitTheParameterPublishedPage($pageName) {
		$this->natural->visit('about-us/?stage=Live');
	}

	/**
	 * Given /^I visit the "([^"]*)" page$/
	 **/
	public function stepIVisitTheParameterPage($pageName) {
		$this->natural->visit('about-us/?stage=Live');
	}

}