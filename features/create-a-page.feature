Feature: Create a page
  As an author
  I want to create a page in the CMS
  So that I can grow my website

  Scenario: I can create a page from the pages section
  Given I am logged into the CMS
  When I toggle "Pages" in the CMS menu
  When I click "Add pages" in the CMS menu
  And I click the "Create" button
  Then I see a form for editing the "New Page" page