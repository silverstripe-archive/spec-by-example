Feature: Create a page
  As an site owner
  I want to access to the CMS to be secure
  So that only my team can make content changes
  
  Scenario: Bad login
    When I log in with "bad@example.com" and "badpassword"
    Then I will see a bad log-in message
    And if I visit admin
    Then I will be redirected to Security/login