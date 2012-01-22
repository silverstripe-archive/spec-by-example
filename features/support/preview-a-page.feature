Feature: Preview a page
  As an author
  I want to preview the page I'm editing in the CMS
  So that I can see how it would look like to my visitors

  Scenario: I can show a preview of the current page from the pages section
  Given I am logged into the CMS
		And I open the "About Us" page
		And I click the "Preview »" link
  Then I can see the "preview" panel
  	And I wait 2 seconds
  	And the preview contains "About Us"