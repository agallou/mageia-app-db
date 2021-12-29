Feature: Homepage

  Scenario: The homepage works well

    Given I go to the page "/"
    Then I should see "Welcome to Mageia App Db"
    Then I should see "Synchronized from"
