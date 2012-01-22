<?php

/**
 * Steps relating CMS: Page preview
 */
class PagePreviewSteps extends WebDriverSteps {
	
	/**
	 * When /^I open the preview$/
	 */
	public function stepIOpenThePreview() {
		// Assumes we're in a page edit view
		$stepBasic = new BasicSteps();
		$stepBasic->stepIClickOnTheParameterLink('Preview »');
		$this->natural->wd()->frame(array('id' => 'cms-preview-iframe'));
	}

	/**
	 * When /^I close the preview$/
	 */
	public function stepICloseThePreview() {
		// Assumes the preview is open
		$stepBasic = new BasicSteps();
		$stepBasic->stepIClickOnTheParameterLink('« Edit');
		$this->natural->wd()->frame(); // Change session back to standard frame
	}

}