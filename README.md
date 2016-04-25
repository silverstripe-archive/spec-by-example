**This is an archived project and is no longer supported or updated by SilverStripe.
Please do not file issues or pull-requests against this repo. 
If you wish to continue to develop this code yourself, 
we recommend you fork it or contact the maintainers directly
(check latest commits for email addresses).**

# Specification by Example with cuke4php and php-webdriver

**EXPERIMENTAL** This approach has been replaced by the [SilverStripe Behat Extension](https://github.com/silverstripe-labs/silverstripe-behat-extension/)

## Introduction

The book, [Specification by Example](http://specificationbyexample.com/key_ideas.html), provides more justification about _why_ we set out our test automation in this in way.  In essence, the idea is to start by writing the specification of what's required for a particular Story as a set of examples, and to codify those examples as a Cucumber feature, which can later be automated.

The readability of the Cucumber features (by the business, not just by devs) is therefore just as important as the test automation itself.

Sometimes, readability goals and test goals will come into conflict: for example, you may wish to add an exhaustive list of every edge case.  Unless describing these edge cases.  In practise, this could be as simple as a different set of feature files; or, it could be a PHPUnit test.

## Pieces of the puzzle

In brief:

 * [cuke4php](https://github.com/olbrich/cuke4php) is a version of Cucumber that supports PHP
 * Cuke4php starts by reading "feature files".  These are in effect scripts, but they should be written first and foremost as illustrative examples of how a feature is supposed to work.  Ideally, you can sit down with the client and write these before the feature has been build.
 * Each line of a feature file's scenario is matched to a "step".  The steps are provided in `features/step_definitions` as a set of classes inheriting from CucumberSteps (or WebDriverSteps).
 * Steps are matched according to the regular expressions provided in the docblock header of the method.  Portions of the regular expression in parentheses are passed as arguments to the method.
 * CucumberSteps is a PHPUnit test case so you can use PHPUnit assertion commands to report success and/or failure.
 * The WebDriverSteps base class will provide you with $this->session, which is a WebDriverSession object, on which you can call commands to drive a browser.  You can also use $this->site->baseURL() so as not to hard-code absolute URLs in your tests.

With all of this, you can start writing tests in business-readable language that use the browser to test. Hurray!

There are some things that it doesn't yet do:

 * It doesn't manage databases and fixtures for you.
 * The webdriver code is fairly verbose (the library is deliberately designed to be as thin a layer on top of the selenium wire protocol) and we can probably make a layer on top of that which does some of the things that salad did (like automatically identify ajax clicks and look up form fields by label)

## Getting started

As well as this package, you will need to download/install:

 * [cuke4php](https://github.com/olbrich/cuke4php) (as a custom gem with an not-yet-released fix) 
 * php5's sockets extension
 * [Selenium's standalone server](http://code.google.com/p/selenium/downloads/list)
 * [Facebook's php-webdriver library](https://github.com/facebook/php-webdriver)] (bundled with this repository)

These commands will do this for you on OS X:

	# This has an unreleased fix in it so I rebundled the gem
	sudo gem install cuke4php-0.9.10c.gem
	# If you use MacPorts, do this. If you don't use MacPorts, figure out another way of doing this
	sudo port install php5-sockets
	wget http://selenium.googlecode.com/files/selenium-server-standalone-2.17.0.jar
	# Get Chrome webdriver
	wget http://chromium.googlecode.com/files/chromedriver_mac_18.0.995.0.zip
	unzip chromedriver_mac_18.0.995.0.zip -d /usr/local/bin && rm chromedriver_mac_18.0.995.0.zip

## Running tests

### Starting the selenium server

You can either run the server in a separate Terminal tab:

	java -jar selenium-server-standalone-2.17.0.jar

Or you can run it in the background:

	java -jar selenium-server-standalone-2.17.0.jar > /dev/null &

### Running the tests

You will have a binary on your system, `cuke4php`.  The "cucumber" binary doesn't work, although they share all the same command-line options.

	cuke4php features/test.feature

By default, this will use Chrome (requires [ChromeDriver](http://code.google.com/p/selenium/wiki/ChromeDriver)) and test	`http://localhost/silverstripe/`.  
To use a different browser or base URL, you can set environment variables (no linebreaks allowed):

	CUKE4PHP_BASE_URL=http://localhost/mysite/ CUKE4PHP_BROWSER=firefox cuke4php features/test.feature

The following environment variables are supported:

 * `CUKE4PHP_BASE_URL`: The base URL of your site.
 * `CUKE4PHP_BROWSER`: The browser to use for testing: use 'firefox', 'chrome', 'internet explorer'.  Safari isn't supported.

## Improvements to make
	
 * It would be better if selenium-server-standalone-2.17.0.jar was packaged as OS X / Debian service.  Alternatively, the PHP code in features/support/Env.php could start a server up, and shut it down at the end of a test run, although start-up time may make tests unreliable.

In addition, cuke4php relies on our old friend, PHPUnit.
