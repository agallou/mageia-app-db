Feature: Search

  Scenario: I can search for a query that returns only one page

    Given I go to the page "/"
    Then I fill in "t_search" with "jabber"
    And I click on the button "search"
    Then I should see "gajim"
    When I click on the link "Show all packages"
    Then I should see "asterisk-plugins-jabber"
