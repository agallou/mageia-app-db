Feature: Latest

  Scenario: I can go to the updates pages

    Given I go to the page "/"
    When I click on the link "Updates"
    Then I should see a list of 50 packages
    Then I should see "1-50 of 263."
    Then I should see "phpmyadmin"
    Then I should see "Handles the administration of MySQL over the web"
    Then I should see "4.4.15.5"
    Then I should see "2016-03-02"
    Then I should see "1.2.mga5"
