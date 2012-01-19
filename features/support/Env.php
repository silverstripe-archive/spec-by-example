<?php

/**
 * load the PHPUnit framework, try to load the new version first
 * then the older one.
 */ 
@include_once "PHPUnit/Autoload.php";	
@include_once "PHPUnit/Framework.php";
require_once "php-webdriver/__init__.php";

// Initialise the site info from the environment variable
global $_CUCUMBER_SITEINFO;


if($baseURL = getenv('CUKE4PHP_BASE_URL')) {
	if(substr($baseURL,-1) !='/') $baseURL .= '/';
	$_CUCUMBER_SITEINFO = new SiteInformation($baseURL);

} else {
	$_CUCUMBER_SITEINFO = new SiteInformation('http://localhost/silverstripe/');
}

if($browser = getenv('CUKE4PHP_BROWSER')) {
	$_CUCUMBER_SITEINFO->setBrowser($browser);
}

/**
 * Class for keeping track of specific information about the site that we're testing.
 * Right now, this is just its base URL, but we can add to this in time.
 */
class SiteInformation {
	protected $baseURL;
	protected $browser = "chrome";
	
	function __construct($baseURL) {
		$this->baseURL = $baseURL;
	}
	function setBrowser($browser) {
		$this->browser = strtolower($browser);
	}

	function baseURL() {
		return $this->baseURL;
	}
	function browser() {
		return $this->browser;
	}
}

?>