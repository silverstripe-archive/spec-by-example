Feature: Search for a page
  As an author
  I want to search for a page in the CMS
  So that I can efficiently navigate nested content structures
  
  Scenario: I can search for a page by its title
    Given I am logged into the CMS
    And an "About Us" page exists
    When I click "Pages" in the CMS menu
    And I put "About Us" into the "Content" field in the "Search" form
    And I click the "Search" button
    Then I see a "About Us" node in the tree
    And I don't see a "Contact Us" node in the tree