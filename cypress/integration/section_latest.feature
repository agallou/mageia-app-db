Feature: Latest

  Scenario: I can go to the updates page

    Given I go to the page "/"
    When I click on the link "Updates"
    Then I should see a list of 50 packages
    Then I should see "1-50 of 263."
    Then I should see "phpmyadmin"
    Then I should see "Handles the administration of MySQL over the web"
    Then I should see "4.4.15.5"
    Then I should see "2016-03-02"
    Then I should see "1.2.mga5"

  Scenario: I can go to the updates candidate page

    Given I go to the page "/"
    When I click on the link "Update candidates"
    Then I should see a list of 14 packages
    Then I should see "dolphin-emu"
    Then I should see "GameCube/Wii emulator"

  Scenario: I can go to the backports page

    Given I go to the page "/"
    When I click on the link "Backports"
    Then I should see a list of 3 packages
    Then I should see "owncloud-client"
    Then I should see "The ownCloud Client"

  Scenario: I can go to the backports candidates page

    Given I go to the page "/"
    When I click on the link "Backport candidates"
    Then I should see "Backports awaiting your testing"
    Then I should see a list of 7 packages
    Then I should see "remmina"
    Then I should see "GTK+ remote desktop client"
