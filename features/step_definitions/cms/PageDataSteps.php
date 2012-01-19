<?php

/**
 * Steps relating CMS: Page Data
 */
class PageDataSteps extends WebDriverSteps {
	
	/**
	 * Given /^an "([^"]*)" page exists$/
	 **/
	public function stepAnParameterPageExists($arg1) {
		self::markPending();
	}

}