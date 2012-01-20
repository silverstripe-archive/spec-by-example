<?php

global $_WEBDRIVER_SESSION, $_CUCUMBER_SITEINFO;

/**
 * Use this to define steps that require a webdriver session.
 */
abstract class WebDriverSteps extends CucumberSteps {
  protected $session, $natural, $site;

	public function __construct() {
		global $_WEBDRIVER_SESSION, $_CUCUMBER_SITEINFO;
		$this->site = $_CUCUMBER_SITEINFO;

		// This needs to be in a global to prevent re-instantiation
		if(!$_WEBDRIVER_SESSION) {
			start_webdriver_session();
			global $_WEBDRIVER_SESSION;
		}
		$this->session = $_WEBDRIVER_SESSION;
		$this->natural = new NaturalWebDriver($this->session, $this->site);
	}
	
	/**
	 * Split a value into keypresses
	 */
	public function split_keys($value) {
		$payload = array("value" => preg_split("//u", $value, -1, PREG_SPLIT_NO_EMPTY));
		return $payload;
	}
}