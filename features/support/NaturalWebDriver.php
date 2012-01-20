<?php

/**
 * A more natural way of driving the browser
 * 
 *   $natural->field("Email")->type("me@example.com");
 *   $natural->field("Password")->type("mypassword");
 *   $natural->button("Log in")->click();
 *   $natural->panel("#cms-menu")->link("Users")->click();
 * 
 * It has the following feautres
 *  - Elements are looked up by their on-screen names, not IDs
 *  - Ajax clicks are automatically waited for (as long as Prototype or jQuery is used)
 */
class NaturalWebDriver {
	protected $session, $site, $el;
	
	/**
	 * Create a new NaturalWebDriver object
	 * @param $session A WebDriverSession from Facebook's php-webdriver
	 * @param $site A SiteInformation object with info about the site
	 * @param $el NaturalWebDriver works as both a full session handler and a sub-container handler
	 */
	function __construct($session, $site, $el = null) {
		$this->session = $session;
		$this->el = $el ? $el : $session;
		$this->site = $site;
	}
	
	/**
	 * Return the underlyling php-webdriver session.
	 * Handy if you want to do something not supported by the NaturalWebDriverAPI
	 */
	function wd() {
		return $this->el;
	}
	
	/**
	 * Visit a URL
	 */
	function visit($url) {
		// Absolutize URL if necessary
		if(!preg_match('/^[a-z]+:/', $url)) $url = $this->site->baseURL() . $url;
		$this->session->open($url);
	}
	
	/**
	 * Return a field by its label
	 */
	function field($label) {
		try {
			$label = $this->el->element("xpath", "//label[text()='$label']");
		} catch(NoSuchElementWebDriverError $e) { $label = null; }
		if(!$label) {
			throw new LogicException("Can't find a field label with text '$label'");
		}
		
		$id = $label->attribute('for');
		try {
			$el = $this->el->element("id", $id);
		} catch(NoSuchElementWebDriverError $e) { $el = null; }
		
		if(!$el) throw new LogicException("Can't find a field for the '$label' (expected ID: $id)");
		return new NaturalWebDriver_Element($el, $this->session);
	}
	
	/**
	 * Return a button by its text
	 */
	function button($label) {
		try {
			$el = $this->el->element("xpath", "//input[@type='submit' and @value='$label']");
		} catch(NoSuchElementWebDriverError $e) { $el = null; }
		if(!$el) throw new LogicException("Can't find a button labelled '$label'");
		return new NaturalWebDriver_Element($el, $this->session);
	}
	
	/**
	 * Return a link by its text
	 */
	function link($label) {
		try {
			$el = $this->el->element("link text", $label);
		} catch(NoSuchElementWebDriverError $e) {
			$el = null;
			// Slower method of finding an element; ignore spaces, etc.
			$simplifiedLabel = preg_replace('/ +/',' ',strtolower($label));
			
			$potentialEls = $this->el->elements("xpath", "//a");
			foreach($potentialEls as $potentialEl) {
				$simplifiedTestText = preg_replace('/ +/',' ',strtolower(trim($potentialEl->text())));
				if($simplifiedTestText == $simplifiedLabel) {
					$el = $potentialEl;
					break;
				}
			}
		}
		
		if(!$el) throw new LogicException("Can't find a link labelled '$label'");
		return new NaturalWebDriver_Element($el, $this->session);
	}
	
	/**
	 * Return a reference to a sub-panel of the page, chosen by CSS selector
	 */
	function panel($cssSelector) {
		$el = $this->el->element('css selector', $cssSelector);
		return new NaturalWebDriver($this->session, $this->site, $el);
	}
	
	/**
	 * Returns true if the given text is visible.
	 * Ignores whitespace and case differences.
	 *
	 * @todo This could be assertTextIsVisible and throw an assertion failure error with the actual text
	 */
	function textIsVisible($text) {
		// If we're in the top session, not a panel, then we need to get the body element.
		$el = ($this->el == $this->session) ? $this->el->element('xpath','//body') : $this->el;
		
		$currentText = strtolower(preg_replace('/[\t\n\r ]+/', ' ',$el->text()));
		$testText = strtolower(preg_replace('/[\t\n\r ]+/', ' ',$text));
		
		return strpos($currentText, $testText) !== false;
	}
	
	/**
	 * Returns the current url of the browser, relativised if possible.
	 */
	function currentURL() {
		$url = $this->session->url();
		$baseURL = $this->site->baseURL();
		if(substr($url,0,strlen($baseURL)) == $baseURL) $url = substr($url, strlen($baseURL));
		return $url;
	}
	
	/**
	 * Returns true if the current URL is close enough to the given URL.
	 *  - Unless specified in $url, get vars will be ignored
	 *  - Unless specified in $url, fragment identifiers will be ignored
	 */
	function isCurrentURLSimilarTo($url) {
		$current = parse_url($this->currentURL());
		$current['vars'] = array();
		if(empty($current['fragment'])) $current['fragment'] = null;
		if(!empty($current['query'])) parse_str($current['query'], $current['vars']);

		$test = parse_url($url);
		$test['vars'] = array();
		if(empty($test['fragment'])) $test['fragment'] = null;
		if(!empty($test['query'])) parse_str($test['query'], $test['vars']);
		
		if($current['path'] != $test['path']) return false;
		
		if($test['fragment'] && ($current['fragment'] != $test['fragment'])) return false;
		
		foreach($test['vars'] as $k => $v) {
			if(!isset($current['vars'][$k]) || $current['vars'][$k] != $v) return false;
		}
		
		return true;
	}
}

class NaturalWebDriver_Element {
	protected $el;
	protected $session;
	
	function __construct(WebDriverElement $el, WebDriverSession $session) {
		$this->el = $el;
		$this->session = $session;
	}
	
	/**
	 * Return the underlyling php-webdriver element
	 * Handy if you want to do something not supported by the NaturalWebDriverAPI
	 */
	function wd() {
		return $this->el;
	}

	/**
	 * Click a button
	 * @todo Automatically wait for ajax actions to complete.
	 */
	function click() {
		$support = new NaturalWebDriver_Support($this->session);
		$support->ajaxClickHandler_before();
		$this->el->click();
		$support->ajaxClickHandler_after();
	}

	/**
	 * Set a field to a value, ensuring that it is empty first.
	 */
	function setTo($value) {
		$this->el->clear();
		$this->el->value($this->split_keys($value));
	
	/**
	 * Returns the current value
	 */
	function text() {
		$text = trim($this->el->text());
		if($text == "") $text = $this->el->attribute('value');
		return $text;
	}
	
	/**
	 * Returns the value of the given attribute
	 */
	function attribute($attrName) {
		return $this->el->attribute($attrName);
	}


	/**
	 * Split a value into keypresses
	 */
	public function split_keys($value) {
		$payload = array("value" => preg_split("//u", $value, -1, PREG_SPLIT_NO_EMPTY));
		return $payload;
	}
}

/**
 * Helpers for NWD
 */
class NaturalWebDriver_Support {
	protected $session;
	function __construct($session) {
		$this->session = $session;
	}
	
	// TODO: This needs to be stress tested.
	function ajaxClickHandler_before() {
			$javascript = <<<JS
      window.__ajaxStatus = function() { return 'no ajax'; };

      if(typeof window.__ajaxPatch == 'undefined') {
        window.__ajaxPatch = 1;

        var patchedList = "";

        /* Monkey-patch Prototype */
        if(typeof window.Ajax!='undefined' && typeof window.Ajax.Request!='undefined') {
          window.Ajax.Request.prototype.initialize = function(url, options) {
            this.transport = window.Ajax.getTransport();

            var __activeTransport = this.transport;
            window.__ajaxStatus = function() {
              return (__activeTransport.readyState == 4) ? 'success' : 'waiting';
            };

            this.setOptions(options);
            this.request(url);
          };
          patchedList += " prototype";
        }

        /* Monkey-patch jQuery */
        if(typeof window.jQuery!='undefined') {
          var _orig_ajax = window.jQuery.ajax;

          window.jQuery(window).ajaxStop(function() {
            window.__ajaxStatus = function() { return 'success'; };
          });

          window.jQuery.ajax = function(s) {
            window.__ajaxStatus = function() { return 'waiting'; };
            _orig_ajax(s);
          };
          patchedList += " jquery";
        }
        return "patched" + patchedList;
      } else {
        return "already patched: " + window.__ajaxPatch;
      }
JS;
		$this->session->execute(array(
			'script' => $javascript, 
			'args' => array(),
		));
	}

	function ajaxClickHandler_after() {
		$response = 'waiting';
		while($response == 'waiting') {
			$response = $this->session->execute(array(
				"script" => "return window.__ajaxStatus ? window.__ajaxStatus() : 'no ajax';", 
				"args" => array(),
			));
			//echo $response . "\n";
			if($response == 'waiting') usleep(100*1000);
		}
	}

}