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

# Il a des erreurs JS en faisant cela, on ajoute donc pas de test pour le moment
#  Scenario: I can go to the groups page with a filter that is on "more" and as a search field
#
#    Given I go to the page "/"
#    When I click on the link "Groups"
#    When I click on more filters
#    And I click on the "Group" filter


  Scenario: I can go to the "packages/applications" page and test the pagination

    Given I go to the page "/"
    When I click on the link "Packages/Applications"
    Then I should see a list of 50 applications
    Then I should see "1-50 of 1943."
    Then I should see "0ad : Cross-Platform RTS Game of Ancient Warfare"
    Then I should see "arduino : An IDE for Arduino-compatible electronics prototyping platforms"
    When I click on the link "2"
    Then I should see a list of 50 applications
    Then I should see " 51-100 of 1943."
    Then I should see "areca-backup : Java based backup utility"
    Then I should see "basic256 : Simple BASIC IDE that allows young children to learn programming"
    When I click on the next pagination link
    Then I should see a list of 50 applications
    Then I should see "101-150 of 1943."
    Then I should see "basket : BasKet for KDE"
    Then I should see "brutalchess : A 3D chess game inspired by Battle Chess"
    When I click on the latest pagination link
    Then I should see a list of 43 applications
    Then I should see " 1901-1943 of 1943."
    Then I should see "xpenguins : Cute little penguins that walk along the tops of your windows"
    Then I should see "zynaddsubfx : Real-time MIDI software synthesizer"
