<?php

global $_WEBDRIVER_SESSION, $_CUCUMBER_SITEINFO;

/**
 * Use this to define steps that require a webdriver session.
 */
abstract class WebDriverSteps extends CucumberSteps {
  protected $session, $site;

	public function __construct() {
		global $_WEBDRIVER_SESSION, $_CUCUMBER_SITEINFO;
		$this->site = $_CUCUMBER_SITEINFO;

		// This needs to be in a global to prevent re-instantiation
		if(!$_WEBDRIVER_SESSION) {
			start_webdriver_session();
			global $_WEBDRIVER_SESSION;
		}
		$this->session = $_WEBDRIVER_SESSION;
	}
}