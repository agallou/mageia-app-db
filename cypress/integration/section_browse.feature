Feature: Browse

  Scenario: I can go to the groups page

    Given I go to the page "/"
    When I click on the link "Groups"
    Then I should see "Education : 49"
    Then I should see "Games : 352"


  Scenario: I can go to the groups page with a filter on the package

    Given I go to the page "/"
    When I click on the link "Groups"
    And I fill in the search package field with "test"
    And I click on the package search button
    Then I should see " Current filter: test"
    Then I should see "Education : 2"
    Then I should see "Games : 3"

  Scenario: I can go to the groups page with a global filter change

    Given I go to the page "/"
    When I click on the link "Groups"
    And I click on the "Distribution" filter
    And I click on the "Mageia 3" filter value
    Then I should see "Education : 38"
    Then I should see "Games : 264"
