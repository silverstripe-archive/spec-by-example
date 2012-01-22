<?php

/**
 * Steps relating to the CMS: Page UI
 */
class PageUISteps extends WebDriverSteps {

	/**
	 * Given /^I am editing the "([^"]*)" page$/
	 **/
	public function stepIAmEditingTheParameterPage($pageName) {
		$cms = new CMSSteps();
		$cms->stepIAmLoggedIntoTheCMS();
		$this->natural->visit('admin/pages');
		$this->stepIClickParameterInTheTree($pageName);
	}

	/**
	 * Then /^I see a form for editing the "([^"]*)" page$/
	 **/
	public function stepISeeAFormForEditingTheParameterPage($pageName) {
		$this->assertEquals($pageName, trim($this->natural->wd()->element('id', 'page-title-heading')->text()));
		$this->assertEquals($pageName, trim($this->natural->field('Page name')->text()));
	}

	/**
	 * When /^I save the page$/
	 **/
	public function stepISaveThePage() {
		$this->natural->button('Save Draft')->click();
	}

	/**
	 * Then /^I see a saved changes message$/
	 **/
	public function stepISeeASavedChangesMessage() {
		// This currently fails
		//self::markPending();
	}

	/**
	 * When /^I click "([^"]*)" in the tree$/
	 **/
	public function stepIClickParameterInTheTree($pageName) {
		// Check each link in the tree, looking at it's span.item text, so as to ignore the lozenges
		foreach($this->natural->wd()->elements('css selector', '#cms-content-treeview div.cms-tree a .item') as $candidate) {
			if(trim($candidate->text()) == $pageName) {
				$natural = new NaturalWebDriver_Element($candidate, $this->natural->wd());
				$natural->click();
				return;
			}
		}
		throw new LogicException("Couldn't find '$pageName' in the CMS tree.");
	}

	/**
	 * When /^I open the "([^"]*)" page$/
	 */
	public function stepIOpenTheParameterPage() {
		// Shortcut for navigating to the pages section and opening a page
		// TODO Inheriting steps confuses cuke4php (complains about duplicates)
		$cmsSteps = new CMSSteps();
		$cmsSteps->stepIClickParameterInTheCMSMenu('Pages');
		sleep(1);
		$this->stepIClickParameterInTheTree('About Us');
	}

	/**
	 * Then /^I can see the "([^"]*)" panel$/
	 */
	public function stepICanSeeTheParameterPanel($panel) {
		if($panel == 'preview') {
			$selector = '.cms-preview';
		} else {
			throw new LogicException("Couldn't find selector for '$panel' panel");
		}

		$el = $this->natural->wd()->element('css selector', $selector);
		if(!$el) throw new LogicException("Couldn't find '$panel' panel element");

		$this->assertTrue($el->displayed());
	}


}