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
			$wd = new WebDriver();
			$_WEBDRIVER_SESSION = $wd->session($this->site->browser());
			register_shutdown_function('end_webdriver_session');
		}
		$this->session = $_WEBDRIVER_SESSION;
	}
}

function end_webdriver_session($session) {
	global $_WEBDRIVER_SESSION;
	/*$session->close();
	if($session != $_WEBDRIVER_SESSION)*/ $_WEBDRIVER_SESSION->close();
}