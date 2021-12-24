Feature: Package

  Scenario: I can see a package page

    Given I go to the page "/package/show/name/firefox"
    Then I should see "Package : firefox"
    Then I should see "Package details"
    Then I should see "Summary: Mozilla Firefox Web browser"
    Then I should see "Mozilla Firefox is an open-source web browser"
    Then I should see "List of RPMs"
    Then I should see "firefox-38.7.0-1.mga5.i586.rpm"
    When I click on the link "firefox-38.7.0-1.mga5.i586.rpm"
    Then the url should contain "/rpm/show/name/firefox-38.7.0-1.mga5.i586.rpm/source/0/release/5/arch/i586/t_media/4"
    Then I should see "Basic items"
    Then I should see "103MB"
    Then I should see "Firefox claims to offer a more secure web browsing experience than other products"
    Then I should see "Media information"
    Then I should see "core-updates"
    Then I should see "i586"
    Then I should see "2016-03-07 22:20:32"
    Then I should see "View in Sophie"
