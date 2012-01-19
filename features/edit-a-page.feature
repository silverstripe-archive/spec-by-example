Feature: Edit a page
  As an author
  I want to edit a page in the CMS
  So that I correct errors and provide new information
  
  Scenario: I can open a page for editing from the pages tree
    Given I am logged into the CMS
    And an "About Us" page exists
    When I click "Pages" in the CMS menu
    And I click "About Us" in the tree
    Then I see a form for editing the "About Us" page

  Scenario: I can open a page for editing by navigating the site
    Given I am logged into the CMS
    And I visit the "About Us" page
    When I click the "Edit page" in the CMS menu
    Then I see a form for editing the "About Us" page
    
  Scenario: I can edit title and content and see the changes on draft
    Given I am editing the "About Us" page
    Then I can see a "Title" field
    And I can see a "Content" field
    When I put "my new content" into the "Content" field
    And I save the page
    Then I see a saved changes message
    When I visit the "About Us" draft page
    Then I can see the content "my new content"